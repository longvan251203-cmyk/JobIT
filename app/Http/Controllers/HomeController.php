<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JobPost;
use App\Models\HocVan;
use App\Models\KinhNghiem;
use App\Models\JobRecommendation;
use App\Models\AIJobRecommendation;
use App\Models\Applicant;
use App\Models\Application;
use App\Models\Company;
use App\Services\AI\AIRecommendationService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $jobs = JobPost::with(['company', 'hashtags', 'detail'])
            ->where('status', 'active')
            ->where('deadline', '>=', now()->toDateString())
            ->whereRaw('(recruitment_count = 0 OR recruitment_count > (
                SELECT COUNT(*) FROM applications 
                WHERE applications.job_id = job_post.job_id 
                AND applications.trang_thai = "duoc_chon"
            ))')
            ->orderBy('created_at', 'desc')
            ->paginate(8);

        // Lấy top công ty có nhiều việc làm nhất
        $topCompanies = JobPost::with('company')
            ->select('companies_id', DB::raw('COUNT(*) as job_count'))
            ->where('status', 'active')
            ->where('deadline', '>=', now()->toDateString())
            ->groupBy('companies_id')
            ->orderBy('job_count', 'desc')
            ->limit(6)
            ->get()
            ->map(function ($item) {
                return [
                    'company' => $item->company,
                    'job_count' => $item->job_count,
                ];
            });

        return view('home', [
            'jobs' => $jobs,
            'topCompanies' => $topCompanies,
            'showLogin' => $request->get('showLogin', false),
        ]);
    }

    // Phương thức Dashboard của Applicant
    public function applicantDashboard(Request $request)
    {
        // ✅ Lấy jobs với pagination
        $jobs = JobPost::with(['company', 'hashtags', 'detail'])
            ->active()
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        // ✅ Tính tổng jobs còn tuyển (loại bỏ đã đủ số lượng)
        $allActiveJobs = JobPost::active()->get();
        $availableJobs = $allActiveJobs->filter(function ($job) {
            $selectedCount = $job->selected_count ?? 0;
            $recruitmentCount = $job->recruitment_count ?? 0;
            // Chỉ tính những job chưa đủ số lượng
            return !($recruitmentCount > 0 && $selectedCount >= $recruitmentCount);
        });

        // ✅ CẬP NHẬT: Lấy dữ liệu thực từ database
        $stats = [
            // Tổng công việc đang hoạt động (loại bỏ đã đủ số lượng)
            'total_jobs' => $availableJobs->count(),

            // Tổng công ty có công việc
            'total_companies' => JobPost::active()
                ->distinct('companies_id')
                ->count('companies_id'),

            // ✅ THÊM: Tổng ứng viên đã hoàn thành hồ sơ
            'total_applicants' => Applicant::whereNotNull('hoten_uv')
                ->whereNotNull('sdt_uv')
                ->count(),

            // ✅ THÊM: Tổng hồ sơ ứng tuyển
            'total_applications' => Application::count(),
        ];

        // ✅ Top Companies
        $topCompanies = JobPost::with('company')
            ->select('companies_id', DB::raw('COUNT(*) as job_count'))
            ->active()
            ->groupBy('companies_id')
            ->orderBy('job_count', 'desc')
            ->limit(12)
            ->get()
            ->map(function ($item) {
                return [
                    'company' => $item->company,
                    'job_count' => $item->job_count,
                ];
            });

        // ✅ AI Recommended Jobs (NEW)
        $recommendedJobs = null;
        if (Auth::check() && Auth::user()->applicant) {
            $applicantId = Auth::user()->applicant->id_uv;
            $recommendedJobs = JobRecommendation::where('applicant_id', $applicantId)
                ->where('score', '>=', 60)
                ->orderBy('score', 'desc')
                ->with('job.company', 'job.hashtags')
                ->paginate(6);
        }

        return view('applicant.homeapp', [
            'jobs' => $jobs,
            'stats' => $stats,
            'topCompanies' => $topCompanies,
            'recommendedJobs' => $recommendedJobs,
        ]);
    }
}

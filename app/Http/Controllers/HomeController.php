<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JobPost;
use App\Models\HocVan;
use App\Models\KinhNghiem;
use App\Models\JobRecommendation;
use App\Models\Applicant;
use App\Models\Application;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $jobs = JobPost::with(['company', 'hashtags', 'detail'])->get();

        return view('home', [
            'jobs' => $jobs,
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

        // ✅ CẬP NHẬT: Lấy dữ liệu thực từ database
        $stats = [
            // Tổng công việc đang hoạt động
            'total_jobs' => JobPost::active()->count(),

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

        // ✅ Recommended Jobs
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

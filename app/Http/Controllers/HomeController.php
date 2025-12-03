<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JobPost;
use App\Models\HocVan;
use App\Models\KinhNghiem;
use App\Models\JobRecommendation;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $jobs = JobPost::with(['company', 'hashtags', 'detail'])->get();

        // Trả về home.blade.php cho route gốc '/'
        return view('home', [
            'jobs' => $jobs,
            'showLogin' => $request->get('showLogin', false),
        ]);
    }

    // Phương thức Dashboard của Applicant
    public function applicantDashboard(Request $request)
    {
        // ✅ Sử dụng scope ->active()
        $jobs = JobPost::with(['company', 'hashtags', 'detail'])
            ->active() // 🎯 THAY 2 DÒNG WHERE BẰNG 1 SCOPE
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $stats = [
            'total_jobs' => JobPost::active()->count(), // 🎯 DÙNG SCOPE
            'total_companies' => JobPost::active()      // 🎯 DÙNG SCOPE
                ->distinct('companies_id')
                ->count('companies_id'),
            'total_applicants' => 15000,
            'satisfaction_rate' => 98,
        ];

        $topCompanies = JobPost::with('company')
            ->select('companies_id', DB::raw('COUNT(*) as job_count'))
            ->active() // 🎯 DÙNG SCOPE
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

        // ✅ THÊM PHẦN NÀY - Recommended Jobs
        $recommendedJobs = collect();

        if (Auth::check() && Auth::user()->applicant) {
            $applicantId = Auth::user()->applicant->id_uv; // hoặc id tùy theo cấu trúc model của bạn

            $recommendedJobs = JobRecommendation::where('applicant_id', $applicantId)
                ->where('score', '>=', 60)
                ->orderBy('score', 'desc')
                ->with('job.company', 'job.hashtags')
                ->take(6)
                ->get();
        }

        return view('applicant.homeapp', [
            'jobs' => $jobs,
            'stats' => $stats,
            'topCompanies' => $topCompanies,
            'recommendedJobs' => $recommendedJobs, // ✅ Thêm dòng này
        ]);
    }
}

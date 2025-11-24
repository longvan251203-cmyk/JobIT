<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JobPost;
use App\Models\HocVan;
use App\Models\KinhNghiem;
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
        // ✅ Phân trang jobs - 12 items/page
        $jobs = JobPost::with(['company', 'hashtags', 'detail'])
            ->where('status', 'active') // Chỉ lấy job đang active
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        // ✅ Thống kê
        $stats = [
            'total_jobs' => JobPost::where('status', 'active')->count(),
            'total_companies' => JobPost::distinct('companies_id')->count('companies_id'),
            'total_applicants' => 15000, // Hoặc lấy từ DB
            'satisfaction_rate' => 98,
        ];

        // ✅ Top 12 công ty (theo số lượng job)
        $topCompanies = JobPost::with('company')
            ->select('companies_id', DB::raw('COUNT(*) as job_count'))
            ->where('status', 'active')
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

        // ✅ Blog posts (nếu có bảng blogs)
        // $blogs = Blog::latest()->take(6)->get();

        return view('applicant.homeapp', [
            'jobs' => $jobs,
            'stats' => $stats,
            'topCompanies' => $topCompanies,
            // 'blogs' => $blogs,
        ]);
    }
}

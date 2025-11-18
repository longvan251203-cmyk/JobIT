<?php

namespace App\Http\Controllers;

use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployerDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $employer = $user->employer;

        if (!$employer || !$employer->company) {
            return redirect()->route('employer.dashboard')->with('error', 'Vui lòng hoàn thiện thông tin công ty');
        }

        $company = $employer->company;

        // Lấy danh sách job posts của công ty
        $jobPosts = JobPost::where('companies_id', $company->companies_id)
            ->with('detail')
            ->orderBy('job_id', 'desc')
            ->get();

        // Lấy thống kê
        $stats = [
            'total_jobs' => $jobPosts->count(),
            'active_jobs' => $jobPosts->where('deadline', '>=', now())->count(),
            'total_views' => 0, // Có thể tính sau nếu có bảng views
            'total_applicants' => 0, // Có thể tính sau nếu có bảng applications
        ];

        return view('employer.home', compact('company', 'jobPosts', 'stats'));
    }

    public function getJobPosts()
    {
        $user = Auth::user();
        $employer = $user->employer;

        if (!$employer || !$employer->company) {
            return response()->json([
                'success' => false,
                'error' => 'Không tìm thấy thông tin công ty'
            ]);
        }

        $jobPosts = JobPost::where('companies_id', $employer->company->companies_id)
            ->with('detail')
            ->orderBy('job_id', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'jobs' => $jobPosts
        ]);
    }
}

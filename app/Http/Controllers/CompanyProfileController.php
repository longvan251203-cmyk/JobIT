<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use App\Models\JobPost;
use App\Models\NhanVienCty;

class CompanyProfileController extends Controller
{
    /**
     * Hiển thị trang profile công ty
     */
    public function show($companies_id)
    {
        // Lấy thông tin công ty
        $company = Company::findOrFail($companies_id);

        // Lấy danh sách việc làm đang tuyển (chưa hết hạn)
        $jobs = JobPost::where('companies_id', $companies_id)
            ->where('deadline', '>=', now())
            ->orderBy('job_id', 'desc')
            ->get();

        // Lấy danh sách nhân viên công ty
        $recruiters = NhanVienCty::where('companies_id', $companies_id)->get();

        // Đếm số lượng việc làm
        $jobCount = $jobs->count();

        // Đếm số người theo dõi (tạm thời set cứng, sau sẽ có table followers)
        $followerCount = 0;

        return view('employer.company-profile', compact(
            'company',
            'jobs',
            'recruiters',
            'jobCount',
            'followerCount'
        ));
    }

    /**
     * Preview profile từ dashboard (cho employer xem trước)
     */
    public function preview()
    {
        $user = Auth::user();

        // Employer của user
        $employer = $user->employer;

        if (!$employer || !$employer->company) {
            return redirect()->route('employer.dashboard')
                ->with('error', 'Vui lòng cập nhật thông tin công ty trước');
        }

        $company = $employer->company;
        $companies_id = $company->companies_id;

        // Redirect đến trang profile công ty
        return redirect()->route('company.profile', ['companies_id' => $companies_id]);
    }
}

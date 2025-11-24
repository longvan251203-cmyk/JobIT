<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\CompanyController;

// ==================== TRANG CHỦ ====================
Route::get('/', [HomeController::class, 'index'])->name('home');

// ==================== XÁC THỰC (AUTH) ====================
// Đăng nhập
Route::get('/login', function () {
    return redirect()->route('home', ['showLogin' => true]);
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Đăng ký
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

// Đăng xuất
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/logout', [AuthController::class, 'logout']);

// Welcome page (sau khi đăng nhập)
Route::get('/welcome', [AuthController::class, 'welcome'])
    ->name('welcome')
    ->middleware('auth');

// ==================== DASHBOARD ====================
// Applicant Dashboard - Gọi phương thức mới đã sửa trong HomeController
Route::get('/applicant-dashboard', [HomeController::class, 'applicantDashboard'])
    ->name('applicant.dashboard')
    ->middleware('auth');

// Employer Dashboard

Route::get('/employer-dashboard', [CompanyController::class, 'edit'])
    ->name('employer.dashboard')
    ->middleware('auth');

// ==================== JOB (CÔNG VIỆC) ====================
// Chi tiết công việc
Route::get('/job/{id}', [JobController::class, 'show'])->name('job.detail');

// ==================== APPLICANT (ỨNG VIÊN) ====================
Route::prefix('applicant')->middleware(['auth'])->group(function () {

    // Hồ sơ cá nhân
    Route::get('/profile', [ApplicantController::class, 'showProfileDetail'])->name('applicant.profile');
    Route::get('/hoso', [ApplicantController::class, 'showProfileDetail'])->name('applicant.hoso');
    Route::post('/hoso/update', [ApplicantController::class, 'updateProfile'])->name('applicant.update');

    // Cập nhật giới thiệu
    Route::post('/hoso/update-gioithieu', [ApplicantController::class, 'updateGioiThieu'])
        ->name('applicant.updateGioiThieu');

    // Học vấn
    Route::post('/hocvan/store', [ApplicantController::class, 'storeHocVan'])
        ->name('applicant.hocvan.store');





    // Xóa avatar
    Route::get('/delete-avatar', [ApplicantController::class, 'deleteAvatar'])
        ->name('applicant.deleteAvatar');

    // CV (Curriculum Vitae)
    Route::post('/upload-cv', [ApplicantController::class, 'uploadCv'])
        ->name('applicant.uploadCv');
    Route::get('/view-cv', [ApplicantController::class, 'viewCv'])
        ->name('applicant.viewCv');
    Route::get('/delete-cv', [ApplicantController::class, 'deleteCv'])
        ->name('applicant.deleteCv');
    Route::get('/{id}/download-cv', [ApplicantController::class, 'downloadCV'])
        ->name('applicant.downloadCV');

    // Jobs đã ứng tuyển
    Route::get('/applied-jobs', function () {
        return view('applicant.applied_jobs');
    })->name('applicant.applied.jobs');
});
// nhà tuyển dụng
// Đăng ký nhà tuyển dụng
Route::get('/register/employer', [App\Http\Controllers\EmployerAuthController::class, 'showRegistrationForm'])->name('employer.register');
Route::post('/register/employer', [App\Http\Controllers\EmployerAuthController::class, 'register'])->name('employer.register.submit');
Route::post('/employer/login', [App\Http\Controllers\EmployerAuthController::class, 'login'])->name('employer.login');



Route::middleware('auth')->group(function () {
    Route::get('/company/edit', [CompanyController::class, 'edit'])->name('company.edit');
});
Route::post('/company/update', [CompanyController::class, 'update'])
    ->name('company.update')
    ->middleware('auth');
Route::put('/company/contact/update', [CompanyController::class, 'updateContact'])
    ->name('company.updateContact');
Route::post('/recruiter/store', [CompanyController::class, 'storeRecruiter'])->name('recruiter.store');
Route::put('/recruiter/update/{id}', [CompanyController::class, 'updateRecruiter'])
    ->name('recruiter.update')
    ->middleware('auth');
Route::delete('/recruiter/delete/{id}', [CompanyController::class, 'deleteRecruiter'])
    ->name('recruiter.delete')
    ->middleware('auth');



Route::middleware(['auth'])->group(function () {
    Route::get('/employer/postjob', [JobController::class, 'create'])->name('employer.postjob');
    Route::post('/post-job', [JobController::class, 'store'])->name('job.store');
});
// ============ THÊM VÀO web.php ============
Route::middleware(['auth'])->group(function () {
    // ... các route khác

    // Job management routes
    Route::get('/employer/postjob', [JobController::class, 'create'])->name('employer.postjob');
    Route::post('/post-job', [JobController::class, 'store'])->name('job.store');
    Route::delete('/job/{id}/delete', [JobController::class, 'destroy'])->name('job.delete');
});
// Thêm vào file routes/web.php

use App\Http\Controllers\CompanyProfileController;

// Route công khai - Xem profile công ty (cho mọi người)
Route::get('/company/{companies_id}/profile', [CompanyProfileController::class, 'show'])
    ->name('company.profile');

// Route cho employer - Preview profile của mình (chỉ cần auth)
Route::middleware(['auth'])->group(function () {
    Route::get('/employer/company/preview', [CompanyProfileController::class, 'preview'])
        ->name('company.preview');
});
// routes/api.php hoặc web.php
Route::get('/api/jobs/{id}', [JobController::class, 'getJobDetail']);


// Học vấn - CRUD đầy đủ
Route::middleware(['auth'])->group(function () {
    Route::post('/hocvan/store', [ApplicantController::class, 'storeHocVan'])->name('hocvan.store');
    Route::get('/hocvan/{id}/edit', [ApplicantController::class, 'editHocVan'])->name('hocvan.edit');
    Route::post('/hocvan/{id}/update', [ApplicantController::class, 'updateHocVan'])->name('hocvan.update');
    Route::delete('/hocvan/{id}/delete', [ApplicantController::class, 'deleteHocVan'])->name('hocvan.delete');
});
// Routes cho Application (Thêm vào file routes/web.php)

use App\Http\Controllers\ApplicationController;


Route::middleware(['auth'])->group(function () {
    // Route ứng tuyển công việc
    Route::post('/apply-job', [ApplicationController::class, 'store'])->name('application.store');
});
// viec lam cua toi
Route::middleware(['auth'])->group(function () {
    // Trang việc làm của tôi
    Route::get('/my-jobs', [ApplicantController::class, 'myJobs'])->name('applicant.myJobs');

    // Lưu/Bỏ lưu công việc
    Route::post('/job/save/{jobId}', [ApplicantController::class, 'saveJob'])->name('job.save');
    Route::delete('/job/unsave/{jobId}', [ApplicantController::class, 'unsaveJob'])->name('job.unsave');

    // Hủy ứng tuyển
    Route::delete('/application/{applicationId}/cancel', [ApplicationController::class, 'cancel'])->name('application.cancel');
});
// Routes cho Save Job (yêu cầu đăng nhập)
Route::middleware(['auth'])->group(function () {
    // ... các routes khác ...

    // Save/Unsave Job
    Route::post('/job/save/{jobId}', [ApplicantController::class, 'saveJob'])->name('job.save');
    Route::delete('/job/unsave/{jobId}', [ApplicantController::class, 'unsaveJob'])->name('job.unsave');
    Route::get('/api/saved-jobs', [ApplicantController::class, 'getSavedJobIds'])->name('job.saved.ids');
});
// Route lấy thông tin job để edit
Route::get('/job/{id}/edit', [JobController::class, 'edit'])->name('job.edit');

// Route cập nhật job
// Thay đổi từ Route::post() sang Route::put()
Route::put('/job/{id}/update', [JobController::class, 'update'])->name('job.update');
// Thêm các routes sau vào group middleware employer


// ==================== EMPLOYER - QUẢN LÝ ỨNG VIÊN ====================
// Quản lý ứng viên cho từng tin đăng
// ==================== EMPLOYER - QUẢN LÝ ỨNG VIÊN ====================
// BỎ middleware 'employer' vì chưa được định nghĩa
Route::middleware(['auth'])->group(function () {
    Route::get('/job/{job_id}/applicants', [ApplicationController::class, 'jobApplicants'])->name('job.applicants');
    Route::post('/application/{id}/update-status', [ApplicationController::class, 'updateStatus'])->name('application.updateStatus');
    Route::get('/application/{id}/view-cv', [ApplicationController::class, 'viewCV'])->name('application.viewCV');
    Route::post('/application/{id}/add-note', [ApplicationController::class, 'addNote'])->name('application.addNote');
    Route::get('/application/{id}/download-cv', [ApplicationController::class, 'downloadCV'])->name('application.downloadCV');
});
// Route tìm kiếm hashtags (cho autocomplete)
Route::get('/api/jobs/{id}', [JobController::class, 'getJobDetail']);
Route::get('/api/hashtags/search', [JobController::class, 'searchHashtags'])
    ->name('hashtags.search');


Route::prefix('applicant')->middleware(['auth'])->group(function () {
    // Ngoại ngữ
    Route::post('/ngoai-ngu/store', [ApplicantController::class, 'storeNgoaiNgu'])
        ->name('applicant.storeNgoaiNgu');

    // ✅ Sửa route này - bỏ prefix /applicant
    Route::post('/ngoai-ngu/{id}/delete', [ApplicantController::class, 'deleteNgoaiNgu'])
        ->name('applicant.deleteNgoaiNgu');
});
// dự án
Route::post('/applicant/duan/store', [ApplicantController::class, 'storeDuAn'])->name('duan.store');
// Route
Route::get('/duan/{id}/edit', [ApplicantController::class, 'editDuAn'])->name('duan.edit');
Route::post('/duan/{id}/update', [ApplicantController::class, 'updateDuAn'])->name('duan.update');
Route::delete('/duan/{id}/delete', [ApplicantController::class, 'deleteDuAn'])->name('duan.delete');
// chứng chỉ
Route::middleware(['auth'])->group(function () {
    // Chứng chỉ routes
    Route::post('/chungchi/store', [ApplicantController::class, 'storeChungChi'])->name('chungchi.store');
    Route::get('/chungchi/{id}/edit', [ApplicantController::class, 'editChungChi'])->name('chungchi.edit');
    Route::post('/chungchi/{id}/update', [ApplicantController::class, 'updateChungChi'])->name('chungchi.update');
    Route::delete('/chungchi/{id}/delete', [ApplicantController::class, 'deleteChungChi'])->name('chungchi.delete');
});

// Giải thưởng routes
Route::post('/giaithuong/store', [ApplicantController::class, 'storeGiaiThuong'])->name('giaithuong.store');
Route::get('/giaithuong/{id}/edit', [ApplicantController::class, 'editGiaiThuong'])->name('giaithuong.edit');
Route::post('/giaithuong/{id}/update', [ApplicantController::class, 'updateGiaiThuong'])->name('giaithuong.update');
Route::delete('/giaithuong/{id}', [ApplicantController::class, 'deleteGiaiThuong'])->name('giaithuong.delete');
// ============ KỸ NĂNG - ĐẶT Ở CUỐI FILE, NGOÀI TẤT CẢ CÁC GROUP ============
Route::middleware(['auth'])->group(function () {
    // Lưu kỹ năng mới
    Route::post('/applicant/ky-nang/store', [ApplicantController::class, 'storeKyNang'])
        ->name('applicant.storeKyNang');

    // Xóa kỹ năng - RETURN JSON
    Route::post('/applicant/ky-nang/{id}/delete', [ApplicantController::class, 'deleteKyNang'])
        ->name('applicant.deleteKyNang');
});
// Thêm vào phần Applicant routes trong web.php
Route::middleware(['auth'])->group(function () {
    // Kinh nghiệm làm việc - CRUD đầy đủ
    Route::post('/kinhnghiem/store', [ApplicantController::class, 'storeKinhnghiem'])->name('kinhnghiem.store');
    // web.php
    Route::get('/kinhnghiem/{id}/edit', [ApplicantController::class, 'editKinhnghiem'])
        ->name('kinhnghiem.edit');
    Route::post('/kinhnghiem/{id}/update', [ApplicantController::class, 'updateKinhnghiem'])->name('kinhnghiem.update');
    Route::delete('/kinhnghiem/{id}/delete', [ApplicantController::class, 'deleteKinhnghiem'])->name('kinhnghiem.delete');
});
// ==================== EMPLOYER - QUẢN LÝ ỨNG VIÊN ====================
Route::middleware(['auth'])->group(function () {
    // Danh sách ứng viên theo công việc
    Route::get('/job/{job_id}/applicants', [ApplicationController::class, 'jobApplicants'])
        ->name('job.applicants');

    // ✅ Xem CV
    Route::get('/application/{id}/view-cv', [ApplicationController::class, 'viewCV'])
        ->name('application.viewCV');

    // ✅ Gửi lời mời phỏng vấn
    Route::post('/application/{id}/send-interview', [ApplicationController::class, 'sendInterviewInvitation'])
        ->name('application.sendInterview');

    // ✅ Từ chối ứng viên
    Route::post('/application/{id}/reject', [ApplicationController::class, 'rejectApplication'])
        ->name('application.reject');

    // ✅ Cập nhật trạng thái
    Route::post('/application/{id}/update-status', [ApplicationController::class, 'updateStatus'])
        ->name('application.updateStatus');

    // Thêm ghi chú
    Route::post('/application/{id}/add-note', [ApplicationController::class, 'addNote'])
        ->name('application.addNote');

    // Download CV
    Route::get('/application/{id}/download-cv', [ApplicationController::class, 'downloadCV'])
        ->name('application.downloadCV');
    // ✅ ROUTE MỚI - GỬI EMAIL KẾT QUẢ PHỎNG VẤN
    Route::post('/application/{id}/send-result-email', [ApplicationController::class, 'sendResultEmail']);
});
// Route Dashboard
Route::get('/applicant-dashboard', [HomeController::class, 'applicantDashboard'])
    ->name('applicant.dashboard')
    ->middleware('auth');
// Kiểm tra trạng thái ứng tuyển
Route::get('/api/jobs/{id}/check-application', [JobController::class, 'checkApplicationStatus']);

// Lấy danh sách job đã ứng tuyển
Route::get('/api/applied-jobs', [JobController::class, 'getAppliedJobIds']);
Route::get('/api/jobs', [JobController::class, 'getJobsPaginated']);

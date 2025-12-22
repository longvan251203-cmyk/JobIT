<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ApplicantController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// ✅ SEARCH & FILTER - PHẢI ĐẶT TRƯỚC các route có tham số
Route::get('/jobs/search', [JobController::class, 'searchJobs']);
Route::get('/jobs/count/total', [\App\Http\Controllers\Api\JobApiController::class, 'getTotalCount']);

// ✅ Route lấy danh sách jobs với phân trang
Route::get('/jobs', [JobController::class, 'getJobsPaginated']);

// ✅ Route lấy chi tiết job (đặt SAU)
Route::get('/jobs/{id}', [JobController::class, 'getJobDetail']);

// ✅ Check application status
Route::get('/jobs/{id}/check-application', [JobController::class, 'checkApplicationStatus']);

// ✅ Get applied jobs (yêu cầu auth hoặc trả về empty nếu guest)
Route::get('/applied-jobs', [JobController::class, 'getAppliedJobIds']);

// ✅ Get user invitations
Route::get('/job-invitations', [JobController::class, 'getUserInvitations']);

// ✅ Get pending invitations count
Route::get('/invitations/pending-count', [JobController::class, 'getPendingInvitationCount']);

// ✅ Get saved jobs (yêu cầu auth hoặc trả về empty nếu guest)
Route::get('/saved-jobs', [ApplicantController::class, 'getSavedJobIds']);

// ✅ Get applicant's CV info (for apply modal) - with web middleware for session auth
Route::middleware('web')->group(function () {
    Route::get('/applicant-cv', [ApplicantController::class, 'getApplicantCV']);
});

// ✅ Hashtag search (cho autocomplete)
Route::get('/hashtags/search', [JobController::class, 'searchHashtags']);
// ✅ Job Invitation - Respond (accept/reject)
Route::post('/job-invitations/{id}/respond', [JobController::class, 'respondToInvitation']);

// =============================================================================
// AI RECOMMENDATION API
// =============================================================================
Route::prefix('ai')->group(function () {

    // ✅ Public: Test & Stats
    Route::get('/test', [\App\Http\Controllers\Api\AIRecommendationController::class, 'testConnection']);
    Route::get('/stats', [\App\Http\Controllers\Api\AIRecommendationController::class, 'getStatistics']);
    Route::post('/demo/analyze', [\App\Http\Controllers\Api\AIRecommendationController::class, 'demoAnalyze']);

    // ✅ Applicant: Cần đăng nhập
    Route::middleware('web')->group(function () {
        // Tạo recommendations cho ứng viên
        Route::post('/recommendations/generate', [\App\Http\Controllers\Api\AIRecommendationController::class, 'generateForApplicant']);

        // Lấy danh sách recommendations
        Route::get('/recommendations', [\App\Http\Controllers\Api\AIRecommendationController::class, 'getApplicantRecommendations']);

        // Phân tích 1 job cụ thể
        Route::get('/analyze/{jobId}', [\App\Http\Controllers\Api\AIRecommendationController::class, 'analyzeJobMatch']);

        // Refresh recommendations
        Route::post('/recommendations/refresh', [\App\Http\Controllers\Api\AIRecommendationController::class, 'refreshApplicantRecommendations']);
    });

    // ✅ Employer: Cần đăng nhập nhà tuyển dụng
    Route::prefix('employer')->middleware('web')->group(function () {
        // Tạo AI recommendations cho công ty
        Route::post('/recommendations/generate', [\App\Http\Controllers\Api\AIRecommendationController::class, 'generateForEmployer']);

        // Refresh AI recommendations
        Route::post('/recommendations/refresh', [\App\Http\Controllers\Api\AIRecommendationController::class, 'refreshEmployerRecommendations']);

        // Tìm ứng viên cho job
        Route::post('/find-candidates/{jobId}', [\App\Http\Controllers\Api\AIRecommendationController::class, 'findCandidatesForJob']);

        // Lấy danh sách ứng viên đã recommend
        Route::get('/candidates', [\App\Http\Controllers\Api\AIRecommendationController::class, 'getCompanyCandidates']);

        // Phân tích ứng viên cụ thể
        Route::get('/analyze/{applicantId}/{jobId}', [\App\Http\Controllers\Api\AIRecommendationController::class, 'analyzeCandidate']);
    });
});

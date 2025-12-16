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

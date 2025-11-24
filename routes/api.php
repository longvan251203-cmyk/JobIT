<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\JobApiController;
use App\Http\Controllers\ApplicantController;

// ✅ Route lấy danh sách jobs với phân trang (phải đặt TRƯỚC route có tham số)
Route::get('/jobs', [JobApiController::class, 'index']);

// ✅ Route lấy chi tiết job (đặt SAU)
Route::get('/jobs/{id}', [JobApiController::class, 'show']);
// api.php
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/saved-jobs', [ApplicantController::class, 'getSavedJobIds']);
});

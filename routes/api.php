<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;

Route::get('/jobs/{id}', [JobController::class, 'getJobJson']);

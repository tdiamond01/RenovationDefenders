<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\VideoController;
use App\Http\Controllers\Api\ProgressController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Authentication
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Courses
    Route::get('/courses', [CourseController::class, 'index']);
    Route::get('/courses/{id}', [CourseController::class, 'show']);

    // Videos
    Route::get('/videos/{id}', [VideoController::class, 'show']);
    Route::get('/courses/{courseId}/videos', [VideoController::class, 'index']);

    // Progress
    Route::post('/videos/{id}/progress', [ProgressController::class, 'update']);
    Route::get('/progress', [ProgressController::class, 'index']);
    Route::get('/courses/{id}/progress', [ProgressController::class, 'courseProgress']);

    // Admin routes (optional - admin functions accessible via web interface)
    // Route::middleware('admin')->prefix('admin')->group(function () {
    //     // Add admin API endpoints here if needed in the future
    // });
});

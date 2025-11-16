<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Video routes
    Route::get('/videos', [\App\Http\Controllers\VideoController::class, 'index'])->name('videos.index');
    Route::get('/videos/{id}', [\App\Http\Controllers\VideoController::class, 'show'])->name('videos.show');
    Route::get('/videos/{id}/stream', [\App\Http\Controllers\VideoController::class, 'stream'])->name('videos.stream');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('courses', \App\Http\Controllers\Admin\CourseController::class);
    Route::resource('videos', \App\Http\Controllers\Admin\VideoController::class);

    // User course assignment routes
    Route::get('users/{id}/courses', [\App\Http\Controllers\Admin\UserController::class, 'courses'])->name('users.courses');
    Route::post('users/{id}/courses', [\App\Http\Controllers\Admin\UserController::class, 'assignCourse'])->name('users.assign-course');
    Route::delete('users/{userId}/courses/{courseId}', [\App\Http\Controllers\Admin\UserController::class, 'unassignCourse'])->name('users.unassign-course');

    // Course video management routes
    Route::get('courses/{id}/videos', [\App\Http\Controllers\Admin\CourseController::class, 'videos'])->name('courses.videos');
    Route::post('courses/{id}/videos/add', [\App\Http\Controllers\Admin\CourseController::class, 'addVideo'])->name('courses.add-video');
    Route::post('courses/{id}/videos/create', [\App\Http\Controllers\Admin\CourseController::class, 'createVideo'])->name('courses.create-video');
    Route::delete('courses/{courseId}/videos/{videoId}/remove', [\App\Http\Controllers\Admin\CourseController::class, 'removeVideo'])->name('courses.remove-video');
    Route::delete('courses/{courseId}/videos/{videoId}/delete', [\App\Http\Controllers\Admin\CourseController::class, 'deleteVideo'])->name('courses.delete-video');
});

require __DIR__.'/auth.php';

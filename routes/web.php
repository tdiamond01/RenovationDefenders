<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    // Redirect admins to admin panel
    if (auth()->user()->ROLE === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    $videos = \App\Models\Video::where('IS_ACTIVE', true)->orderBy('ORDER')->get();
    return view('dashboard', compact('videos'));
})->middleware(['auth', 'verified'])->name('dashboard');

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
});

require __DIR__.'/auth.php';

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

    // Catalog (Shop) routes for users
    Route::get('/shop', [\App\Http\Controllers\CatalogController::class, 'index'])->name('catalog.index');
    Route::get('/shop/{id}', [\App\Http\Controllers\CatalogController::class, 'show'])->name('catalog.show');

    // Cart routes
    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [\App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [\App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
    Route::get('/checkout', [\App\Http\Controllers\CartController::class, 'checkout'])->name('cart.checkout');
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

    // Catalog (Products) management routes
    Route::resource('catalog', \App\Http\Controllers\Admin\CatalogController::class);
    Route::get('catalog/{id}/prices', [\App\Http\Controllers\Admin\CatalogController::class, 'prices'])->name('catalog.prices');
    Route::post('catalog/{id}/prices', [\App\Http\Controllers\Admin\CatalogController::class, 'addPrice'])->name('catalog.add-price');
    Route::delete('catalog/{productId}/prices/{priceId}', [\App\Http\Controllers\Admin\CatalogController::class, 'deletePrice'])->name('catalog.delete-price');
});

require __DIR__.'/auth.php';

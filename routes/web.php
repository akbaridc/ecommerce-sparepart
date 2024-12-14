<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Frontstore\HomepageController;


Route::name('frontstore.')->group(function () {
    Route::get('/', [HomepageController::class, 'index'])->name('homepage');
    Route::get('category/{slug}', [HomepageController::class, 'index'])->name('category');

    Route::get('product/{slug}/{productSlug}', [HomepageController::class, 'product'])->name('product');
});


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->prefix('backoffice')->name('backoffice.')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('banner')->name('banner.')->controller(BannerController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show', 'show')->name('show');
        Route::post('/', 'store')->name('store');
        Route::post('/update', 'update')->name('update');
        Route::delete('{banner}', 'destroy')->name('destroy');
        Route::delete('destroy/all', 'destroyAll')->name('destroyAll');
    });

    Route::resource('category', CategoryController::class);
    Route::resource('product', ProductController::class);
});

require __DIR__ . '/auth.php';

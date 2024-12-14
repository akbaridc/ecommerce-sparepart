<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Frontstore\HomepageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;


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

    Route::resource('category', CategoryController::class);
    Route::resource('product', ProductController::class);
});

require __DIR__ . '/auth.php';

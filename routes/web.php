<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SitesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Frontstore\HomepageController;
use App\Http\Controllers\Frontstore\CheckoutController;
use App\Http\Controllers\TransactionController;

Route::name('frontstore.')->controller(HomepageController::class)->group(function () {
    Route::controller(HomepageController::class)->group(function () {
        Route::get('/', 'index')->name('homepage');
        Route::get('category/{slug}', 'index')->name('category');

        Route::get('product/{slug}/{productSlug}', 'product')->name('product');

        Route::get('pesanan', 'pesanan')->name('pesanan');
        Route::get('notifikasi', 'notifikasi')->name('notifikasi');
        Route::get('akun', 'akun')->name('akun');
    });

    Route::controller(CheckoutController::class)->group(function () {
        Route::get('/cart', 'cart')->name('cart');
        Route::post('/cart/show', 'cartShow')->name('cart.show');

        Route::get('/checkout', 'checkout')->name('checkout');
        Route::post('/checkout/store', 'checkoutStore')->name('checkout.store');
    });
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
        Route::post('restore/deleted', 'restore')->name('restore');
    });

    Route::resource('category', CategoryController::class);
    Route::post('category/restore/deleted', [CategoryController::class, 'restore'])->name('category.restore');
    Route::resource('product', ProductController::class);
    Route::post('product/restore/deleted', [ProductController::class, 'restore'])->name('product.restore');

    Route::prefix('site')->name('site.')->controller(SitesController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/edit', 'edit')->name('edit');
        Route::post('/update', 'update')->name('update');
    });

    Route::prefix('transaction')->name('transaction.')->controller(TransactionController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{order}/show', 'show')->name('show');
    });
});

require __DIR__ . '/auth.php';

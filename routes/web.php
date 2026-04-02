<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ShopController::class, 'home'])->name('home');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login.form');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login');

    Route::middleware('admin.auth')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', DashboardController::class)->name('dashboard');

        Route::resource('products', ProductController::class)
            ->only(['index', 'store', 'update', 'destroy']);

        Route::resource('sales', SaleController::class)
            ->only(['index', 'store']);
    });
});

Route::prefix('shop')->name('shop.')->group(function () {
    Route::get('/', [ShopController::class, 'home'])->name('home');
    Route::get('/categories', [ShopController::class, 'categories'])->name('categories');
    Route::get('/cart', [ShopController::class, 'cart'])->name('cart');
    Route::post('/cart/add/{product}', [ShopController::class, 'addToCart'])->name('cart.add');
    Route::patch('/cart/{product}', [ShopController::class, 'updateCart'])->name('cart.update');
    Route::delete('/cart/{product}', [ShopController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/checkout/whatsapp', [ShopController::class, 'checkoutWhatsapp'])->name('checkout.whatsapp');
    Route::get('/orders', [ShopController::class, 'orders'])->name('orders');
});

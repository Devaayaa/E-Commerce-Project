<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AboutController;

// ==========================================
// AUTENTIKASI
// ==========================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Route Google Login
Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');

// ==========================================
// RUTE PELANGGAN (CUSTOMER) — publik
// ==========================================
Route::get('/', [CustomerController::class, 'home'])->name('home');
Route::get('/shop', [CustomerController::class, 'shop'])->name('shop');
Route::get('/category', [CustomerController::class, 'categories'])->name('categories');
Route::get('/contact', [CustomerController::class, 'contact'])->name('contact');
Route::get('/about', [AboutController::class, 'index'])->name('about');

// Keranjang (disimpan di session, boleh diakses tanpa login)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');

// ==========================================
// RUTE PELANGGAN — wajib login
// ==========================================
Route::middleware('auth')->group(function () {
    // Checkout hanya untuk pelanggan
    Route::middleware('role:customer')->group(function () {
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
        Route::get('/checkout/{product}', [CheckoutController::class, 'show'])->name('checkout.show');
        Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    });

    // Pelacakan: pelanggan pemilik pesanan, penjual, kurir terkait, dan admin
    // Parameter {order_id} opsional (bisa diakses seperti /lacak/ORD-2026-ABC123)
    Route::get('/lacak/{order_id}/lokasi', [CustomerController::class, 'trackingLocation'])->name('tracking.location');
    Route::get('/lacak/{order_id?}', [CustomerController::class, 'tracking'])->name('tracking');
});

// ==========================================
// RUTE KURIR (COURIER)
// ==========================================
Route::middleware(['auth', 'role:courier'])->prefix('kurir')->name('courier.')->group(function () {
    Route::get('/dashboard', [CourierController::class, 'dashboard'])->name('dashboard');
    Route::post('/status', [CourierController::class, 'setStatus'])->name('status');
    Route::post('/lokasi', [CourierController::class, 'updateLocation'])->name('location');
    Route::post('/pesanan/{order}/ambil', [CourierController::class, 'pickup'])->name('pickup');
    Route::post('/pesanan/{order}/selesai', [CourierController::class, 'deliver'])->name('deliver');
    Route::post('/withdraw', [CourierController::class, 'withdraw'])->name('withdraw');
    Route::post('/profile/update', [CourierController::class, 'updateProfile'])->name('profile.update');
});

// ==========================================
// RUTE PENJUAL (SELLER)
// ==========================================
Route::middleware(['auth', 'role:seller'])->prefix('penjual')->name('seller.')->group(function () {
    Route::get('/dashboard', [SellerController::class, 'dashboard'])->name('dashboard');
    Route::post('/produk', [SellerController::class, 'storeProduct'])->name('products.store');
    Route::patch('/produk/{product}', [SellerController::class, 'updateProduct'])->name('products.update');
    Route::delete('/produk/{product}', [SellerController::class, 'destroyProduct'])->name('products.destroy');
    Route::patch('/pesanan/{order}', [SellerController::class, 'updateOrder'])->name('orders.update');
});

// ==========================================
// RUTE ADMIN
// ==========================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::patch('/users/{user}/role', [AdminController::class, 'updateRole'])->name('users.role');
    Route::patch('/pesanan/{order}/kurir', [AdminController::class, 'assignCourier'])->name('orders.courier');
});

// ==========================================
// RUTE PRODUK (detail produk publik; Buy Now ada di grup checkout pelanggan)
// ==========================================
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

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

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Route Google Login
Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google.login');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);



// ==========================================
// RUTE PELANGGAN (CUSTOMER)
// ==========================================
Route::get('/', [CustomerController::class, 'home'])->name('home');

// Parameter {order_id} opsional (bisa diakses seperti /lacak/ORD-123)
Route::get('/lacak/{order_id?}', [CustomerController::class, 'tracking'])->name('tracking');

// ==========================================
// RUTE KURIR (COURIER)
// ==========================================
Route::get('/kurir/dashboard', [CourierController::class, 'dashboard'])->name('courier.dashboard');

// ==========================================
// RUTE PENJUAL (SELLER)
// ==========================================
Route::get('/penjual/dashboard', [SellerController::class, 'dashboard'])->name('seller.dashboard');

// ==========================================
// RUTE ADMIN
// ==========================================
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

// ==========================================
// RUTE PRODUK / SHOP
// ==========================================
// Method 'products' diubah menjadi 'shop', dan name 'products' menjadi 'shop'
Route::get('/shop', [CustomerController::class, 'shop'])->name('shop');

// Rute Kategori
Route::get('/category', [CustomerController::class, 'categories'])->name('categories');

// Rute About
Route::get('/about', [CustomerController::class, 'about'])->name('about');
// Rute Keranjang
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

// Rute Contact
Route::get('/contact', [CustomerController::class, 'contact'])->name('contact');

// Rute Checkout
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
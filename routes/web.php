<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\AdminController;

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
// RUTE PRODUK
// ==========================================
Route::get('/produk', [CustomerController::class, 'products'])->name('products');
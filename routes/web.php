<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Bisa diakses siapa saja)
|--------------------------------------------------------------------------
*/
Route::get('/', [LandingController::class, 'index'])->name('landing.index');
Route::get('/field/{id}', [LandingController::class, 'show'])->name('landing.show');


/*
|--------------------------------------------------------------------------
| Guest Routes (Hanya untuk user yang BELUM login)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});


/*
|--------------------------------------------------------------------------
| Authenticated Routes (Hanya untuk user yang SUDAH login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    // Alur Checkout
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/confirm', [CheckoutController::class, 'confirm'])->name('checkout.confirm');
    Route::post('/checkout/store', [CheckoutController::class, 'store'])->name('checkout.store');

    // Handling jika user melakukan GET/Refresh di /checkout/process agar tidak throw error Method Not Allowed
    Route::get('/checkout/process', function () {
        return redirect()->route('landing.index')->with('warning', 'Silakan pilih lapangan dan slot jam terlebih dahulu.');
    });

    // Alur Pembayaran & Success State
    // Route success diarahkan langsung ke PaymentController agar terpusat
    Route::get('/booking/success/{id}', [PaymentController::class, 'show'])->name('booking.success');
    Route::get('/payment/{bookingId}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{bookingId}/simulate', [PaymentController::class, 'simulate'])->name('payment.simulate');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});


/*
|--------------------------------------------------------------------------
| Admin Routes (Hanya untuk user dengan role 'admin')
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
});
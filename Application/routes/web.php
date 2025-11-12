<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\InstrukturController;
use App\Http\Controllers\MobilController;
use App\Http\Controllers\OrdersController;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('/register', [RegistrationController::class, 'showStep1'])->name('register.step1.show');
Route::post('/register/step1', [RegistrationController::class, 'step1'])->name('register.step1.submit');
Route::get('/register/step2', [RegistrationController::class, 'showStep2'])->name('register.step2.show');
Route::post('/register/step2', [RegistrationController::class, 'step2'])->name('register.step2.submit');
Route::get('/register/step3', [RegistrationController::class, 'showStep3'])->name('register.step3.show');
Route::post('/register/step3', [RegistrationController::class, 'step3'])->name('register.step3.submit');
Route::get('/register/back/{step}', [RegistrationController::class, 'back'])->name('register.back');

// Password Reset (OTP)
Route::get('/password/forgot', [PasswordResetController::class, 'showForgot'])->name('password.forgot.show');
Route::post('/password/forgot', [PasswordResetController::class, 'sendOtp'])->name('password.forgot.send');
Route::get('/password/verify', [PasswordResetController::class, 'showVerify'])->name('password.verify.show');
Route::post('/password/verify', [PasswordResetController::class, 'verifyAndReset'])->name('password.verify.reset');

// Dashboard (requires kursus session)
Route::get('/dashboard', [DashboardController::class, 'show'])->name('dashboard');

// Paket Kursus
Route::get('/paket', [PaketController::class, 'index'])->name('paket.index');
Route::get('/paket/create', [PaketController::class, 'create'])->name('paket.create');
Route::post('/paket', [PaketController::class, 'store'])->name('paket.store');
Route::get('/paket/{id}/edit', [PaketController::class, 'edit'])->name('paket.edit');
Route::put('/paket/{id}', [PaketController::class, 'update'])->name('paket.update');
Route::delete('/paket/{id}', [PaketController::class, 'destroy'])->name('paket.destroy');

// Instruktur
Route::get('/instruktur', [InstrukturController::class, 'index'])->name('instruktur.index');
Route::get('/instruktur/create', [InstrukturController::class, 'create'])->name('instruktur.create');
Route::post('/instruktur', [InstrukturController::class, 'store'])->name('instruktur.store');
Route::get('/instruktur/{id}/edit', [InstrukturController::class, 'edit'])->name('instruktur.edit');
Route::put('/instruktur/{id}', [InstrukturController::class, 'update'])->name('instruktur.update');
Route::delete('/instruktur/{id}', [InstrukturController::class, 'destroy'])->name('instruktur.destroy');

// Kendaraan (Mobil)
Route::get('/mobil', [MobilController::class, 'index'])->name('mobil.index');
Route::get('/mobil/create', [MobilController::class, 'create'])->name('mobil.create');
Route::post('/mobil', [MobilController::class, 'store'])->name('mobil.store');
Route::get('/mobil/{id}/edit', [MobilController::class, 'edit'])->name('mobil.edit');
Route::put('/mobil/{id}', [MobilController::class, 'update'])->name('mobil.update');
Route::delete('/mobil/{id}', [MobilController::class, 'destroy'])->name('mobil.destroy');

// Pesanan Kursus
Route::get('/pesanan', [OrdersController::class, 'index'])->name('orders.index');

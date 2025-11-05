<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\PasswordResetController;

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

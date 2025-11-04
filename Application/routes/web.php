<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistrationController;

Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Registration Routes
Route::get('/register', [RegistrationController::class, 'showStep1'])->name('register.step1');
Route::post('/register/step1', [RegistrationController::class, 'step1'])->name('register.step1');
Route::get('/register/step2', [RegistrationController::class, 'showStep2'])->name('register.step2');
Route::post('/register/step2', [RegistrationController::class, 'step2'])->name('register.step2');
Route::get('/register/step3', [RegistrationController::class, 'showStep3'])->name('register.step3');
Route::post('/register/step3', [RegistrationController::class, 'step3'])->name('register.step3');
Route::get('/register/back/{step}', [RegistrationController::class, 'back'])->name('register.back');

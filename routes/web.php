<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;

// المسارات العامة
Route::get('/', function () {
    return view('welcome');
});

// مسارات المصادقة للزوار
Route::middleware('guest')->group(function () {
    // تسجيل الدخول
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // التسجيل
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // إعادة تعيين كلمة المرور
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])
        ->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])
        ->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])
        ->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])
        ->name('password.update');
});

// مسارات المصادقة للمستخدمين المسجلين
Route::middleware('auth')->group(function () {
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/users', [DashboardController::class, 'getUsers'])->name('dashboard.users');
        Route::delete('/users/{user}', [DashboardController::class, 'destroy']);
        Route::put('/users/{user}', [DashboardController::class, 'update']);
    });
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/auth/check', [AuthController::class, 'check'])->name('auth.check');
});







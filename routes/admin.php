<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubjectController;





Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/users', [DashboardController::class, 'index'])->name('dashboard.users');
    Route::delete('/users/{user}', [DashboardController::class, 'destroy']);
    Route::put('/users/{user}', [DashboardController::class, 'update']);
    Route::get('/dashboard/subject', [SubjectController::class, 'index'])->name('dashboard.subject');
    Route::delete('/subject/{subject}', [SubjectController::class, 'destroy']);
    Route::put('/subject/{subject}', [SubjectController::class, 'update']);
});

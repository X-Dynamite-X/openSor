<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\SubjectUserController;





Route::middleware(['auth',"chakeISAdmin", 'role:admin',])->group(function () {
    Route::get('/dashboard/users', [DashboardController::class, 'index'])->name('dashboard.users');
    Route::post('/users', [DashboardController::class, 'store'])->name('users.store');
    Route::delete('/users/{user}', [DashboardController::class, 'destroy']);
    Route::put('/users/{user}', [DashboardController::class, 'update']);
    Route::get('/dashboard/subject', [SubjectController::class, 'index'])->name('dashboard.subject');
    Route::post('/subject', [SubjectController::class, 'store'])->name('subject.store');
    Route::delete('/subject/{subject}', [SubjectController::class, 'destroy']);
    Route::put('/subject/{subject}', [SubjectController::class, 'update']);
    Route::get('/subject/{subject}/users', [SubjectUserController::class, 'getSubjectUsers'])->name('subject.users');
    Route::put('/admin/subject/{subject}/users/{user}/mark', [SubjectUserController::class, 'updateMark'])
        ->name('subject.user.mark.update');
    Route::delete('/admin/subject/{subject}/users/{user}', [SubjectUserController::class, 'removeUser'])
        ->name('subject.user.remove');
    Route::get('/subject/{subject}/available-users', [SubjectUserController::class, 'getAvailableUsers']);
    Route::post('/subject/{subject}/add-users', [SubjectUserController::class, 'addUsers']);
});

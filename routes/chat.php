<?php

use App\Http\Controllers\ConversationController;
use App\Http\Controllers\MessageController;

use Illuminate\Support\Facades\Route;

Route::middleware(['auth',"permission:active"])->group(function () {
    // المحادثات
    Route::prefix('chat')->group(function () {
        // عرض قائمة المحادثات
        Route::get('/', [ConversationController::class, 'index'])->name('chat.index');
        Route::post('/', [ConversationController::class, 'store'])->name('chat.store');
        Route::get('/{conversation}', [ConversationController::class, 'show'])->name('chat.show');
        Route::post('/{conversation}/message',[MessageController::class,"store"]);

});
});

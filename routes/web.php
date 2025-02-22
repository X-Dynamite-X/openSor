<?php

use Illuminate\Support\Facades\Route;


// المسارات العامة
Route::get('/', function () {
    return view('welcome');
});

// مسارات المصادقة للزوار

// Admin Routes

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';


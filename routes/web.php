<?php


// use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// المسارات العامة
Route::get('/', function () {
    return view('welcome');
});

 require __DIR__.'/auth.php';

 require __DIR__.'/admin.php';


require __DIR__.'/chat.php';


Route::  get('/home', function () {
    return redirect()->route('chat.index');
})->name('home');


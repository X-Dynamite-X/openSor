<?php


// use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserInformationsController;
// المسارات العامة
// Route::get('/', function () {
//     return view('welcome');
// })->middleware(["auth","ChakeUserActive"])


Route::get("/",[UserInformationsController::class , "index"])->name('home')->middleware(["auth","ChakeUserActive"]);


Route::get('/isActive', function () {
    return view('userNotActive');
})->middleware(["guest"])->name('isActive');

 require __DIR__.'/auth.php';

 require __DIR__.'/admin.php';


require __DIR__.'/chat.php';


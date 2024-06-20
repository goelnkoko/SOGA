<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/password-recover', function () {
    return view('auth.password');
})->name('password-recover');

Route::get('/home', function () {
    return view('home.home');
})->name('home');



Route::middleware('auth')->get('/logged-user', 'UserController@loggedUser')->name('loggedUser');


Route::post('/login', [UserController::class, 'login'])->name('login');

Route::post('/register', [UserController::class,'register'])->name('register');

Route::resource('/users', UserController::class);

<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function (){
    return view('auth.login');
})->name('login');

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
})->name('home')->middleware('auth');

Route::get('/profile', function () {
    return view('profile.profile');
})->name('profile')->middleware('auth');

Route::get('/profile_user', function () {
    return view('profile.profile_user');
})->name('profile_user')->middleware('auth');




Route::middleware('auth')->get('/logged-user', [UserController::class, 'loggedUser'])->name('loggedUser');
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/register', [UserController::class,'register'])->name('register');
Route::resource('/users', UserController::class);
Route::get('/non-friends', [UserController::class, 'getNonFriends'])->name('getNonFriends')->middleware('auth');


//Post Routes

//Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store')->middleware('web');
Route::get('/posts', [PostController::class, 'index'])->name('posts.index')->middleware('web');


//Friend Routes
Route::middleware('auth')->group(function () {
    Route::post('/friend-requests', [\App\Http\Controllers\FriendRequestController::class, 'sendRequest']);
    Route::get('/friend-requests', [\App\Http\Controllers\FriendRequestController::class, 'peddingRequests']);
    Route::patch('/friend-requests/{id}/accept', [\App\Http\Controllers\FriendRequestController::class, 'acceptRequest']);
    Route::patch('/friend-requests/{id}/reject', [\App\Http\Controllers\FriendRequestController::class, 'rejectRequest']);

    Route::get('/friends', [\App\Http\Controllers\FriendController::class, 'getFriends']);
    Route::patch('/friends/{id}', [\App\Http\Controllers\FriendController::class, 'updateStatus']);
});


//Chat
Route::middleware('auth')->group(function () {

//    Route::post('/chat', [UserController::class, 'logout'])->name('logout');

});

Route::get('/chat', function () {
    return view('chat.chat');
})->name('chat')->middleware('auth');

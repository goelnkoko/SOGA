<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Rotas de Autenticação
Route::get('/', function () {
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

Route::middleware('auth')->group(function () {
    // Rotas Autenticadas
    Route::get('/home', function () {
        return view('home.home');
    })->name('home');

    Route::get('/profile', function () {
        return view('profile.profile');
    })->name('profile');

    Route::get('/profile_user', function () {
        return view('profile.profile_user');
    })->name('profile_user');

    Route::get('/definicoes', function () {
        return view('auth.definicoes');
    })->name('definicoes');

    Route::get('/friend', function () {
        return view('friend.friend');
    })->name('friend');

    Route::get('/logged-user', [UserController::class, 'loggedUser'])->name('loggedUser');
    Route::get('/non-friends', [UserController::class, 'getNonFriends'])->name('getNonFriends');

    // Rotas de Postagens
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts', [PostController::class, 'showPosts'])->name('posts.index');
    Route::delete('/posts/{post}', [PostController::class, 'removePost']);
    Route::post('/posts/{postId}/like', [PostController::class, 'likePost']);
    Route::post('/posts/{postId}/unlike', [PostController::class, 'unlikePost']);

    // Rotas de Amigos
    Route::post('/friend-requests', [\App\Http\Controllers\FriendRequestController::class, 'sendRequest']);
    Route::get('/friend-requests', [\App\Http\Controllers\FriendRequestController::class, 'peddingRequests']);
    Route::patch('/friend-requests/{id}/accept', [\App\Http\Controllers\FriendRequestController::class, 'acceptRequest']);
    Route::patch('/friend-requests/{id}/reject', [\App\Http\Controllers\FriendRequestController::class, 'rejectRequest']);
    Route::get('/friends', [\App\Http\Controllers\FriendController::class, 'getFriends']);
    Route::patch('/friends/{id}', [\App\Http\Controllers\FriendController::class, 'updateStatus']);

    // Rotas de Chat
    Route::get('/chat', function () {
        return view('chat.chat');
    })->name('chat');

    // Rotas de Perfis
    Route::get('profiles/{id}', [ProfileController::class, 'show']);
    Route::post('profiles/{id}/add-hobby', [ProfileController::class, 'addHobby']);
    Route::post('profiles/{id}/remove-hobby', [ProfileController::class, 'removeHobby']);
    Route::post('profiles/{id}/add-interest', [ProfileController::class, 'addInterest']);
    Route::post('profiles/{id}/remove-interest', [ProfileController::class, 'removeInterest']);
    Route::post('/profiles/{id}', [ProfileController::class, 'uploadProfilePhoto']);
    Route::put('profiles/{id}', [ProfileController::class, 'updateProfile']);
    Route::put('profiles/{id}/photo', [ProfileController::class, 'updateProfilePhoto']);
    Route::delete('profiles/{id}/photo', [ProfileController::class, 'removePhoto']);
    Route::post('profiles/{id}/add-education', [ProfileController::class, 'addEducation']);
    Route::delete('profiles/{profileId}/remove-education/{educationId}', [ProfileController::class, 'removeEducation']);
    Route::post('profiles/{id}/add-work', [ProfileController::class, 'addWork']);
    Route::delete('profiles/{profileId}/remove-work/{workId}', [ProfileController::class, 'removeWork']);
    Route::post('profiles/{id}/add-contact', [ProfileController::class, 'addContact']);
    Route::delete('profiles/{profileId}/remove-contact/{contactId}', [ProfileController::class, 'removeContact']);
});

// Rotas de Login e Logout
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');
Route::post('/register', [UserController::class, 'register'])->name('register');
Route::post('/definicoes', [UserController::class, 'definicoes'])->name('definicoes');
Route::resource('/users', UserController::class);

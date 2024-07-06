<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\FriendRequestController;
use App\Http\Controllers\NotificationController;
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

    Route::get('/definition', function () {
        return view('definition.definition');
    })->name('definition');

    Route::get('/friend', function () {
        return view('friend.friend');
    })->name('friend');

    Route::get('/notification', function () {
       return view('notification.notification');
    })->name('notification');

    Route::get('/logged-user', [UserController::class, 'loggedUser'])->name('loggedUser');
    Route::get('/non-friends', [UserController::class, 'getNonFriends'])->name('getNonFriends');
    Route::get('/users/search', [UserController::class, 'searchUsers'])->name('searchUsers');

    // Rotas de Postagens
    Route::post('/posts', [PostController::class, 'newPost'])->name('posts.newPost');
    Route::get('/posts', [PostController::class, 'getPosts'])->name('posts.getPosts');
    Route::delete('/posts/{post}', [PostController::class, 'removePostById']);
    Route::post('/posts/{postId}/like', [PostController::class, 'likePost']);
    Route::post('/posts/{postId}/unlike', [PostController::class, 'unlikePost']);

    // Rotas para Comentários
    Route::get('/posts/{post}/comments', [CommentController::class, 'getCommentsByPostId']);
    Route::post('/comments', [CommentController::class, 'newComment']);
    Route::delete('/comments/{comment}', [CommentController::class, 'removeComment']);

    //Rotas para Notificações
    Route::get('/notifications', [NotificationController::class, 'getNotifications']);
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::delete('/notifications/{id}', [NotificationController::class, 'removeNotification']);

    // Rotas de Amigos
    Route::post('/friend-requests', [FriendRequestController::class, 'sendRequest']);
    Route::get('/friend-requests', [FriendRequestController::class, 'peddingRequests']);
    Route::get('/sent-requests', [FriendRequestController::class, 'sentRequests']);
    Route::patch('/friend-requests/{id}/accept', [FriendRequestController::class, 'acceptRequest']);
    Route::patch('/friend-requests/{id}/reject', [FriendRequestController::class, 'rejectRequest']);
    Route::delete('/friend-requests/{id}', [FriendRequestController::class, 'deleteRequest']);

    Route::get('/friends', [FriendController::class, 'getFriends']);
    Route::patch('/friends/{id}', [FriendController::class, 'updateStatus']);
    Route::delete('/friends/{id}', [FriendController::class, 'removeFriend']);

    // Rotas de Chat
    Route::get('/chat', function () {
        return view('chat.chat');
    })->name('chat');

//    Route::get('/chat', 'App\Http\Controllers\PusherController@index');
//    Route::post('/chat/broadcast', 'App\Http\Controllers\PusherController@broadcast');
//    Route::post('/chat/receive', 'App\Http\Controllers\PusherController@receive');

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

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Models\Post;
use App\Http\Controllers\Auth\ForgotPasswordController;


Route::middleware('guest')->group(function () {
    Route::view('/login', 'login')->name('login');
    Route::view('/register', 'register');
    Route::view('/forgot-password', 'forgot-password')->middleware('guest');
    Route::post('/forgot-password', [UserController::class, 'sendResetLink']);
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->middleware('guest');
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
    
});

// Redireciona para /home
Route::get('/', function () {
    return redirect('/home');
});

Route::middleware('auth')->group(function () {
    Route::get('/home', [PostController::class, 'index'])->name('posts.index');
    Route::resource('posts', PostController::class)->except(['show']);
});

Route::post('/logout', function () {
    \Illuminate\Support\Facades\Auth::logout();
    return redirect('/login');
})->name('logout');

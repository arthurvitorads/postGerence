<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

// Rotas públicas para guest
Route::middleware('guest')->group(function () {
    Route::view('/login', 'login')->name('login');
    Route::view('/register', 'register');
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);

    // Página do "Esqueci a senha"
    Route::view('/forgot-password', 'forgot-password')->name('password.request');

    // Envio do link para resetar a senha
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');


    // Página de redefinir senha com token
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    // Submissão da nova senha (reset)
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');

});

Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
Route::post('/password/reset', [ResetPasswordController::class, 'reset']);

// Redirecionamento raiz para home
Route::get('/', fn () => redirect('/home'));

// Rotas protegidas (autenticadas)
Route::middleware('auth')->group(function () {
    Route::get('/home', [PostController::class, 'index'])->name('posts.index');
    Route::resource('posts', PostController::class)->except(['show']);

    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/login');
    })->name('logout');
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\AuthController;

// Redirect root URL to the login page
Route::get('/', function () {
    return redirect('/login');
});

// Auth Routes
Route::get('/signup', [AuthController::class, 'signupForm'])->name('signup');
Route::post('/signup', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Welcome route (only accessible after login)
Route::get('/welcome', [MovieController::class, 'welcome'])->middleware('auth')->name('welcome');

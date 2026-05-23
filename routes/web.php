<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SessionAuth as SessionAuth;
use App\Http\Controllers\AuthController as AuthController;
use App\Http\Controllers\WelcomeController as WelcomeController;

Route::get('/', [WelcomeController::class, 'showEvents'])->name('welcome');

// Routes for authentication
Route::middleware('session.auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('users.dashboard');
    })->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/login', [AuthController::class, 'index'])->name('login'); // Show login form
Route::post('/login', [AuthController::class, 'login'])->name('login.submit'); // Handle login form submission
Route::get('/register', [AuthController::class, 'register'])->name('register'); // Show registration form
Route::post('/register', [AuthController::class, 'createCustomer'])->name('register.submit'); // Handle registration form submission



<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SessionAuth as SessionAuth;
use App\Http\Controllers\AuthController as AuthController;
use App\Http\Controllers\WelcomeController as WelcomeController;
use App\Http\Controllers\ProfileController as ProfileController;
use App\Http\Controllers\PasswordController as PasswordController;

Route::get('/', [WelcomeController::class, 'showEvents'])->name('welcome');

// Routes for authentication
Route::middleware('session.auth')->group(function () {
    Route::get('/dashboard', [WelcomeController::class, 'dashboardPage'])->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/events/{id}', [WelcomeController::class, 'showEventDetails'])->name('events.show');
    Route::post('/reserve/{idShowTime}', [WelcomeController::class, 'paymentSeats'])->name('event.reservation');
    // Route for payment page
    Route::get('/payment/{idShowTime}/{seats}', [WelcomeController::class, 'showPaymentPage'])->name('payment.event');
    Route::post('/payment/process/{idShowTime}', [WelcomeController::class, 'processOrder'])->name('payment.process');
});

Route::get('/login', [AuthController::class, 'index'])->name('login'); // Show login form
Route::post('/login', [AuthController::class, 'login'])->name('login.submit'); // Handle login form submission
Route::get('/register', [AuthController::class, 'register'])->name('register'); // Show registration form
Route::post('/register', [AuthController::class, 'createCustomer'])->name('register.submit'); // Handle registration form submission

// Routes profile user management
Route::get('/user/me', [ProfileController::class, 'index'])->name('profile');
Route::post('/update/image', [ProfileController::class, 'updateImage'])->name('update.image');
Route::put('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');

// Paso 1 - Formulario para ingresar email
Route::get('/forgot-password', [PasswordController::class, 'showForgotForm'])->name('password.forgot');
Route::post('/forgot-password', [PasswordController::class, 'sendResetLink'])->name('password.forgot.send');

// Paso 2 - La API redirige aquí con el token
Route::get('/reset-password', [PasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordController::class, 'resetPassword'])->name('password.reset.send');



Route::get('/events', [WelcomeController::class, 'showEvents'])->name('events');

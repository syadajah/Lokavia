<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

// ====================== PUBLIC TO LANDING PAGE ======================
Route::get('/', function () {
    return view('landing.landingPage'); // halaman publik
})->name('landing');

// ====================== GUEST ACCESS ======================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login.form');
    Route::post('/login', [AuthController::class, 'processLogin'])->name('login');
    Route::get('/register', [AuthController::class, 'register'])->name('register.form');
    Route::post('/register', [AuthController::class, 'processRegister'])->name('register');
});

// ====================== AUTHENTICATED ACCESS ====================== //

// ====================== ADMIN ROLE SESSION ======================
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

// ====================== USER ROLE SESSION ======================
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
});

// ====================== LOGOUT SESSION ======================
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KendaraanController;

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

    Route::get('/admin/kendaraan', [KendaraanController::class, 'index'])->name('admin.kendaraan.index');
    Route::post('/admin/kendaraan', [KendaraanController::class, 'store'])->name('admin.kendaraan.store');
    Route::put('/admin/kendaraan/{id}', [KendaraanController::class, 'update'])->name('admin.kendaraan.update');
    Route::delete('/admin/kendaraan/{id}', [KendaraanController::class, 'destroy'])->name('admin.kendaraan.destroy');

    Route::get('/admin/kategori', [KategoriController::class, 'index'])->name('admin.kategori.index');
    Route::post('/admin/kategori', [KategoriController::class, 'store'])->name('admin.kategori.store');
    Route::put('/admin/kategori/{id}', [KategoriController::class, 'update'])->name('admin.kategori.update');
    Route::delete('/admin/kategori/{id}', [KategoriController::class, 'destroy'])->name('admin.kategori.destroy');

    // Route untuk API load jenis
    Route::get('/admin/kategori/get-jenis', [KategoriController::class, 'getJenisByKategori'])->name('admin.kategori.getJenis');
});

// ====================== USER ROLE SESSION ======================
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
});

// ====================== OWNER ROLE SESSION ======================
Route::middleware(['auth', 'role:owner'])->group(function () {
    Route::get('/owner/dashboard', [UserController::class, 'index'])->name('owner.dashboard');
});

// ====================== LOGOUT SESSION ======================
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

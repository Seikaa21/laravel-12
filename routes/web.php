<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KontenController;

// ==================== HALAMAN UTAMA ====================
Route::get('/', [KontenController::class, 'index'])->name('home');

// ==================== ROUTE UNTUK TAMU (BELUM LOGIN) ====================
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Register
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// ==================== ROUTE UNTUK USER YANG SUDAH LOGIN ====================
Route::middleware('auth')->group(function () {
    // Dashboard dan update profil
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/dashboard/update', [AuthController::class, 'updateProfile'])->name('dashboard.update');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ========== CRUD Kategori ==========
    Route::post('/kategori', [KontenController::class, 'storeKategori'])->name('kategori.store');
    Route::put('/kategori/{id}', [KontenController::class, 'updateKategori'])->name('kategori.update');
    Route::delete('/kategori/{id}', [KontenController::class, 'destroyKategori'])->name('kategori.destroy');

    // ========== CRUD Konten ==========
    Route::post('/konten', [KontenController::class, 'storeKonten'])->name('konten.store');
    Route::put('/konten/{id}', [KontenController::class, 'updateKonten'])->name('konten.update');
    Route::delete('/konten/{id}', [KontenController::class, 'destroyKonten'])->name('konten.destroy');
});

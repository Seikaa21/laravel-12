<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KontenController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UserController;

// ==================== HALAMAN UTAMA ====================
Route::get('/', [KontenController::class, 'landing'])->name('welcome'); 
// tampilkan welcome.blade.php (pake search & pagination)

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
    // Dashboard & update profil
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/dashboard/update', [AuthController::class, 'updateProfile'])->name('dashboard.update');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ========== CRUD Konten (izin per halaman) ==========
    Route::prefix('konten')->name('konten.')->group(function () {
        Route::get('/', [KontenController::class, 'index'])
            ->name('index')
            ->middleware('permission:can_access_konten');   // ✅ cek izin
        
        Route::post('/', [KontenController::class, 'store'])
            ->name('store')
            ->middleware('permission:can_access_konten');

        Route::get('/{id}', [KontenController::class, 'show'])
            ->name('show')
            ->middleware('permission:can_access_konten');

        Route::put('/{id}', [KontenController::class, 'update'])
            ->name('update')
            ->middleware('permission:can_access_konten');

        Route::delete('/{id}', [KontenController::class, 'destroy'])
            ->name('destroy')
            ->middleware('permission:can_access_konten');
    });
});

// ==================== ROUTE UNTUK ADMIN (LOGIN + ADMIN) ====================
Route::middleware(['auth', 'isAdmin'])->group(function () {
    // CRUD Kategori
    Route::prefix('kategori')->name('kategori.')->group(function () {
        Route::get('/', [KategoriController::class, 'index'])->name('index');
        Route::post('/', [KategoriController::class, 'store'])->name('store');
        Route::put('/{kategori}', [KategoriController::class, 'update'])->name('update');
        Route::delete('/{kategori}', [KategoriController::class, 'destroy'])->name('destroy');
    });

    // Manajemen User & Izin
    Route::get('/users', [AuthController::class, 'listUsers'])->name('admin.users.index');
    Route::patch('/users/{user}/toggle-permission', [AuthController::class, 'togglePermission'])
        ->name('admin.users.togglePermission');
});


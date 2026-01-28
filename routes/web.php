<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WargaController; 

// Halaman awal ke login
Route::get('/', function () {
    return redirect('/login');
});

// Route Login & Logout
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Group Route yang butuh Login (Auth)
Route::middleware(['auth'])->group(function () {

    // Dashboard Admin
    Route::get('/admin/dashboard', [DashboardController::class, 'indexAdmin'])
        ->name('admin.dashboard');

    // Dashboard RT
    Route::get('/rt/dashboard', [DashboardController::class, 'indexRT'])
        ->name('rt.dashboard');

    // --- AREA KHUSUS WARGA (Admin) ---
    // PENTING: Route khusus (Import & Template) WAJIB ditaruh SEBELUM Route::resource
    
    // 1. Route Import (POST)
    Route::post('/admin/warga/import', [WargaController::class, 'import'])->name('warga.import');

    // 2. Route Download Template (GET) - Pindahkan ke sini!
    Route::get('/admin/warga/template', [WargaController::class, 'downloadTemplate'])->name('warga.template');

    // 3. CRUD Warga (Resource) - Taruh paling bawah di antara route warga lainnya
    Route::resource('/admin/warga', WargaController::class);
        
    // Rute Kelola Bantuan
    Route::resource('/admin/jenis-bansos', \App\Http\Controllers\JenisBansosController::class);
});
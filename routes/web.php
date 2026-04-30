<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WargaController; 
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JenisBansosController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\StatusController; // <-- TAMBAHAN: Jangan lupa import StatusController

// ====================================================
// AREA PUBLIK (TIDAK PERLU LOGIN)
// ====================================================

// Halaman awal (Dashboard Publik / Landing Page)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Halaman Khusus Cek Status Warga (Publik) <--- TARUH DI SINI
Route::get('/cek-status', [StatusController::class, 'index'])->name('status.index');

// Route Login & Logout
// (Route GET /login dihapus karena form login ada di Modal Halaman Depan)
Route::post('/login', [LoginController::class, 'authenticate'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// ====================================================
// AREA TERKUNCI (WAJIB LOGIN)
// ====================================================

// Group Route yang butuh Login (Auth)
Route::middleware(['auth'])->group(function () {

    // ====================================================
    // 1. AREA ADMIN
    // ====================================================

    // Dashboard Admin
    Route::get('/admin/dashboard', [DashboardController::class, 'indexAdmin'])
        ->name('admin.dashboard');

    // --- MANAJEMEN WARGA ---
    // PENTING: Route khusus (Import & Template) WAJIB ditaruh SEBELUM Route::resource
    
    // 1. Route Import (POST)
    Route::post('/admin/warga/import', [WargaController::class, 'import'])->name('warga.import');

    // 2. Route Download Template (GET)
    Route::get('/admin/warga/template', [WargaController::class, 'downloadTemplate'])->name('warga.template');

    // 3. CRUD Warga (Resource)
    Route::resource('/admin/warga', WargaController::class);
        
    // --- MANAJEMEN JENIS BANSOS ---
    Route::resource('/admin/jenis-bansos', JenisBansosController::class);

    //--- VERIFIKASI PENGAJUAN ---
    Route::get('/admin/verifikasi', [App\Http\Controllers\VerifikasiController::class, 'index'])
        ->name('verifikasi.index');

    Route::put('/admin/verifikasi/{id}', [App\Http\Controllers\VerifikasiController::class, 'update'])
        ->name('verifikasi.update');

    Route::put('/admin/warga/{nik}/desil', [App\Http\Controllers\WargaController::class, 'updateDesil'])->name('warga.update_desil');

    // --- MANAJEMEN AKUN RT ---
    Route::get('/admin/rt', [App\Http\Controllers\UserController::class, 'indexRT'])->name('admin.rt.index');
    Route::get('/admin/rt/create', [App\Http\Controllers\UserController::class, 'createRT'])->name('admin.rt.create');
    Route::post('/admin/rt', [App\Http\Controllers\UserController::class, 'storeRT'])->name('admin.rt.store');
    Route::delete('/admin/rt/{id}', [App\Http\Controllers\UserController::class, 'destroyRT'])->name('admin.rt.destroy');

    // --- PENYALURAN ---
    Route::get('/admin/penyaluran', [App\Http\Controllers\PenyaluranController::class, 'index'])->name('penyaluran.index');
    Route::post('/admin/penyaluran/{id_pengajuan}', [App\Http\Controllers\PenyaluranController::class, 'store'])->name('penyaluran.store');

    // --- PENYALURAN ---
    Route::get('/admin/penyaluran', [App\Http\Controllers\PenyaluranController::class, 'index'])->name('penyaluran.index');
    Route::post('/admin/penyaluran/{id_pengajuan}', [App\Http\Controllers\PenyaluranController::class, 'store'])->name('penyaluran.store');
    
    // --- SURAT / PDF ---
    Route::get('/admin/surat/{id_pengajuan}/cetak', [App\Http\Controllers\SuratController::class, 'cetakSurat'])->name('surat.cetak');


    // ====================================================
    // 2. AREA KHUSUS RT (Update Terbaru)
    // ====================================================

    // Dashboard RT
    Route::get('/rt/dashboard', [DashboardController::class, 'indexRT'])
        ->name('rt.dashboard');

    // Form Pengajuan Bantuan
    Route::get('/rt/pengajuan/create', [PengajuanController::class, 'create'])->name('pengajuan.create');
    Route::post('/rt/pengajuan/store', [PengajuanController::class, 'store'])->name('pengajuan.store');
    
    // API Internal untuk Cari Warga (AJAX)
    Route::get('/rt/api/warga', [PengajuanController::class, 'searchWarga'])->name('api.warga.search');

    Route::get('/rt/warga', [App\Http\Controllers\WargaController::class, 'indexRT'])->name('rt.warga.index');
    
});
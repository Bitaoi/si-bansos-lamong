<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WargaController; 
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JenisBansosController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\PenyaluranController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerifikasiController;

// ====================================================
// AREA PUBLIK (TIDAK PERLU LOGIN)
// ====================================================

// Halaman awal (Dashboard Publik / Landing Page + Jadwal Bansos)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Halaman Khusus Cek Status Warga (Publik)
Route::get('/cek-status', [StatusController::class, 'index'])->name('status.index');

// Route Login & Logout
Route::post('/login', [LoginController::class, 'authenticate'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// ====================================================
// AREA TERKUNCI (WAJIB LOGIN)
// ====================================================

Route::middleware(['auth'])->group(function () {

    // ====================================================
    // 1. AREA ADMIN
    // ====================================================

    // Dashboard Admin
    Route::get('/admin/dashboard', [DashboardController::class, 'indexAdmin'])->name('admin.dashboard');

    // --- MANAJEMEN WARGA ---
    Route::post('/admin/warga/import', [WargaController::class, 'import'])->name('warga.import');
    Route::get('/admin/warga/template', [WargaController::class, 'downloadTemplate'])->name('warga.template');
    Route::resource('/admin/warga', WargaController::class);
    Route::put('/admin/warga/{nik}/desil', [WargaController::class, 'updateDesil'])->name('warga.update_desil');
        
    // --- MANAJEMEN JENIS BANSOS ---
    Route::resource('/admin/jenis-bansos', JenisBansosController::class);

    //--- VERIFIKASI PENGAJUAN ---
    Route::get('/admin/verifikasi', [VerifikasiController::class, 'index'])->name('verifikasi.index');
    Route::put('/admin/verifikasi/{id}', [VerifikasiController::class, 'update'])->name('verifikasi.update');

    // --- MANAJEMEN AKUN RT ---
    Route::get('/admin/rt', [UserController::class, 'indexRT'])->name('admin.rt.index');
    Route::get('/admin/rt/create', [UserController::class, 'createRT'])->name('admin.rt.create');
    Route::post('/admin/rt', [UserController::class, 'storeRT'])->name('admin.rt.store');
    Route::delete('/admin/rt/{id}', [UserController::class, 'destroyRT'])->name('admin.rt.destroy');

    // --- PENYALURAN ---
    Route::get('/admin/penyaluran', [PenyaluranController::class, 'index'])->name('penyaluran.index');
    Route::post('/admin/penyaluran/{id_pengajuan}', [PenyaluranController::class, 'store'])->name('penyaluran.store');
    
    // --- SURAT / PDF ---
    Route::get('/admin/surat/{id_pengajuan}/cetak', [SuratController::class, 'cetakSurat'])->name('surat.cetak');

    // --- PENGATURAN JADWAL (ADMIN) ---
    Route::get('/admin/jadwal', [JadwalController::class, 'indexAdmin'])->name('admin.jadwal.index');
    Route::put('/admin/jadwal/{id}', [JadwalController::class, 'update'])->name('admin.jadwal.update');

    // ====================================================
    // 2. AREA KHUSUS RT
    // ====================================================

    // Dashboard RT
    Route::get('/rt/dashboard', [DashboardController::class, 'indexRT'])->name('rt.dashboard');

    // Form Pengajuan Bantuan
    Route::get('/rt/pengajuan/create', [PengajuanController::class, 'create'])->name('pengajuan.create');
    Route::post('/rt/pengajuan/store', [PengajuanController::class, 'store'])->name('pengajuan.store');
    
    // API Internal untuk Cari Warga (AJAX)
    Route::get('/rt/api/warga', [PengajuanController::class, 'searchWarga'])->name('api.warga.search');

    // Data Warga (View only for RT)
    Route::get('/rt/warga', [WargaController::class, 'indexRT'])->name('rt.warga.index');
    
});
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengajuan;
use App\Models\JenisBansos;
use App\Models\User;
use App\Models\Warga;

class DashboardController extends Controller
{
    // =================================================================
    // 1. DASHBOARD ADMIN
    // =================================================================
    public function indexAdmin()
    {
        // 1. KEAMANAN: Cek Role Admin
        if (Auth::user()->role !== 'Admin') {
            abort(403, 'Akses Ditolak. Halaman ini khusus Admin.');
        }

        // 2. STATISTIK UTAMA
        $totalPengajuan     = Pengajuan::count();
        $menungguVerifikasi = Pengajuan::where('status_verifikasi_admin', 'Proses')->count();
        $penerimaLayak      = Pengajuan::where('status_verifikasi_admin', 'Layak')->count();
        $totalWarga         = Warga::count(); 

        // 3. HITUNG SISA KUOTA (Global)
        // Pastikan kolom 'kuota_penerima' ada di tabel jenis_bansos
        $totalKuota = JenisBansos::sum('kuota_penerima'); 
        $sisaKuota  = $totalKuota - $penerimaLayak;

        // 4. TABEL RINGKASAN: 5 Pengajuan Terbaru
        $pengajuanTerbaru = Pengajuan::with(['warga', 'jenisBansos'])
                            ->latest('tgl_pengajuan')
                            ->take(5)
                            ->get();

        return view('admin.dashboard', compact(
            'totalPengajuan', 
            'menungguVerifikasi', 
            'penerimaLayak', 
            'totalWarga',
            'sisaKuota',
            'pengajuanTerbaru'
        ));
    }

    // =================================================================
    // 2. DASHBOARD KETUA RT
    // =================================================================
    public function indexRT()
    {
        $user = Auth::user();

        // 1. KEAMANAN: Cek Role RT
        if ($user->role !== 'RT') {
            abort(403, 'Akses Ditolak. Halaman ini khusus Ketua RT.');
        }

        // 2. LOGIKA WILAYAH
        // Format di database user: "001/005" (RT/RW)
        $wilayah = explode('/', $user->wilayah_rt_rw);
        $rt = $wilayah[0] ?? ''; // Ambil RT (001)
        
        // 3. STATISTIK KHUSUS RT TERSEBUT
        // a. Warga Saya: Hitung warga yang tinggal di RT ini
        $wargaSaya = Warga::where('rt', $rt)->count();

        // b. Total Usulan Saya (Gunakan id_user, bukan id)
        $totalUsulanSaya = Pengajuan::where('id_user_pengusul', $user->id_user)->count();

        // c. Menunggu Verifikasi
        $menungguVerifikasi = Pengajuan::where('id_user_pengusul', $user->id_user)
                              ->where('status_verifikasi_admin', 'Proses')
                              ->count();

        // d. Siap Disalurkan / Layak
        $siapDisalurkan = Pengajuan::where('id_user_pengusul', $user->id_user)
                          ->where('status_verifikasi_admin', 'Layak')
                          ->count();

        // 4. TABEL STATUS: 5 Pengajuan Terakhir milik RT ini (TAMBAHAN BARU)
        $pengajuanTerbaru = Pengajuan::with(['warga', 'jenisBansos'])
                            ->where('id_user_pengusul', $user->id_user) // Filter punya saya
                            ->latest('tgl_pengajuan')
                            ->take(5)
                            ->get();

        return view('rt.dashboard', compact(
            'user',
            'wargaSaya',
            'totalUsulanSaya',
            'menungguVerifikasi',
            'siapDisalurkan',
            'pengajuanTerbaru' // <-- Variabel penting untuk tabel
        ));
    }
}
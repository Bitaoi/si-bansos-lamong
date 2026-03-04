<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengajuan;
use App\Models\JenisBansos;
use App\Models\User;
use App\Models\Warga; // Jangan lupa import Model Warga

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
        $totalWarga         = Warga::count(); // Tambahan: Total seluruh penduduk

        // 3. HITUNG SISA KUOTA (Global)
        // Pastikan nama kolom di database sesuai ('kuota_penerima' atau 'kuota')
        // Di sini saya pakai 'kuota_penerima' sesuai migration terakhir.
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

        // 2. LOGIKA WILAYAH (Mengambil RT/RW dari User yang login)
        // Format di database user: "001/005" (RT/RW)
        $wilayah = explode('/', $user->wilayah_rt_rw);
        $rt = $wilayah[0] ?? '';
        $rw = $wilayah[1] ?? '';

        // 3. STATISTIK KHUSUS RT TERSEBUT
        
        // a. Menghitung jumlah warga yang tinggal di RT ini (Potensi Penerima)
        $wargaSaya = Warga::where('rt', $rt)->where('rw', $rw)->count();

        // b. Total usulan yang pernah dibuat oleh akun RT ini
        $totalUsulanSaya = Pengajuan::where('id_user_pengusul', $user->id)->count();

        // c. Menunggu Verifikasi (Khusus usulan RT ini)
        $menungguVerifikasi = Pengajuan::where('id_user_pengusul', $user->id)
                              ->where('status_verifikasi_admin', 'Proses')
                              ->count();

        // d. Siap Disalurkan / Layak (Khusus usulan RT ini)
        $siapDisalurkan = Pengajuan::where('id_user_pengusul', $user->id)
                          ->where('status_verifikasi_admin', 'Layak')
                          ->count();

        return view('rt.dashboard', compact(
            'user',
            'wargaSaya',
            'totalUsulanSaya',
            'menungguVerifikasi',
            'siapDisalurkan'
        ));
    }
}
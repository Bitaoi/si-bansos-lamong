<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengajuan;
use App\Models\JenisBansos;
use App\Models\User;

class DashboardController extends Controller
{
    // 1. Dashboard untuk Admin
    public function indexAdmin()
    {
        // --- TAMBAHAN KEAMANAN MULAI ---
        // Cek apakah yang login benar-benar Admin. Jika bukan, tolak akses (403).
        if (Auth::user()->role !== 'Admin') {
            abort(403, 'Akses Ditolak. Halaman ini khusus Admin.');
        }
        // --- TAMBAHAN KEAMANAN SELESAI ---

        // Menghitung Statistik
        $totalPengajuan = Pengajuan::count();
        $menungguVerifikasi = Pengajuan::where('status_verifikasi_admin', 'Proses')->count();
        $penerimaLayak = Pengajuan::where('status_verifikasi_admin', 'Layak')->count();
        
        // Menghitung Sisa Kuota
        $totalKuota = JenisBansos::sum('kuota'); 
        $sisaKuota = $totalKuota - $penerimaLayak;

        // Mengambil 5 data pengajuan terbaru
        $pengajuanTerbaru = Pengajuan::with(['warga', 'jenisBansos'])
                            ->latest('tgl_pengajuan')
                            ->take(5)
                            ->get();

        return view('admin.dashboard', compact(
            'totalPengajuan', 
            'menungguVerifikasi', 
            'penerimaLayak', 
            'sisaKuota',
            'pengajuanTerbaru'
        ));
    }

    // 2. Dashboard untuk Ketua RT
    public function indexRT()
    {
        // --- TAMBAHAN KEAMANAN MULAI ---
        // Cek apakah yang login benar-benar RT. Jika bukan, tolak akses.
        if (Auth::user()->role !== 'RT') {
            abort(403, 'Akses Ditolak. Halaman ini khusus Ketua RT.');
        }
        // --- TAMBAHAN KEAMANAN SELESAI ---

        $idUser = Auth::id(); // Ambil ID RT yang sedang login

        // Hitung statistik khusus milik RT tersebut saja
        $totalUsulanSaya = Pengajuan::where('id_user_pengusul', $idUser)->count();
        $menungguVerifikasi = Pengajuan::where('id_user_pengusul', $idUser)
                              ->where('status_verifikasi_admin', 'Proses')
                              ->count();
        $siapDisalurkan = Pengajuan::where('id_user_pengusul', $idUser)
                          ->where('status_verifikasi_admin', 'Layak')
                          ->count();

        return view('rt.dashboard', compact(
            'totalUsulanSaya',
            'menungguVerifikasi',
            'siapDisalurkan'
        ));
    }
}
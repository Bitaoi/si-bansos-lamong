<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisBansos;
use App\Models\Warga;
use App\Models\Pengajuan; // Pastikan Model ini ada
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // 1. STATISTIK KEPENDUDUKAN
        // Menghitung total data dari tabel 'wargas'
        $totalWarga = Warga::count();
        $totalKK = Warga::distinct('no_kk')->count(); 
        $lakiLaki = Warga::where('jenis_kelamin', 'L')->count();
        $perempuan = Warga::where('jenis_kelamin', 'P')->count();

        // 2. STATISTIK PENERIMA BANTUAN (Agregat)
        // Mengambil jumlah pengajuan yang statusnya 'Layak' (Disetujui)
        // Dikelompokkan berdasarkan jenis bansos
        $statistik = Pengajuan::select('id_bansos', DB::raw('count(*) as total'))
            ->where('status_verifikasi_admin', 'Layak')
            ->groupBy('id_bansos')
            ->with('jenisBansos') // Memanggil relasi ke tabel jenis_bansos
            ->get();

        // Siapkan data untuk Grafik Chart.js
        $labelBansos = [];
        $dataBansos = [];

        foreach ($statistik as $data) {
            // Cek apakah relasi jenisBansos ada (untuk menghindari error jika data bansos terhapus)
            if ($data->jenisBansos) {
                $labelBansos[] = $data->jenisBansos->nama_bansos;
                $dataBansos[] = $data->total;
            }
        }

        // Kirim semua variabel ke view 'welcome'
        return view('welcome', compact(
            'totalWarga', 
            'totalKK', 
            'lakiLaki', 
            'perempuan', 
            'labelBansos', 
            'dataBansos'
        ));
    }
}
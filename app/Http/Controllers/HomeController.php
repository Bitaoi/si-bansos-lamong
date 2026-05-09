<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisBansos;
use App\Models\Warga;
use App\Models\Pengajuan;
use App\Models\JadwalBansos;
use App\Models\Galeri;
use Carbon\Carbon;
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

        // 3. TAMBAHAN BARU: AMBIL DATA JADWAL KALENDER
        $jadwal = JadwalBansos::orderBy('hari_mulai', 'asc')->get();
        $hariIni = (int) date('j');

        // Mengambil data tren pengajuan per tahun
        $pengajuanPerTahun = Pengajuan::orderby('created_at', 'asc')
        ->get()
        ->groupBy(function($data) {
            return Carbon::parse($data->created_at)->format('Y');
        });
        
        //memisahkan label tahun dan data
        $labelTahun =$pengajuanPerTahun->keys()->toArray();
        $dataTahun =$pengajuanPerTahun->map(function($item){
            return $item->count();
        })->values()->toArray();

        // GALERI
        $galeriStatis = Galeri::latest()->get();

        // Kirim semua variabel ke view 'welcome'
        return view('welcome', compact(
            'totalWarga', 
            'totalKK', 
            'lakiLaki', 
            'perempuan', 
            'labelBansos', 
            'dataBansos',
            'labelTahun',
            'dataTahun',
            'jadwal',
            'galeriStatis',
            'hariIni'
        ));
    }
}
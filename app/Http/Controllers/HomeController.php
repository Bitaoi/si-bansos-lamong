<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warga;
use App\Models\Pengajuan;
use App\Models\JenisBansos;
use App\Models\Galeri;
use App\Models\JadwalBansos;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Data Statistik Atas
        $totalWarga = Warga::count();
        $totalKK = Warga::distinct('no_kk')->count();
        $lakiLaki = Warga::where('jenis_kelamin', 'LIKE', 'L%')->count();
        $perempuan = Warga::where('jenis_kelamin', 'LIKE', 'P%')->count();

        // 2. Data Jadwal dan Galeri
        $jadwal = JadwalBansos::all();
        $hariIni = date('d');
        $galeriStatis = Galeri::latest()->take(3)->get();

        // 3. GRAFIK TREN PENGAJUAN (DINAMIS)
        // Mengelompokkan jumlah pengajuan berdasarkan tahun dari tgl_pengajuan
        $trenPengajuan = Pengajuan::select(
                DB::raw('YEAR(tgl_pengajuan) as tahun'),
                DB::raw('count(id) as total')
            )
            ->groupBy('tahun')
            ->orderBy('tahun', 'ASC')
            ->get();

        $labelTahun = [];
        $dataTahun = [];

        // Jika data kosong, berikan default tahun ini agar grafik tidak error
        if ($trenPengajuan->isEmpty()) {
            $labelTahun[] = date('Y');
            $dataTahun[] = 0;
        } else {
            foreach ($trenPengajuan as $tren) {
                $labelTahun[] = $tren->tahun;
                $dataTahun[] = $tren->total;
            }
        }

        // 4. GRAFIK SEBARAN BANSOS DISETUJUI (DINAMIS)
        // Menghitung pengajuan yang statusnya 'Layak' dikelompokkan per jenis bansos
        $sebaranBansos = Pengajuan::where('status_verifikasi_admin', 'Layak')
            ->join('jenis_bansos', 'pengajuans.id_bansos', '=', 'jenis_bansos.id')
            ->select('jenis_bansos.kode_bansos', DB::raw('count(pengajuans.id) as total'))
            ->groupBy('jenis_bansos.kode_bansos')
            ->get();

        $labelBansos = [];
        $dataBansos = [];

        foreach ($sebaranBansos as $sebaran) {
            // Gunakan kode_bansos agar label di grafik tidak terlalu panjang
            $labelBansos[] = $sebaran->kode_bansos ?? 'Lainnya';
            $dataBansos[] = $sebaran->total;
        }

        // --- 5. DATA GRAFIK PERBANDINGAN DITERIMA VS DITOLAK ---
        $semuaBansos = \App\Models\JenisBansos::all();
        $labelPerbandingan = [];
        $dataDiterima = [];
        $dataDitolak = [];

        foreach ($semuaBansos as $b) {
            $labelPerbandingan[] = $b->kode_bansos;
            $dataDiterima[] = \App\Models\Pengajuan::where('id_bansos', $b->id)->where('status_verifikasi_admin', 'Layak')->count();
            $dataDitolak[] = \App\Models\Pengajuan::where('id_bansos', $b->id)->where('status_verifikasi_admin', 'Tidak Layak')->count();
        }

        return view('welcome', compact(
            'totalWarga', 
            'totalKK', 
            'lakiLaki', 
            'perempuan', 
            'jadwal', 
            'hariIni', 
            'galeriStatis',
            'labelTahun',     
            'dataTahun',      
            'labelBansos',    
            'dataBansos',
            'labelPerbandingan',
            'dataDiterima',
            'dataDitolak'      
        ));
    }
}
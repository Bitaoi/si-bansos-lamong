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
    public function index(Request $request)
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

        // =======================================================
        // LOGIKA FILTER TAHUN (INPUT KETIK)
        // =======================================================
        // Menangkap filter tahun yang diketik user dari URL
        $tahunFilter = $request->get('tahun');

        // 3. GRAFIK TREN PENGAJUAN (DINAMIS - TAHUNAN)
        $trenPengajuan = Pengajuan::select(
                DB::raw('YEAR(tgl_pengajuan) as tahun'),
                DB::raw('count(id) as total')
            )
            ->groupBy('tahun')
            ->orderBy('tahun', 'ASC')
            ->get();

        $labelTahun = [];
        $dataTahun = [];

        if ($trenPengajuan->isEmpty()) {
            $labelTahun[] = date('Y');
            $dataTahun[] = 0;
        } else {
            foreach ($trenPengajuan as $tren) {
                $labelTahun[] = $tren->tahun;
                $dataTahun[] = $tren->total;
            }
        }

        // 4. GRAFIK SEBARAN BANSOS DISETUJUI (TERFILTER BERDASARKAN TGL PENGAJUAN)
        $querySebaran = Pengajuan::where('status_verifikasi_admin', 'Layak')
            ->join('jenis_bansos', 'pengajuans.id_bansos', '=', 'jenis_bansos.id')
            ->select('jenis_bansos.kode_bansos', DB::raw('count(pengajuans.id) as total'))
            ->groupBy('jenis_bansos.kode_bansos');

        // Jika user mengetik tahun, filter berdasarkan tahun dari tgl_pengajuan
        if (!empty($tahunFilter)) {
            $querySebaran->whereYear('pengajuans.tgl_pengajuan', $tahunFilter);
        }

        $sebaranBansos = $querySebaran->get();

        $labelBansos = [];
        $dataBansos = [];

        foreach ($sebaranBansos as $sebaran) {
            $labelBansos[] = $sebaran->kode_bansos ?? 'Lainnya';
            $dataBansos[] = $sebaran->total;
        }

        // 5. DATA GRAFIK PERBANDINGAN DITERIMA VS DITOLAK (TERFILTER)
        $semuaBansos = JenisBansos::all();
        $labelPerbandingan = [];
        $dataDiterima = [];
        $dataDitolak = [];

        foreach ($semuaBansos as $b) {
            $labelPerbandingan[] = $b->kode_bansos;
            
            // Siapkan query untuk menghitung status pengajuan per bansos
            $qDiterima = Pengajuan::where('id_bansos', $b->id)->where('status_verifikasi_admin', 'Layak');
            $qDitolak = Pengajuan::where('id_bansos', $b->id)->where('status_verifikasi_admin', 'Tidak Layak');

            // Terapkan filter tahun jika ada
            if (!empty($tahunFilter)) {
                $qDiterima->whereYear('tgl_pengajuan', $tahunFilter);
                $qDitolak->whereYear('tgl_pengajuan', $tahunFilter);
            }

            $dataDiterima[] = $qDiterima->count();
            $dataDitolak[] = $qDitolak->count();
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
            'dataDitolak',
            'tahunFilter'     // <--- Passing inputan tahun ke view
        ));
    }
}
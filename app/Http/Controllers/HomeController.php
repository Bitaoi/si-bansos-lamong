<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warga;
use App\Models\Pengajuan;
use App\Models\JenisBansos;
use App\Models\Galeri;
use App\Models\JadwalBansos;
use App\Models\PeriodeBansos;
use App\Models\KuotaRT;
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
            
            $qDiterima = Pengajuan::where('id_bansos', $b->id)->where('status_verifikasi_admin', 'Layak');
            $qDitolak = Pengajuan::where('id_bansos', $b->id)->where('status_verifikasi_admin', 'Tidak Layak');

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
            'tahunFilter'
        ));
    }

    public function infoBansos(Request $request)
    {
        // 1. Ambil Periode dan Jadwal yang sedang aktif
        $periode = PeriodeBansos::where('status', 'Aktif')->first();
        $jadwals = $periode ? JadwalBansos::where('id_periode', $periode->id)->get() : collect();
        
        // 2. Ambil Semua Jenis Bansos untuk Dropdown
        $semuaBansos = JenisBansos::where('status', 'Aktif')->get();
        
        // 3. Inisialisasi awal variabel agar aman dari error Undefined Variable
        $bansosTerpilih = null;
        $statusKetersediaan = 'Tidak Tersedia';
        $sisaKuotaLokal = 0;
        $rincianKuotaRT = collect(); 

        // 4. Jika Warga Melakukan Filter Pencarian
        if ($request->has('jenis_bantuan') && $request->jenis_bantuan != '') {
            $bansosTerpilih = JenisBansos::find($request->jenis_bantuan);
            
            if ($bansosTerpilih && $periode) {
                // Ambil semua RT yang masih memiliki sisa kuota (kuota > terpakai) di periode ini
                $rincianKuotaRT = KuotaRT::where('id_periode', $periode->id)
                                     ->where('id_bansos', $bansosTerpilih->id)
                                     ->whereRaw('kuota > terpakai')
                                     ->orderBy('rt', 'asc')
                                     ->get();

                // Hitung total kuota kumulatif dari seluruh wilayah desa
                $totalKuota = KuotaRT::where('id_periode', $periode->id)
                                     ->where('id_bansos', $bansosTerpilih->id)
                                     ->sum('kuota');
                                     
                $totalTerpakai = KuotaRT::where('id_periode', $periode->id)
                                        ->where('id_bansos', $bansosTerpilih->id)
                                        ->sum('terpakai');
                
                $sisaKuotaLokal = $totalKuota - $totalTerpakai;
                
                // Tentukan Status Utama
                if ($totalKuota == 0) {
                    $statusKetersediaan = 'Belum Dibuka / Tidak Ada Kuota';
                } elseif ($sisaKuotaLokal > 0) {
                    $statusKetersediaan = 'Tersedia';
                } else {
                    $statusKetersediaan = 'Kuota Penuh';
                }
            }
        }

        // PERBAIKAN: Memasukkan 'rincianKuotaRT' ke dalam compact
        return view('info_bansos', compact(
            'periode', 'jadwals', 'semuaBansos', 
            'bansosTerpilih', 'statusKetersediaan', 'sisaKuotaLokal', 'rincianKuotaRT'
        ));
    }
}
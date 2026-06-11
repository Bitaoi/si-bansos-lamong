<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengajuan;
use App\Models\JenisBansos;
use App\Models\User;
use App\Models\Warga;
use App\Models\PeriodeBansos;
use App\Models\KuotaRT; // Disesuaikan dengan nama model yang Anda gunakan
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    // =================================================================
    // 1. DASHBOARD ADMIN
    // =================================================================
    public function indexAdmin(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/');
        }
        
        if (Auth::user()->role !== 'Admin') {
            abort(403, 'Akses Ditolak. Halaman ini khusus Admin.');
        }

        // 1. Manajemen Periode (Menggantikan Filter Bulan & Tahun)
        $dataPeriodes = PeriodeBansos::orderBy('id', 'desc')->get();
        $periodeIdFilter = $request->get('id_periode');

        if ($periodeIdFilter) {
            $periodeTerpilih = PeriodeBansos::find($periodeIdFilter);
        } else {
            $periodeTerpilih = PeriodeBansos::where('status', 'Aktif')->first() ?? $dataPeriodes->first();
        }

        $idPeriode = $periodeTerpilih ? $periodeTerpilih->id : null;

        // 2. Statistik Pengajuan Berdasarkan Periode
        $totalPengajuan     = Pengajuan::where('id_periode', $idPeriode)->count();
        $menungguVerifikasi = Pengajuan::where('id_periode', $idPeriode)
                                       ->whereIn('status_verifikasi_admin', ['Proses', 'Verifikasi Lapangan', 'Menunggu Musdes', 'Siap Keputusan'])->count();
        $penerimaLayak      = Pengajuan::where('id_periode', $idPeriode)
                                       ->where('status_verifikasi_admin', 'Layak')->count();
        $totalWarga         = Warga::count(); 

        // 3. Monitoring Kuota Wilayah Berjenjang (Seluruh RT)
        $monitoringKuota = KuotaRT::with('jenisBansos')
                            ->where('id_periode', $idPeriode)
                            ->orderBy('rw')->orderBy('rt')
                            ->get()
                            ->map(function($q) {
                                $q->persentase = ($q->kuota > 0) ? round(($q->terpakai / $q->kuota) * 100, 2) : 0;
                                $q->sisa_kuota = $q->kuota - $q->terpakai;
                                return $q;
                            });

        $jadwals = $idPeriode ? \App\Models\JadwalBansos::all() : collect(); // Sesuaikan jika jadwal terikat periode

        // 4. Tabel Status Pengajuan Terkini di Periode Tersebut
        $pengajuanTerbaru = Pengajuan::with(['warga', 'jenisBansos'])
                            ->where('id_periode', $idPeriode)
                            ->latest('tgl_pengajuan')
                            ->get();

        $rekapBansos = JenisBansos::all()->map(function($bansos) use ($idPeriode) {
            $baseQuery = Pengajuan::where('id_bansos', $bansos->id)
                                  ->where('id_periode', $idPeriode);

            return (object) [
                'nama_bansos' => $bansos->nama_bansos,
                'kode_bansos' => $bansos->kode_bansos,
                'total_diajukan' => (clone $baseQuery)->count(),
                'disetujui' => (clone $baseQuery)->where('status_verifikasi_admin', 'Layak')->count(),
                'ditolak' => (clone $baseQuery)->where('status_verifikasi_admin', 'Tidak Layak')->count(),
                'diproses' => (clone $baseQuery)->whereIn('status_verifikasi_admin', ['Proses', 'Verifikasi Lapangan', 'Menunggu Musdes', 'Siap Keputusan'])->count(),
            ];
        });

        return view('admin.dashboard', compact(
            'totalPengajuan', 'menungguVerifikasi', 'penerimaLayak', 'totalWarga',
            'pengajuanTerbaru', 'rekapBansos', 'monitoringKuota', 
            'dataPeriodes', 'periodeTerpilih', 'jadwals'
        ));
    }

    public function kuotaDetail()
    {
        if (!Auth::check() || Auth::user()->role !== 'Admin') { abort(403); }
        $bansos = \App\Models\JenisBansos::with('pengajuan')->get();
        return view('admin.kuota.index', compact('bansos'));
    }

    // =================================================================
    // 2. DASHBOARD KETUA RT
    // =================================================================
    public function indexRT(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/');
        }

        $user = Auth::user();

        if ($user->role !== 'RT') { abort(403, 'Akses Ditolak. Halaman ini khusus Ketua RT.'); }

        // 1. Manajemen Periode
        $dataPeriodes = PeriodeBansos::orderBy('id', 'desc')->get();
        $periodeIdFilter = $request->get('id_periode');

        if ($periodeIdFilter) {
            $periodeTerpilih = PeriodeBansos::find($periodeIdFilter);
        } else {
            $periodeTerpilih = PeriodeBansos::where('status', 'Aktif')->first() ?? $dataPeriodes->first();
        }

        $idPeriode = $periodeTerpilih ? $periodeTerpilih->id : null;

        $wilayah = explode('/', $user->wilayah_rt_rw ?? '000/000');
        $rt = $wilayah[0] ?? ''; 
        $rw = $wilayah[1] ?? ''; 
        
        $wargaSaya          = Warga::where('rt', $rt)->count(); 
        $totalUsulanSaya    = Pengajuan::where('id_user_pengusul', $user->id_user)->where('id_periode', $idPeriode)->count();
        $menungguVerifikasi = Pengajuan::where('id_user_pengusul', $user->id_user)
                                      ->where('id_periode', $idPeriode)
                                      ->where('status_verifikasi_admin', 'Proses')->count();
        $siapDisalurkan     = Pengajuan::where('id_user_pengusul', $user->id_user)
                                  ->where('id_periode', $idPeriode)
                                  ->where('status_verifikasi_admin', 'Layak')->count();

        // 2. Monitoring Kuota Khusus RT Tersebut
        $kuotaRTSaya = KuotaRT::with('jenisBansos')
                            ->where('id_periode', $idPeriode)
                            ->where('rt', $rt)
                            ->where('rw', $rw)
                            ->get()
                            ->map(function($q) {
                                $q->sisa_kuota = $q->kuota - $q->terpakai;
                                return $q;
                            });

        // 3. Tabel Status Pengajuan Terkini
        $pengajuanTerbaru = Pengajuan::with(['warga', 'jenisBansos'])
                            ->where('id_user_pengusul', $user->id_user)
                            ->where('id_periode', $idPeriode)
                            ->orderBy('tgl_pengajuan', 'desc')
                            ->orderBy('id', 'desc')
                            ->get(); 

        $usulanDiproses = Pengajuan::where('id_user_pengusul', $user->id_user)
                              ->whereIn('status_verifikasi_admin', ['Proses', 'Verifikasi Lapangan', 'Menunggu Musdes', 'Siap Keputusan'])
                              ->where('id_periode', $idPeriode)->count();

        $usulanDisetujui = Pengajuan::where('id_user_pengusul', $user->id_user)
                              ->where('status_verifikasi_admin', 'Layak')
                              ->where('id_periode', $idPeriode)->count();

        $riwayatPengajuan = $pengajuanTerbaru->take(10); 

        $rekapBansosRT = JenisBansos::all()->map(function($bansos) use ($user, $idPeriode) {
            $baseQuery = Pengajuan::where('id_user_pengusul', $user->id_user)
                            ->where('id_bansos', $bansos->id)
                            ->where('id_periode', $idPeriode);

            return (object) [
                'nama_bansos' => $bansos->nama_bansos,
                'kode_bansos' => $bansos->kode_bansos,
                'total' => (clone $baseQuery)->count(),
                'layak' => (clone $baseQuery)->where('status_verifikasi_admin', 'Layak')->count(),
                'tidak_layak' => (clone $baseQuery)->where('status_verifikasi_admin', 'Tidak Layak')->count(),
                'proses' => (clone $baseQuery)->whereIn('status_verifikasi_admin', ['Proses', 'Verifikasi Lapangan', 'Menunggu Musdes', 'Siap Keputusan'])->count(),
            ];
        });

        return view('rt.dashboard', compact(
            'user', 'wargaSaya', 'totalUsulanSaya', 'menungguVerifikasi', 'siapDisalurkan',
            'pengajuanTerbaru', 'usulanDiproses', 'usulanDisetujui', 'kuotaRTSaya',
            'riwayatPengajuan', 'rekapBansosRT', 'dataPeriodes', 'periodeTerpilih'
        ));
    }

    // =================================================================
    // 3. FITUR EXPORT REKAPITULASI (EXCEL .XLSX MURNI)
    // =================================================================
    public function exportRekapAdmin(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'Admin') { abort(403); }

        $periodeId = $request->get('id_periode');
        $periode = PeriodeBansos::find($periodeId);
        $namaPeriode = $periode ? str_replace(' ', '_', $periode->nama_periode) : 'Semua_Periode';

        $fileName = "Rekap_Bansos_Desa_Lamong_Admin_{$namaPeriode}.xlsx";

        $query = Pengajuan::with(['warga', 'jenisBansos', 'pengusul'])->orderBy('tgl_pengajuan', 'asc');
        if ($periodeId) {
            $query->where('id_periode', $periodeId);
        }
        $pengajuans = $query->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Rekap Admin');

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Tanggal Pengajuan');
        $sheet->setCellValue('C1', 'NIK');
        $sheet->setCellValue('D1', 'Nama Warga');
        $sheet->setCellValue('E1', 'Alamat / RT');
        $sheet->setCellValue('F1', 'Program Bansos');
        $sheet->setCellValue('G1', 'Status Verifikasi');
        $sheet->setCellValue('H1', 'Skor Desil / Keterangan');

        $sheet->getStyle('A1:H1')->getFont()->setBold(true);

        $row = 2;
        $no = 1;
        foreach ($pengajuans as $p) {
            $desilText = $p->warga->desil ? 'Desil '.$p->warga->desil : 'Belum Diobservasi';
            
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $p->tgl_pengajuan->format('Y-m-d'));
            $sheet->setCellValueExplicit('C' . $row, $p->nik, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('D' . $row, $p->warga->nama_lengkap ?? 'Terhapus');
            $sheet->setCellValue('E' . $row, ($p->warga->alamat_lengkap ?? '') . ' RT ' . ($p->pengusul->wilayah_rt_rw ?? ''));
            $sheet->setCellValue('F' . $row, $p->jenisBansos->nama_bansos ?? '-');
            $sheet->setCellValue('G' . $row, $p->status_verifikasi_admin);
            $sheet->setCellValue('H' . $row, $desilText);
            
            $row++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        
        return response()->stream(
            function () use ($writer) { $writer->save('php://output'); },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
                'Cache-Control' => 'max-age=0',
            ]
        );
    }

    public function exportRekapRT(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'RT') { abort(403); }

        $periodeId = $request->get('id_periode');
        $periode = PeriodeBansos::find($periodeId);
        $namaPeriode = $periode ? str_replace(' ', '_', $periode->nama_periode) : 'Semua_Periode';
        $idRT = Auth::user()->id_user;

        $fileName = "Rekap_Usulan_RT_{$namaPeriode}.xlsx";

        $query = Pengajuan::with(['warga', 'jenisBansos'])
                          ->where('id_user_pengusul', $idRT)
                          ->orderBy('tgl_pengajuan', 'asc');
        if ($periodeId) {
            $query->where('id_periode', $periodeId);
        }
        $pengajuans = $query->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Rekap Usulan RT');

        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Tanggal Pengajuan');
        $sheet->setCellValue('C1', 'NIK');
        $sheet->setCellValue('D1', 'Nama Warga');
        $sheet->setCellValue('E1', 'Program Bansos');
        $sheet->setCellValue('F1', 'Status Verifikasi');

        $sheet->getStyle('A1:F1')->getFont()->setBold(true);

        $row = 2;
        $no = 1;
        foreach ($pengajuans as $p) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $p->tgl_pengajuan->format('Y-m-d'));
            $sheet->setCellValueExplicit('C' . $row, $p->nik, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $sheet->setCellValue('D' . $row, $p->warga->nama_lengkap ?? 'Terhapus');
            $sheet->setCellValue('E' . $row, $p->jenisBansos->nama_bansos ?? '-');
            $sheet->setCellValue('F' . $row, $p->status_verifikasi_admin);
            $row++;
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        return response()->stream(
            function () use ($writer) { $writer->save('php://output'); },
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
                'Cache-Control' => 'max-age=0',
            ]
        );
    }

    // =================================================================
    // 4. FITUR EXPORT REKAPITULASI (.PDF)
    // =================================================================
    public function exportRekapAdminPdf(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'Admin') { abort(403); }

        $periodeId = $request->get('id_periode');
        $periode = PeriodeBansos::find($periodeId);
        $namaPeriode = $periode ? str_replace(' ', '_', $periode->nama_periode) : 'Semua Periode';
        $namaBulan = $namaPeriode; // Menggunakan variabel namaBulan agar view PDF tidak error
        $tahunFilter = ''; // Dikosongkan agar tampilan PDF lebih rapi tanpa mengulang tahun

        $query = Pengajuan::with(['warga', 'jenisBansos'])->orderBy('tgl_pengajuan', 'asc');
        if ($periodeId) {
            $query->where('id_periode', $periodeId);
        }
        $pengajuans = $query->get();

        $pdf = Pdf::loadView('pdf.rekap_bansos', compact('pengajuans', 'namaBulan', 'tahunFilter'));
        $pdf->setPaper('a4', 'landscape');

        $fileName = str_replace(' ', '_', $namaPeriode);
        return $pdf->download("Rekap_Bansos_Desa_Lamong_Admin_{$fileName}.pdf");
    }

    public function exportRekapRTPdf(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'RT') { abort(403); }

        $periodeId = $request->get('id_periode');
        $periode = PeriodeBansos::find($periodeId);
        $namaPeriode = $periode ? str_replace(' ', '_', $periode->nama_periode) : 'Semua Periode';
        $namaBulan = $namaPeriode; // Menjaga kompatibilitas dengan view PDF lama
        $tahunFilter = '';

        $query = Pengajuan::with(['warga', 'jenisBansos'])
                          ->where('id_user_pengusul', Auth::user()->id_user)
                          ->orderBy('tgl_pengajuan', 'asc');
        if ($periodeId) {
            $query->where('id_periode', $periodeId);
        }
        $pengajuans = $query->get();

        $pdf = Pdf::loadView('pdf.rekap_bansos', compact('pengajuans', 'namaBulan', 'tahunFilter'));
        $pdf->setPaper('a4', 'landscape');

        $fileName = str_replace(' ', '_', $namaPeriode);
        return $pdf->download("Rekap_Usulan_RT_{$fileName}.pdf");
    }
}
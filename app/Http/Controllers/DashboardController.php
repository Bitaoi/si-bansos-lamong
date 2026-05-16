<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengajuan;
use App\Models\JenisBansos;
use App\Models\User;
use App\Models\Warga;
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller
{
    // =================================================================
    // 1. DASHBOARD ADMIN
    // =================================================================
    public function indexAdmin(Request $request)
    {
        if (Auth::user()->role !== 'Admin') {
            abort(403, 'Akses Ditolak. Halaman ini khusus Admin.');
        }

        $bulanFilter = $request->get('bulan', date('m'));
        $tahunFilter = $request->get('tahun', date('Y'));

        $totalPengajuan     = Pengajuan::whereMonth('tgl_pengajuan', $bulanFilter)->whereYear('tgl_pengajuan', $tahunFilter)->count();
        $menungguVerifikasi = Pengajuan::whereIn('status_verifikasi_admin', ['Proses', 'Verifikasi Lapangan', 'Menunggu Musdes', 'Siap Keputusan'])
                                       ->whereMonth('tgl_pengajuan', $bulanFilter)->whereYear('tgl_pengajuan', $tahunFilter)->count();
        $penerimaLayak      = Pengajuan::where('status_verifikasi_admin', 'Layak')
                                       ->whereMonth('tgl_pengajuan', $bulanFilter)->whereYear('tgl_pengajuan', $tahunFilter)->count();
        $totalWarga         = Warga::count(); 

        $totalKuota = JenisBansos::sum('kuota_penerima'); 
        $terpakai   = Pengajuan::where('status_verifikasi_admin', 'Layak')->count();
        $sisaKuota  = $totalKuota - $terpakai;

        // ===========================================================================
        // PERBAIKAN: Tabel Status Pengajuan Terkini difilter berdasarkan bulan & tahun
        // ===========================================================================
        $pengajuanTerbaru = Pengajuan::with(['warga', 'jenisBansos'])
                            ->whereMonth('tgl_pengajuan', $bulanFilter)
                            ->whereYear('tgl_pengajuan', $tahunFilter)
                            ->latest('tgl_pengajuan')
                            ->get(); // Menampilkan semua riwayat di periode terkait

        $rekapBansos = JenisBansos::all()->map(function($bansos) use ($bulanFilter, $tahunFilter) {
            $baseQuery = Pengajuan::where('id_bansos', $bansos->id)
                            ->whereMonth('tgl_pengajuan', $bulanFilter)
                            ->whereYear('tgl_pengajuan', $tahunFilter);

            return (object) [
                'nama_bansos' => $bansos->nama_bansos,
                'kode_bansos' => $bansos->kode_bansos,
                'total_diajukan' => (clone $baseQuery)->count(),
                'disetujui' => (clone $baseQuery)->where('status_verifikasi_admin', 'Layak')->count(),
                'ditolak' => (clone $baseQuery)->where('status_verifikasi_admin', 'Tidak Layak')->count(),
                'diproses' => (clone $baseQuery)->whereIn('status_verifikasi_admin', ['Proses', 'Verifikasi Lapangan', 'Menunggu Musdes', 'Siap Keputusan'])->count(),
            ];
        });

        $daftarTahun = Pengajuan::selectRaw('YEAR(tgl_pengajuan) as tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');
        if($daftarTahun->isEmpty()) { $daftarTahun = collect([date('Y')]); }

        return view('admin.dashboard', compact(
            'totalPengajuan', 'menungguVerifikasi', 'penerimaLayak', 'totalWarga', 'sisaKuota',
            'pengajuanTerbaru', 'rekapBansos', 'bulanFilter', 'tahunFilter', 'daftarTahun'
        ));
    }

    public function kuotaDetail()
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }
        $bansos = \App\Models\JenisBansos::with('pengajuan')->get();
        return view('admin.kuota.index', compact('bansos'));
    }

    // =================================================================
    // 2. DASHBOARD KETUA RT
    // =================================================================
    public function indexRT(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'RT') { abort(403, 'Akses Ditolak. Halaman ini khusus Ketua RT.'); }

        $bulanFilter = $request->get('bulan', date('m'));
        $tahunFilter = $request->get('tahun', date('Y'));

        $wilayah = explode('/', $user->wilayah_rt_rw);
        $rt = $wilayah[0] ?? ''; 
        
        $wargaSaya          = Warga::where('rt', $rt)->count(); 
        $totalUsulanSaya    = Pengajuan::where('id_user_pengusul', $user->id_user)->count();
        $menungguVerifikasi = Pengajuan::where('id_user_pengusul', $user->id_user)
                                      ->where('status_verifikasi_admin', 'Proses')->count();
        $siapDisalurkan     = Pengajuan::where('id_user_pengusul', $user->id_user)
                                  ->where('status_verifikasi_admin', 'Layak')->count();

        // ===========================================================================
        // PERBAIKAN: Tabel Status Pengajuan Terkini difilter berdasarkan bulan & tahun
        // ===========================================================================
        $pengajuanTerbaru = Pengajuan::with(['warga', 'jenisBansos'])
                            ->where('id_user_pengusul', $user->id_user)
                            ->whereMonth('tgl_pengajuan', $bulanFilter)
                            ->whereYear('tgl_pengajuan', $tahunFilter)
                            ->orderBy('tgl_pengajuan', 'desc')
                            ->orderBy('id', 'desc')
                            ->get(); // Menampilkan semua riwayat di periode terkait

        $totalUsulanRT = Pengajuan::where('id_user_pengusul', $user->id_user)
                              ->whereMonth('tgl_pengajuan', $bulanFilter)
                              ->whereYear('tgl_pengajuan', $tahunFilter)->count();

        $usulanDiproses = Pengajuan::where('id_user_pengusul', $user->id_user)
                              ->whereIn('status_verifikasi_admin', ['Proses', 'Verifikasi Lapangan', 'Menunggu Musdes', 'Siap Keputusan'])
                              ->whereMonth('tgl_pengajuan', $bulanFilter)
                              ->whereYear('tgl_pengajuan', $tahunFilter)->count();

        $usulanDisetujui = Pengajuan::where('id_user_pengusul', $user->id_user)
                              ->where('status_verifikasi_admin', 'Layak')
                              ->whereMonth('tgl_pengajuan', $bulanFilter)
                              ->whereYear('tgl_pengajuan', $tahunFilter)->count();

        $riwayatPengajuan = $pengajuanTerbaru->take(10); 

        $rekapBansosRT = JenisBansos::all()->map(function($bansos) use ($user, $bulanFilter, $tahunFilter) {
            $baseQuery = Pengajuan::where('id_user_pengusul', $user->id_user)
                            ->where('id_bansos', $bansos->id)
                            ->whereMonth('tgl_pengajuan', $bulanFilter)
                            ->whereYear('tgl_pengajuan', $tahunFilter);

            return (object) [
                'nama_bansos' => $bansos->nama_bansos,
                'kode_bansos' => $bansos->kode_bansos,
                'total' => (clone $baseQuery)->count(),
                'layak' => (clone $baseQuery)->where('status_verifikasi_admin', 'Layak')->count(),
                'tidak_layak' => (clone $baseQuery)->where('status_verifikasi_admin', 'Tidak Layak')->count(),
                'proses' => (clone $baseQuery)->whereIn('status_verifikasi_admin', ['Proses', 'Verifikasi Lapangan', 'Menunggu Musdes', 'Siap Keputusan'])->count(),
            ];
        });

        $daftarTahun = Pengajuan::selectRaw('YEAR(tgl_pengajuan) as tahun')->distinct()->orderBy('tahun', 'desc')->pluck('tahun');
        if($daftarTahun->isEmpty()) { $daftarTahun = collect([date('Y')]); }

        return view('rt.dashboard', compact(
            'user', 'wargaSaya', 'totalUsulanSaya', 'menungguVerifikasi', 'siapDisalurkan',
            'pengajuanTerbaru', 'totalUsulanRT', 'usulanDiproses', 'usulanDisetujui',
            'riwayatPengajuan', 'rekapBansosRT', 'bulanFilter', 'tahunFilter', 'daftarTahun'
        ));
    }

    // =================================================================
    // 3. FITUR EXPORT REKAPITULASI (EXCEL .XLSX MURNI)
    // =================================================================
    public function exportRekapAdmin(Request $request)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }

        $bulanFilter = $request->get('bulan', date('m'));
        $tahunFilter = $request->get('tahun', date('Y'));

        $namaBulan = \Carbon\Carbon::create()->month((int)$bulanFilter)->translatedFormat('F');
        $fileName = "Rekap_Bansos_Desa_Lamong_Admin_{$namaBulan}_{$tahunFilter}.xlsx";

        $pengajuans = Pengajuan::with(['warga', 'jenisBansos', 'pengusul'])
                        ->whereMonth('tgl_pengajuan', $bulanFilter)
                        ->whereYear('tgl_pengajuan', $tahunFilter)
                        ->orderBy('tgl_pengajuan', 'asc')
                        ->get();

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
        if (Auth::user()->role !== 'RT') { abort(403); }

        $bulanFilter = $request->get('bulan', date('m'));
        $tahunFilter = $request->get('tahun', date('Y'));
        $idRT = Auth::user()->id_user;

        $namaBulan = \Carbon\Carbon::create()->month((int)$bulanFilter)->translatedFormat('F');
        $fileName = "Rekap_Usulan_RT_{$namaBulan}_{$tahunFilter}.xlsx";

        $pengajuans = Pengajuan::with(['warga', 'jenisBansos'])
                        ->where('id_user_pengusul', $idRT)
                        ->whereMonth('tgl_pengajuan', $bulanFilter)
                        ->whereYear('tgl_pengajuan', $tahunFilter)
                        ->orderBy('tgl_pengajuan', 'asc')
                        ->get();

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
        if (Auth::user()->role !== 'Admin') { abort(403); }

        $bulanFilter = $request->get('bulan', date('m'));
        $tahunFilter = $request->get('tahun', date('Y'));
        $namaBulan = \Carbon\Carbon::create()->month((int)$bulanFilter)->translatedFormat('F');

        $pengajuans = Pengajuan::with(['warga', 'jenisBansos'])
                        ->whereMonth('tgl_pengajuan', $bulanFilter)
                        ->whereYear('tgl_pengajuan', $tahunFilter)
                        ->orderBy('tgl_pengajuan', 'asc')
                        ->get();

        $pdf = Pdf::loadView('pdf.rekap_bansos', compact('pengajuans', 'namaBulan', 'tahunFilter'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download("Rekap_Bansos_Desa_Lamong_Admin_{$namaBulan}_{$tahunFilter}.pdf");
    }

    public function exportRekapRTPdf(Request $request)
    {
        if (Auth::user()->role !== 'RT') { abort(403); }

        $bulanFilter = $request->get('bulan', date('m'));
        $tahunFilter = $request->get('tahun', date('Y'));
        $namaBulan = \Carbon\Carbon::create()->month((int)$bulanFilter)->translatedFormat('F');

        $pengajuans = Pengajuan::with(['warga', 'jenisBansos'])
                        ->where('id_user_pengusul', Auth::user()->id_user)
                        ->whereMonth('tgl_pengajuan', $bulanFilter)
                        ->whereYear('tgl_pengajuan', $tahunFilter)
                        ->orderBy('tgl_pengajuan', 'asc')
                        ->get();

        $pdf = Pdf::loadView('pdf.rekap_bansos', compact('pengajuans', 'namaBulan', 'tahunFilter'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download("Rekap_Usulan_RT_{$namaBulan}_{$tahunFilter}.pdf");
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Auth;

class SuratController extends Controller
{
    public function cetakSurat($id_pengajuan)
    {
        // Pastikan hanya Admin yang bisa mencetak
        if (Auth::user()->role !== 'Admin') { abort(403); }

        // Ambil data pengajuan beserta relasi warga dan jenis bansos
        $pengajuan = Pengajuan::with(['warga', 'jenisBansos'])->findOrFail($id_pengajuan);

        // Buat QR Code (berisi link untuk cek status / data verifikasi)
        // Kita ubah ke base64 agar bisa terbaca oleh library PDF
        $qrCodeData = "Dokumen Sah Desa Lamong. Penerima: " . $pengajuan->warga->nama_lengkap . " | NIK: " . $pengajuan->warga->nik . " | Bansos: " . $pengajuan->jenisBansos->nama_bansos;
        $qrcode = base64_encode(QrCode::format('svg')->size(100)->generate($qrCodeData));

        // Kirim data ke tampilan cetak_pdf.blade.php
        $data = [
            'pengajuan' => $pengajuan,
            'qrcode' => $qrcode,
            'tanggal_cetak' => \Carbon\Carbon::now()->translatedFormat('d F Y')
        ];

        // Buat PDF
        $pdf = Pdf::loadView('admin.surat.cetak_pdf', $data);
        
        // Atur ukuran kertas (A4) dan orientasi (Portrait)
        $pdf->setPaper('A4', 'portrait');

        // Gunakan stream() agar PDF terbuka di tab baru (tidak langsung terdownload)
        return $pdf->stream('Surat_Keterangan_'.$pengajuan->warga->nama_lengkap.'.pdf');
    }
}
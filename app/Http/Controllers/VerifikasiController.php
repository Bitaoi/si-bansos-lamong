<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use Illuminate\Support\Facades\Auth;

class VerifikasiController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }

        $pengajuans = Pengajuan::with(['warga', 'jenisBansos', 'pengusul'])
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);

        return view('admin.verifikasi.index', compact('pengajuans'));
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }

        $pengajuan = Pengajuan::findOrFail($id);
        $tahap = $request->tahap; 

        // TAHAP 1: Jadwalkan Observasi
        if ($tahap == 'jadwal_observasi') {
            $pengajuan->update(['status_verifikasi_admin' => 'Verifikasi Lapangan']);
            return back()->with('success', 'Status diubah: Menunggu Verifikasi Lapangan Dinsos.');
        }
        
        // TAHAP 2: Input Hasil Observasi Lapangan
        elseif ($tahap == 'hasil_observasi') {
            $request->validate([
                'berkas_observasi' => 'required|file|mimes:jpg,png,pdf|max:2048',
                'catatan_observasi' => 'nullable|string'
            ]);
            
            $path = $request->file('berkas_observasi')->store('verifikasi/observasi', 'public');
            
            $pengajuan->update([
                'berkas_observasi' => $path,
                'catatan_observasi' => $request->catatan_observasi,
                'status_verifikasi_admin' => 'Menunggu Musdes'
            ]);
            return back()->with('success', 'Hasil observasi lapangan berhasil diunggah.');
        }
        
        // TAHAP 3: Input Berita Acara Musdes
        elseif ($tahap == 'hasil_musdes') {
            $request->validate([
                'berita_acara_musdes' => 'required|file|mimes:jpg,png,pdf|max:2048'
            ]);
            
            $path = $request->file('berita_acara_musdes')->store('verifikasi/musdes', 'public');
            
            $pengajuan->update([
                'berita_acara_musdes' => $path,
                'status_verifikasi_admin' => 'Siap Keputusan' // Membuka gembok tombol final
            ]);
            return back()->with('success', 'Berita Acara Musdes diunggah. Tombol Keputusan Akhir telah dibuka!');
        }
        
        // TAHAP 4: Keputusan Final (Hanya bisa jika status Siap Keputusan)
        elseif ($tahap == 'final') {
            $request->validate(['status' => 'required|in:Layak,Tidak Layak']);
            
            $pengajuan->update([
                'status_verifikasi_admin' => $request->status,
                'keterangan_ditolak' => $request->status == 'Tidak Layak' ? $request->keterangan_ditolak : null
            ]);
            
            $pesan = $request->status == 'Layak' ? 'Data Resmi DISETUJUI (Layak)' : 'Data DITOLAK (Tidak Layak)';
            return back()->with('success', $pesan);
        }

        return back()->with('error', 'Aksi tidak valid.');
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use Illuminate\Support\Facades\Auth;

class VerifikasiController extends Controller
{
    // 1. TAMPILKAN DAFTAR PENGAJUAN
    public function index()
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }

        // Ambil pengajuan yang statusnya 'Proses' (prioritas) ditaruh paling atas
        $pengajuans = Pengajuan::with(['warga', 'jenisBansos', 'pengusul'])
                        ->orderByRaw("FIELD(status_verifikasi_admin, 'Proses', 'Layak', 'Tidak Layak')")
                        ->latest()
                        ->paginate(10);

        return view('admin.verifikasi.index', compact('pengajuans'));
    }

    // 2. PROSES VERIFIKASI (TERIMA / TOLAK)
    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }

        $request->validate([
            'status' => 'required|in:Layak,Tidak Layak'
        ]);

        $pengajuan = Pengajuan::findOrFail($id);

        // Update status
        $pengajuan->update([
            'status_verifikasi_admin' => $request->status,
            // Jika ditolak, bisa tambahkan keterangan (opsional)
            'keterangan_ditolak' => $request->status == 'Tidak Layak' ? 'Ditolak oleh Admin setelah verifikasi.' : null
        ]);

        $pesan = $request->status == 'Layak' ? 'Pengajuan DISETUJUI!' : 'Pengajuan DITOLAK.';
        
        return redirect()->back()->with('success', $pesan);
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\Penyaluran;
use Illuminate\Support\Facades\Auth;

class PenyaluranController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }

        // 1. Ambil ID pengajuan yang sudah masuk ke tabel penyaluran
        $disalurkanIds = Penyaluran::pluck('id_pengajuan')->toArray();

        // 2. Antrean: Pengajuan yang statusnya 'Layak' TAPI BELUM disalurkan
        $antrean = Pengajuan::with(['warga', 'jenisBansos'])
                    ->where('status_verifikasi_admin', 'Layak')
                    ->whereNotIn('id', $disalurkanIds)
                    ->orderBy('updated_at', 'desc')
                    ->get();

        // 3. Riwayat: Data yang sudah berhasil disalurkan
        $riwayat = Penyaluran::with(['pengajuan.warga', 'pengajuan.jenisBansos'])
                    ->orderBy('tgl_terima', 'desc')
                    ->get();

        return view('admin.penyaluran.index', compact('antrean', 'riwayat'));
    }

    public function store(Request $request, $id)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }

        $request->validate([
            'tgl_terima' => 'required|date',
            'foto_bukti' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'keterangan' => 'nullable|string'
        ]);

        // Simpan foto bukti serah terima
        $path = $request->file('foto_bukti')->store('penyaluran/bukti', 'public');

        // Catat ke database
        Penyaluran::create([
            'id_pengajuan' => $id,
            'tgl_terima'   => $request->tgl_terima,
            'foto_bukti'   => $path,
            'keterangan'   => $request->keterangan
        ]);

        return back()->with('success', 'Berhasil! Bantuan Sosial telah disalurkan dan bukti tercatat di sistem.');
    }
}
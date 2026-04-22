<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\Warga;
use App\Models\JenisBansos;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    // 1. TAMPILKAN FORM
    public function create()
    {
        // Ambil bansos yang Aktif saja
        $bansos = JenisBansos::where('status', 'Aktif')->get();
        return view('rt.pengajuan.create', compact('bansos'));
    }

    // 2. FITUR CARI WARGA (AJAX)
    public function searchWarga(Request $request)
    {
        $keyword = $request->keyword;
        
        $warga = Warga::where('nik', $keyword)
                    ->orWhere('nama_lengkap', 'LIKE', "%{$keyword}%")
                    ->first();

        if ($warga) {
            $jumlahAnggota = Warga::where('no_kk', $warga->no_kk)->count();

            return response()->json([
                'status' => 'success',
                'data' => [
                    'nik' => $warga->nik,
                    'nama' => $warga->nama_lengkap,
                    'no_kk' => $warga->no_kk,
                    'alamat' => $warga->alamat_lengkap . " RT " . $warga->rt . " RW " . $warga->rw,
                    'jumlah_keluarga' => $jumlahAnggota
                ]
            ]);
        }

        return response()->json(['status' => 'not_found']);
    }

    // 3. SIMPAN PENGAJUAN (TANPA HITUNG DESIL)
    public function store(Request $request)
    {
        // Validasi bersih, tanpa array checklist
        $request->validate([
            'nik' => 'required|exists:wargas,nik',
            'id_bansos' => 'required',
            'alasan' => 'required|string',
            'penghasilan' => 'required|numeric',
            'foto_ktp' => 'required|image|max:2048', 
            'foto_kk' =>'required|image|max:2048',
            'foto_rumah_depan' => 'required|image|max:2048',
            'foto_rumah_dalam' => 'nullable|image|max:2048'
        ]);

        // Upload Foto
        $pathKtp = $request->file('foto_ktp')->store('pengajuan/ktp', 'public');
        $pathKk = $request->file('foto_kk')->store('pengajuan/kk', 'public');
        $pathDepan = $request->file('foto_rumah_depan')->store('pengajuan/rumah', 'public');
        $pathDalam = $request->file('foto_rumah_dalam') ? $request->file('foto_rumah_dalam')->store('pengajuan/rumah', 'public') : null;

        // Ambil ID RT yang login
        $idPengusul = Auth::user()->id_user ?? Auth::id();

        // Simpan Data Pengajuan Awal
        Pengajuan::create([
            'nik' => $request->nik,
            'id_bansos' => $request->id_bansos,
            'id_user_pengusul' => $idPengusul,
            'tgl_pengajuan' => now(),
            'alasan_pengajuan' => $request->alasan,
            'estimasi_penghasilan' => $request->penghasilan,
            'checklist_kriteria' => [], // Dikosongkan karena form kriteria dipindah ke Admin
            'foto_ktp' => $pathKtp,
            'foto_kk' => $pathKk,
            'foto_rumah_depan' => $pathDepan,
            'foto_rumah_dalam' => $pathDalam,
            'status_verifikasi_admin' => 'Proses' // Menunggu tindakan Admin
        ]);

        return redirect()->route('rt.dashboard')->with('success', "Usulan berhasil dikirim! Menunggu verifikasi lapangan dan perhitungan Desil oleh Admin Desa.");
    }
}
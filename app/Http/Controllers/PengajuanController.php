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

    // 3. SIMPAN PENGAJUAN & HITUNG SKOR (SPK DESIL)
    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|exists:wargas,nik',
            'id_bansos' => 'required',
            'alasan' => 'required|string',
            'penghasilan' => 'required|numeric',
            'foto_ktp' => 'required|image|max:2048', 
            'foto_rumah_depan' => 'required|image|max:2048',
            'checklist' => 'nullable|array' 
        ]);

        // Upload Foto
        $pathKtp = $request->file('foto_ktp')->store('pengajuan/ktp', 'public');
        $pathDepan = $request->file('foto_rumah_depan')->store('pengajuan/rumah', 'public');
        $pathDalam = $request->file('foto_rumah_dalam') ? $request->file('foto_rumah_dalam')->store('pengajuan/rumah', 'public') : null;

        // =========================================================
        // PROSES SPK: SKORING & PENENTUAN DESIL
        // =========================================================
        
        // Ambil data checklist (jika kosong, jadikan array kosong)
        $daftarCentang = $request->checklist ?? [];
        
        // Hitung total kriteria yang dicentang "Ya"
        $totalSkor = count($daftarCentang); 
        
        $desil = 4; // Default: Desil 4 (Tidak Miskin / Rentan)
        
        // Logika IF-ELSE Penentuan Desil
        if ($totalSkor >= 11) {
            $desil = 1; // Sangat Miskin
        } elseif ($totalSkor >= 8 && $totalSkor <= 10) {
            $desil = 2; // Miskin
        } elseif ($totalSkor >= 5 && $totalSkor <= 7) {
            $desil = 3; // Hampir Miskin
        } else {
            $desil = 4; // Tidak Miskin / Rentan
        }

        // UPDATE DATA WARGA: Simpan hasil skor Desil ke tabel warga
        Warga::where('nik', $request->nik)->update([
            'desil' => $desil
        ]);

        // =========================================================
        // SIMPAN DATA PENGAJUAN
        // =========================================================
        
        // Ambil ID RT yang login
        $idPengusul = Auth::user()->id_user;

        Pengajuan::create([
            'nik' => $request->nik,
            'id_bansos' => $request->id_bansos,
            'id_user_pengusul' => $idPengusul,
            'tgl_pengajuan' => now(),
            'alasan_pengajuan' => $request->alasan,
            'estimasi_penghasilan' => $request->penghasilan,
            'checklist_kriteria' => $daftarCentang, // Simpan array checklist
            'foto_ktp_kk' => $pathKtp,
            'foto_rumah_depan' => $pathDepan,
            'foto_rumah_dalam' => $pathDalam,
            'status_verifikasi_admin' => 'Proses'
        ]);

        // =========================================================
        // KEMBALI KE DASHBOARD DENGAN NOTIFIKASI DINAMIS
        // =========================================================
        
        // Buat pesan dinamis agar RT langsung tahu hasilnya
        $kategori = ['1' => 'Sangat Miskin', '2' => 'Miskin', '3' => 'Hampir Miskin', '4' => 'Rentan/Mampu'];
        $teksKategori = $kategori[$desil];

        return redirect()->route('rt.dashboard')->with('success', "Berhasil! Pengajuan terkirim. Berdasarkan $totalSkor kriteria yang Anda centang, warga ini masuk kategori Desil $desil ($teksKategori).");
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\Warga;
use App\Models\JenisBansos;
use App\Models\JadwalBansos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengajuanController extends Controller
{
    public function create()
    {
        $jadwalUsulan = JadwalBansos::where('nama_tahapan', 'LIKE', '%Usulan%')->first();
        $hariIni = (int) date('d');

        if ($jadwalUsulan && ($hariIni < $jadwalUsulan->hari_mulai || $hariIni > $jadwalUsulan->hari_selesai)) {
            return redirect()->route('rt.dashboard')->with('error', 'Akses ditolak! Saat ini masa pengajuan bansos sedang ditutup. Silakan ajukan kembali pada tanggal ' . $jadwalUsulan->hari_mulai . ' s/d ' . $jadwalUsulan->hari_selesai . ' bulan depan.');
        }

        $bansos = JenisBansos::where('status', 'Aktif')->get();
        return view('rt.pengajuan.create', compact('bansos'));
    }

    public function searchWarga(Request $request)
    {
        $keyword = $request->keyword;
        $warga = Warga::where('nik', $keyword)->orWhere('nama_lengkap', 'LIKE', "%{$keyword}%")->first();

        if ($warga) {
            $jumlahAnggota = Warga::where('no_kk', $warga->no_kk)->count();
            return response()->json([
                'status' => 'success',
                'data' => [
                    'nik' => $warga->nik, 'nama' => $warga->nama_lengkap, 'no_kk' => $warga->no_kk,
                    'alamat' => $warga->alamat_lengkap . " RT " . $warga->rt . " RW " . $warga->rw,
                    'jumlah_keluarga' => $jumlahAnggota
                ]
            ]);
        }
        return response()->json(['status' => 'not_found']);
    }

    public function store(Request $request)
    {
        $jadwalUsulan = JadwalBansos::where('nama_tahapan', 'LIKE', '%Usulan%')->first();
        $hariIni = (int) date('d');

        if ($jadwalUsulan && ($hariIni < $jadwalUsulan->hari_mulai || $hariIni > $jadwalUsulan->hari_selesai)) {
            return redirect()->route('rt.dashboard')->with('error', 'Gagal menyimpan! Batas waktu pengajuan bansos bulan ini baru saja berakhir.');
        }

        $bansos = JenisBansos::findOrFail($request->id_bansos);

        if ($bansos->sisa_kuota <= 0) {
            return redirect()->back()->with('error', "Gagal mengajukan! Kuota untuk program {$bansos->nama_bansos} sudah penuh.")->withInput();
        }

        // VALIDASI DIPERBARUI: Hapus KTP dan KK
        $request->validate([
            'nik' => 'required|exists:wargas,nik',
            'id_bansos' => 'required',
            'tgl_pengajuan' => 'required|date',
            'alasan' => 'required|string',
            'penghasilan' => 'required|numeric',
            'foto_rumah_depan' => 'required|image|max:2048',
            'foto_rumah_dalam' => 'nullable|image|max:2048'
        ]);

        $pathDepan = $request->file('foto_rumah_depan')->store('pengajuan/rumah', 'public');
        $pathDalam = $request->file('foto_rumah_dalam') ? $request->file('foto_rumah_dalam')->store('pengajuan/rumah', 'public') : null;

        $idPengusul = Auth::user()->id_user ?? Auth::id();

        Pengajuan::create([
            'nik' => $request->nik,
            'id_bansos' => $request->id_bansos,
            'id_user_pengusul' => $idPengusul,
            'tgl_pengajuan' => $request->tgl_pengajuan,
            'alasan_pengajuan' => $request->alasan,
            'estimasi_penghasilan' => $request->penghasilan,
            'checklist_kriteria' => [], 
            'foto_rumah_depan' => $pathDepan,
            'foto_rumah_dalam' => $pathDalam,
            'status_verifikasi_admin' => 'Proses'
        ]);

        return redirect()->route('rt.dashboard')->with('success', "Usulan berhasil dikirim! Menunggu verifikasi lapangan dan perhitungan Desil oleh Admin Desa.");
    }

    public function destroy($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        $idPengusul = Auth::user()->id_user ?? Auth::id();

        if ($pengajuan->id_user_pengusul == $idPengusul && $pengajuan->status_verifikasi_admin == 'Proses') {
            if ($pengajuan->foto_rumah_depan) Storage::disk('public')->delete($pengajuan->foto_rumah_depan);
            if ($pengajuan->foto_rumah_dalam) Storage::disk('public')->delete($pengajuan->foto_rumah_dalam);

            $pengajuan->delete();
            return redirect()->route('rt.dashboard')->with('success', 'Pengajuan warga berhasil dibatalkan dan ditarik kembali.');
        }

        return redirect()->route('rt.dashboard')->with('error', 'Akses ditolak! Pengajuan sudah divalidasi oleh Admin, atau data ini bukan milik Anda.');
    }
}
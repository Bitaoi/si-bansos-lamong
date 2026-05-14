<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\SurveiEkonomi; 
use Illuminate\Support\Facades\Auth;

class VerifikasiController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }

        $pengajuans = Pengajuan::with(['warga', 'jenisBansos', 'pengusul', 'surveiEkonomi'])
                        ->orderByRaw("FIELD(status_verifikasi_admin, 'Proses', 'Verifikasi Lapangan', 'Menunggu Musdes', 'Siap Keputusan', 'Layak', 'Tidak Layak')")
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);

        return view('admin.verifikasi.index', compact('pengajuans'));
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }

        $pengajuan = Pengajuan::findOrFail($id);
        $tahap = $request->tahap; 

        // TAHAP 1: Jadwalkan Observasi (Menyimpan Tanggal)
        if ($tahap == 'jadwal_observasi') {
            $request->validate([
                'tgl_observasi' => 'required|date'
            ]);

            $pengajuan->update([
                'status_verifikasi_admin' => 'Verifikasi Lapangan',
                'tgl_observasi' => $request->tgl_observasi
            ]);

            return back()->with('success', 'Jadwal Observasi ditetapkan. Status berubah: Menunggu Verifikasi Lapangan.');
        }
        
        // TAHAP 2: Input Sensus Lapangan & Otomatisasi Skoring PMT
        elseif ($tahap == 'hasil_observasi') {
            $request->validate([
                'luas_lantai' => 'required|string',
                'jenis_lantai' => 'required|string',
                'jenis_dinding' => 'required|string',
                'sumber_air' => 'required|string',
                'daya_listrik' => 'required|string',
                'kendaraan' => 'required|string',
                'elektronik' => 'required|string',
                'ternak_lahan' => 'required|string',
                'pendidikan_kk' => 'required|string',
                'pekerjaan' => 'required|string',
                'jml_tanggungan' => 'required|string',
                'berkas_observasi' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
                'catatan_observasi' => 'nullable|string'
            ]);
            
            $hasilKalkulasi = SurveiEkonomi::kalkulasiDesil($request->all());

            SurveiEkonomi::updateOrCreate(
                ['pengajuan_id' => $id],
                [
                    'luas_lantai' => $request->luas_lantai,
                    'jenis_lantai' => $request->jenis_lantai,
                    'jenis_dinding' => $request->jenis_dinding,
                    'sumber_air' => $request->sumber_air,
                    'daya_listrik' => $request->daya_listrik,
                    'kendaraan' => $request->kendaraan,
                    'elektronik' => $request->elektronik,
                    'ternak_lahan' => $request->ternak_lahan,
                    'pendidikan_kk' => $request->pendidikan_kk,
                    'pekerjaan' => $request->pekerjaan,
                    'jml_tanggungan' => $request->jml_tanggungan,
                    'total_skor' => $hasilKalkulasi['total_skor'],
                    'desil_hasil' => $hasilKalkulasi['desil']
                ]
            );

            $path = null;
            if ($request->hasFile('berkas_observasi')) {
                $path = $request->file('berkas_observasi')->store('verifikasi/observasi', 'public');
            }
            
            $pengajuan->update([
                'berkas_observasi' => $path ?? $pengajuan->berkas_observasi,
                'catatan_observasi' => $request->catatan_observasi,
                'status_verifikasi_admin' => 'Menunggu Musdes'
            ]);

            $pengajuan->warga->update(['desil' => $hasilKalkulasi['desil']]);

            return back()->with('success', "Sensus tersimpan! Warga mendapat Skor " . $hasilKalkulasi['total_skor'] . " (Desil " . $hasilKalkulasi['desil'] . "). Status berlanjut ke Menunggu Musdes.");
        }
        
        // TAHAP 3: Input Berita Acara Musdes
        elseif ($tahap == 'hasil_musdes') {
            $request->validate([
                'berita_acara_musdes' => 'required|file|mimes:jpg,png,pdf|max:2048'
            ]);
            
            $path = $request->file('berita_acara_musdes')->store('verifikasi/musdes', 'public');
            
            $pengajuan->update([
                'berita_acara_musdes' => $path,
                'status_verifikasi_admin' => 'Siap Keputusan'
            ]);
            return back()->with('success', 'Berita Acara Musdes diunggah. Tombol Keputusan Akhir telah dibuka!');
        }
        
        // TAHAP 4: Keputusan Final
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
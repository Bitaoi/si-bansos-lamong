<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\SurveiEkonomi; // Tambahkan ini untuk memanggil model Survei
use Illuminate\Support\Facades\Auth;

class VerifikasiController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }

        // Tambahkan 'surveiEkonomi' pada eager loading agar bisa menampilkan 
        // skor dan desil di tabel dashboard verifikasi (jika sudah diisi)
        $pengajuans = Pengajuan::with(['warga', 'jenisBansos', 'pengusul', 'surveiEkonomi'])
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
            return back()->with('success', 'Status diubah: Menunggu Verifikasi Lapangan (Ground Check).');
        }
        
        // TAHAP 2: Sensus Lokal & Otomatisasi Skoring PMT (Desil)
        elseif ($tahap == 'hasil_observasi') {
            // 1. Validasi input form radio button
            $request->validate([
                'jenis_lantai' => 'required|string',
                'jenis_dinding' => 'required|string',
                'sumber_air' => 'required|string',
                'daya_listrik' => 'required|string',
                'kepemilikan_aset' => 'required|string',
                'berkas_observasi' => 'nullable|file|mimes:jpg,png,pdf|max:2048', // Opsional, jaga-jaga kalau mau lampirkan foto rumah
                'catatan_observasi' => 'nullable|string'
            ]);
            
            // 2. Logika Kalkulasi PMT (Bobot Skor)
            // Pastikan value (Tanah, Bambu, dll) sama persis dengan value di form HTML/Blade kamu
            $bobotLantai = ['Tanah' => 20, 'Semen' => 10, 'Keramik' => 5];
            $bobotDinding = ['Bambu' => 20, 'Kayu' => 10, 'Tembok' => 5];
            $bobotListrik = ['Tidak Ada' => 25, '450W' => 15, '900W' => 5];
            $bobotAset = ['Tidak Ada' => 15, 'Motor/Kulkas' => 5];

            // Tambahkan fallback "?? 0" agar tidak error jika ada value yang tidak cocok
            $skorLantai = $bobotLantai[$request->jenis_lantai] ?? 0;
            $skorDinding = $bobotDinding[$request->jenis_dinding] ?? 0;
            $skorListrik = $bobotListrik[$request->daya_listrik] ?? 0;
            $skorAset = $bobotAset[$request->kepemilikan_aset] ?? 0;

            $totalSkor = $skorLantai + $skorDinding + $skorListrik + $skorAset;

            // 3. Tentukan Label Desil
            if($totalSkor >= 65) { $desil = 1; }
            elseif($totalSkor >= 45) { $desil = 2; }
            elseif($totalSkor >= 30) { $desil = 3; }
            else { $desil = 4; }

            // 4. Simpan ke tabel survei_ekonomis
            // Menggunakan updateOrCreate agar jika admin salah input dan submit ulang, 
            // datanya diupdate, bukan membuat baris ganda.
            SurveiEkonomi::updateOrCreate(
                ['pengajuan_id' => $id],
                [
                    'jenis_lantai' => $request->jenis_lantai,
                    'jenis_dinding' => $request->jenis_dinding,
                    'sumber_air' => $request->sumber_air,
                    'daya_listrik' => $request->daya_listrik,
                    'kepemilikan_aset' => $request->kepemilikan_aset,
                    'total_skor' => $totalSkor,
                    'desil_hasil' => $desil
                ]
            );

            // 5. Simpan file foto/berkas jika dilampirkan (kode lamamu tetap jalan)
            $path = null;
            if ($request->hasFile('berkas_observasi')) {
                $path = $request->file('berkas_observasi')->store('verifikasi/observasi', 'public');
            }
            
            // 6. Update status Pengajuan & Desil Warga
            $pengajuan->update([
                'berkas_observasi' => $path ?? $pengajuan->berkas_observasi,
                'catatan_observasi' => $request->catatan_observasi,
                'status_verifikasi_admin' => 'Menunggu Musdes'
            ]);

            // Set desil warga secara otomatis
            $pengajuan->warga->update(['desil' => $desil]);

            return back()->with('success', "Sensus tersimpan! Warga mendapat Skor $totalSkor (Desil $desil) dan status berlanjut ke Menunggu Musdes.");
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
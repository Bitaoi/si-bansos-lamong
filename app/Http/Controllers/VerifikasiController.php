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

        // TAHAP 1: Jadwalkan Observasi
        if ($tahap == 'jadwal_observasi') {
            $request->validate(['tgl_observasi' => 'required|date']);
            $pengajuan->update([
                'status_verifikasi_admin' => 'Verifikasi Lapangan',
                'tgl_observasi' => $request->tgl_observasi
            ]);
            return back()->with('success', 'Jadwal Observasi ditetapkan.');
        }
        
        // TAHAP 2: Input Sensus Lapangan & Foto Multiple
        elseif ($tahap == 'hasil_observasi') {
            $request->validate([
                'luas_lantai' => 'required|string',
                'foto_lantai' => 'required|array',
                'foto_lantai.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'jenis_lantai' => 'required|string',
                'jenis_dinding' => 'required|string',
                'foto_dinding' => 'required|array',
                'foto_dinding.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'foto_wc_air' => 'required|array',
                'foto_wc_air.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'sumber_air' => 'required|string',
                'foto_sumber_air' => 'required|array',
                'foto_sumber_air.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'daya_listrik' => 'required|string',
                'foto_listrik' => 'required|array',
                'foto_listrik.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'kendaraan' => 'required|string',
                'foto_kendaraan' => 'required|array',
                'foto_kendaraan.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'elektronik' => 'required|string',
                'foto_elektronik' => 'required|array',
                'foto_elektronik.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'ternak_lahan' => 'required|string',
                'foto_ternak' => 'required|array',
                'foto_ternak.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'pendidikan_kk' => 'required|string',
                'pekerjaan' => 'required|string',
                'jml_tanggungan' => 'required|string',
                'berkas_observasi' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
            ], [
                'foto_lantai.required' => 'Foto dokumentasi lantai wajib diunggah.',
                'foto_dinding.required' => 'Foto dokumentasi dinding wajib diunggah.',
                'foto_wc_air.required' => 'Foto dokumentasi WC/Sanitasi wajib diunggah.',
                'foto_sumber_air.required' => 'Foto dokumentasi sumber air wajib diunggah.',
                'foto_listrik.required' => 'Foto dokumentasi meteran listrik wajib diunggah.',
                'foto_kendaraan.required' => 'Foto dokumentasi kendaraan wajib diunggah.',
                'foto_elektronik.required' => 'Foto dokumentasi barang elektronik wajib diunggah.',
                'foto_ternak.required' => 'Foto dokumentasi hewan ternak/lahan wajib diunggah.'
            ]);
            
            $hasilKalkulasi = SurveiEkonomi::kalkulasiDesil($request->all());

            // Upload Multiple Foto
            $kategoriFoto = ['foto_lantai', 'foto_dinding', 'foto_sumber_air', 'foto_wc_air', 'foto_listrik', 'foto_kendaraan', 'foto_elektronik', 'foto_ternak'];
            $fotoPaths = [];
            foreach ($kategoriFoto as $kategori) {
                $paths = [];
                if ($request->hasFile($kategori)) {
                    foreach ($request->file($kategori) as $file) {
                        $paths[] = $file->store('observasi/kategori', 'public');
                    }
                }
                $fotoPaths[$kategori] = json_encode($paths); 
            }

            SurveiEkonomi::updateOrCreate(
                ['pengajuan_id' => $id],
                [
                    'luas_lantai' => $request->luas_lantai,
                    'foto_lantai' => $fotoPaths['foto_lantai'],
                    'jenis_lantai' => $request->jenis_lantai,
                    'jenis_dinding' => $request->jenis_dinding,
                    'foto_dinding' => $fotoPaths['foto_dinding'],
                    'foto_wc_air' => $fotoPaths['foto_wc_air'],
                    'foto_sumber_air' => $fotoPaths['foto_sumber_air'],
                    'sumber_air' => $request->sumber_air,
                    'daya_listrik' => $request->daya_listrik,
                    'foto_listrik' => $fotoPaths['foto_listrik'],
                    'kendaraan' => $request->kendaraan,
                    'foto_kendaraan' => $fotoPaths['foto_kendaraan'],
                    'elektronik' => $request->elektronik,
                    'foto_elektronik' => $fotoPaths['foto_elektronik'],
                    'ternak_lahan' => $request->ternak_lahan,
                    'foto_ternak' => $fotoPaths['foto_ternak'],
                    'pendidikan_kk' => $request->pendidikan_kk,
                    'pekerjaan' => $request->pekerjaan,
                    'jml_tanggungan' => $request->jml_tanggungan,
                    'total_skor' => $hasilKalkulasi['total_skor'],
                    'desil_hasil' => $hasilKalkulasi['desil']
                ]
            );

            $berkasPath = $request->hasFile('berkas_observasi') ? $request->file('berkas_observasi')->store('verifikasi/observasi', 'public') : $pengajuan->berkas_observasi;
            $pengajuan->update([
                'berkas_observasi' => $berkasPath,
                'catatan_observasi' => $request->catatan_observasi,
                'status_verifikasi_admin' => 'Menunggu Musdes'
            ]);

            $pengajuan->warga->update(['desil' => $hasilKalkulasi['desil']]);
            return back()->with('success', "Sensus tersimpan! Skor: " . $hasilKalkulasi['total_skor']);
        }
        
        // TAHAP 3: Berita Acara Musdes
        elseif ($tahap == 'hasil_musdes') {
            $request->validate(['berita_acara_musdes' => 'required|file|mimes:jpg,png,pdf|max:2048']);
            $path = $request->file('berita_acara_musdes')->store('verifikasi/musdes', 'public');
            $pengajuan->update(['berita_acara_musdes' => $path, 'status_verifikasi_admin' => 'Siap Keputusan']);
            return back()->with('success', 'Berita Acara Musdes diunggah.');
        }
        
        // TAHAP 4: Keputusan Final
        elseif ($tahap == 'final') {
            $request->validate([
                'status' => 'required|in:Layak,Tidak Layak',
                'keterangan_ditolak' => 'required_if:status,Tidak Layak'
            ], [
                'keterangan_ditolak.required_if' => 'alasan wajib diisi.'
            ]);
            
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
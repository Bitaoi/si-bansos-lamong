<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\Warga;
use App\Models\JenisBansos;
use App\Models\JadwalBansos;
use App\Models\PeriodeBansos;
use App\Models\KuotaRT;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PengajuanController extends Controller
{
    public function create()
    {
        // Cek Periode Aktif
        $periodeAktif = PeriodeBansos::where('status', 'Aktif')->first();
        if (!$periodeAktif) {
            return redirect()->route('rt.dashboard')->with('error', 'Akses ditolak! Belum ada Periode Bansos yang aktif.');
        }

        $jadwalUsulan = JadwalBansos::where('nama_tahapan', 'LIKE', '%Usulan%')->first();
        $hariIni = (int) date('d');

        if ($jadwalUsulan && ($hariIni < $jadwalUsulan->hari_mulai || $hariIni > $jadwalUsulan->hari_selesai)) {
            return redirect()->route('rt.dashboard')->with('error', 'Akses ditolak! Masa pengajuan bansos sedang ditutup. Silakan ajukan kembali pada tanggal ' . $jadwalUsulan->hari_mulai . ' s/d ' . $jadwalUsulan->hari_selesai . ' bulan depan.');
        }

        $bansos = JenisBansos::where('status', 'Aktif')->get();
        return view('rt.pengajuan.create', compact('bansos', 'periodeAktif'));
    }

    public function searchWarga(Request $request)
    {
        $keyword = $request->keyword;
        
        $warga = Warga::where('nik', $keyword)
            ->orWhere('no_kk', $keyword)
            ->first();

        $periodeAktif = PeriodeBansos::where('status', 'Aktif')->first();

        if ($warga && $periodeAktif) {
            
            // 1. Ambil seluruh anggota keluarga dan URUTKAN dari yang TERTUA (tanggal_lahir ASC)
            $anggotaKeluarga = Warga::where('no_kk', $warga->no_kk)
                ->orderBy('tanggal_lahir', 'asc')
                ->get();
            
            // =========================================================================
            // LOGIKA PENENTUAN STRUKTUR KELUARGA OTOMATIS (MENGABAIKAN "Belum Diisi")
            // =========================================================================
            // A. Kepala Keluarga: Laki-laki tertua. Jika tidak ada Laki-laki, maka orang tertua (index 0).
            $kepalaKeluarga = $anggotaKeluarga->whereIn('jenis_kelamin', ['L', 'Laki-laki'])->first() 
                              ?? $anggotaKeluarga->first();

            // B. Istri: Perempuan tertua yang sudah kawin/cerai, dan BUKAN Kepala Keluarga
            $istri = $anggotaKeluarga->whereIn('jenis_kelamin', ['P', 'Perempuan'])
                              ->where('nik', '!=', $kepalaKeluarga->nik)
                              ->whereIn('status_kawin', ['Kawin', 'Cerai Hidup', 'Cerai Mati', 'S'])
                              ->first();

            $statusBlokirKK = false;
            $pesanBlokir = '';
            $listKeluarga = [];

            // Pengecekan Riwayat & Assign Peran
            foreach ($anggotaKeluarga as $ak) {
                // Pengecekan Daftar Ganda & Jeda 1 Periode
                $cekDaftar = Pengajuan::where('nik', $ak->nik)->where('id_periode', $periodeAktif->id)->first();
                if ($cekDaftar) {
                    $statusBlokirKK = true;
                    $pesanBlokir = "Ditolak! Keluarga ini sudah diajukan atas nama {$ak->nama_lengkap} pada periode ini.";
                }

                $riwayatLama = Pengajuan::where('nik', $ak->nik)->whereIn('status_verifikasi_admin', ['Layak', 'Siap Keputusan'])->latest('id_periode')->first();
                if ($riwayatLama && $riwayatLama->id_periode == ($periodeAktif->id - 1)) {
                    $statusBlokirKK = true;
                    $pesanBlokir = "Ditolak! Keluarga ini baru saja menerima bantuan pada periode sebelumnya. Pemerataan mengharuskan adanya jeda 1 periode.";
                }

                // C. PENERAPAN STATUS
                $peran = $ak->hubungan_keluarga;

                // Jika data dari database 'Belum Diisi', '-', kosong, atau hanya 'Anggota Keluarga'
                if (in_array($peran, ['Belum Diisi', '-', 'Anggota Keluarga', null, ''])) {
                    if ($ak->nik === $kepalaKeluarga->nik) {
                        $peran = ($anggotaKeluarga->count() == 1) ? 'Kepala Keluarga (Mandiri)' : 'Kepala Keluarga';
                    } elseif ($istri && $ak->nik === $istri->nik) {
                        $peran = 'Istri';
                    } else {
                        $peran = 'Anak';
                    }
                }

                $listKeluarga[] = [
                    'nik' => $ak->nik,
                    'nama' => $ak->nama_lengkap,
                    'peran' => $peran,
                    'umur' => $ak->tanggal_lahir ? Carbon::parse($ak->tanggal_lahir)->age . ' Thn' : '-',
                    'status_kawin' => $ak->status_kawin, 
                    'sudah_daftar' => $cekDaftar ? true : false,
                    'status_pengajuan' => $cekDaftar ? $cekDaftar->status_verifikasi_admin : 'Belum Ada',
                ];
            }

            // D. Urutkan Tampilan: Kepala Keluarga di atas, Istri, lalu Anak
            $urutanPeran = ['Kepala Keluarga (Mandiri)' => 1, 'Kepala Keluarga' => 2, 'Istri' => 3, 'Anak' => 4];
            usort($listKeluarga, function($a, $b) use ($urutanPeran) {
                $posA = $urutanPeran[$a['peran']] ?? 5;
                $posB = $urutanPeran[$b['peran']] ?? 5;
                return $posA <=> $posB;
            });

            // Tentukan peran si pendaftar (warga yang NIK-nya diketik di kolom pencarian)
            $peranPendaftar = 'Anggota Keluarga';
            foreach ($listKeluarga as $lk) {
                if ($lk['nik'] === $warga->nik) {
                    $peranPendaftar = $lk['peran']; break;
                }
            }

            return response()->json([
                'status' => 'success',
                'data' => [
                    'nik_pendaftar' => $warga->nik, 
                    'nama_pendaftar' => $warga->nama_lengkap, 
                    'peran_pendaftar' => $peranPendaftar,
                    'no_kk' => $warga->no_kk,
                    'alamat' => $warga->alamat_lengkap . " RT " . $warga->rt . " RW " . $warga->rw,
                    'jumlah_keluarga' => $anggotaKeluarga->count(),
                    'blokir_kk' => $statusBlokirKK,
                    'pesan_blokir' => $pesanBlokir,
                    'anggota_keluarga' => $listKeluarga
                ]
            ]);
        }
        
        return response()->json(['status' => 'not_found']);
    }

    public function store(Request $request)
    {
        $periodeAktif = PeriodeBansos::where('status', 'Aktif')->first();
        if (!$periodeAktif) return redirect()->back()->with('error', 'Tidak ada periode bantuan aktif.');

        $jadwalUsulan = JadwalBansos::where('nama_tahapan', 'LIKE', '%Usulan%')->first();
        $hariIni = (int) date('d');
        if ($jadwalUsulan && ($hariIni < $jadwalUsulan->hari_mulai || $hariIni > $jadwalUsulan->hari_selesai)) {
            return redirect()->route('rt.dashboard')->with('error', 'Batas waktu pengajuan telah berakhir.');
        }

        $request->validate([
            'nik' => 'required|exists:wargas,nik',
            'id_bansos' => 'required|exists:jenis_bansos,id',
            'tgl_pengajuan' => 'required|date',
            'alasan' => 'required|string',
            'penghasilan' => 'required|numeric',
            'foto_rumah_depan' => 'required|image|max:2048',
            'foto_rumah_dalam' => 'nullable|image|max:2048'
        ]);

        $warga = Warga::where('nik', $request->nik)->first();
        
        // PENCEGAHAN GANDA: Ambil seluruh NIK di dalam 1 KK yang sama
        $nikSekeluarga = Warga::where('no_kk', $warga->no_kk)->pluck('nik');

        // 1A. Validasi Ganda 1 KK di Periode Berjalan
        $cekDoubleKK = Pengajuan::whereIn('nik', $nikSekeluarga)
                        ->where('id_periode', $periodeAktif->id)
                        ->first();
                        
        if ($cekDoubleKK) {
            $namaPendaftarTerdahulu = Warga::where('nik', $cekDoubleKK->nik)->value('nama_lengkap');
            return redirect()->back()
                ->with('error', "PENDAFTARAN DITOLAK! 1 KK hanya boleh 1 pengajuan. Keluarga dengan KK ini sudah diajukan atas nama {$namaPendaftarTerdahulu} pada periode ini.")
                ->withInput();
        }

        // 1B. Validasi Jeda 1 Periode untuk 1 KK
        $riwayatPenerimaKK = Pengajuan::whereIn('nik', $nikSekeluarga)
                        ->whereIn('status_verifikasi_admin', ['Layak', 'Siap Keputusan'])
                        ->latest('id_periode')->first();

        if ($riwayatPenerimaKK && $riwayatPenerimaKK->id_periode == ($periodeAktif->id - 1)) {
            return redirect()->back()
                ->with('error', 'DITOLAK! Terdapat anggota dalam KK ini yang baru saja menerima bantuan pada periode sebelumnya. Harus jeda minimal 1 periode untuk pemerataan.')
                ->withInput();
        }

        // 2. Validasi Kuota Berjenjang Tingkat RT
        $wilayah = explode('/', Auth::user()->wilayah_rt_rw ?? '000/000');
        $rt = $wilayah[0] ?? $warga->rt;
        $rw = $wilayah[1] ?? $warga->rw;

        $kuotaRT = KuotaRT::where('id_bansos', $request->id_bansos)
                          ->where('id_periode', $periodeAktif->id)
                          ->where('rt', $rt)
                          ->where('rw', $rw)
                          ->first();

        if ($kuotaRT) {
            if ($kuotaRT->terpakai >= $kuotaRT->kuota_maksimal) {
                return redirect()->back()->with('error', 'Gagal mengajukan! Kuota wilayah RT ' . $rt . '/RW ' . $rw . ' untuk bansos ini sudah penuh.')->withInput();
            }
            $kuotaRT->increment('terpakai');
        }

        $pathDepan = $request->file('foto_rumah_depan')->store('pengajuan/rumah', 'public');
        $pathDalam = $request->file('foto_rumah_dalam') ? $request->file('foto_rumah_dalam')->store('pengajuan/rumah', 'public') : null;

        Pengajuan::create([
            'nik' => $request->nik,
            'id_bansos' => $request->id_bansos,
            'id_periode' => $periodeAktif->id,
            'id_user_pengusul' => Auth::user()->id_user ?? Auth::id(),
            'tgl_pengajuan' => $request->tgl_pengajuan,
            'alasan_pengajuan' => $request->alasan,
            'estimasi_penghasilan' => $request->penghasilan,
            'checklist_kriteria' => [], 
            'foto_rumah_depan' => $pathDepan,
            'foto_rumah_dalam' => $pathDalam,
            'status_verifikasi_admin' => 'Proses'
        ]);

        return redirect()->route('rt.dashboard')->with('success', "Usulan atas nama {$warga->nama_lengkap} berhasil dikirim pada periode {$periodeAktif->nama_periode}.");
    }

    public function destroy($id)
    {
        $pengajuan = Pengajuan::findOrFail($id);
        if ($pengajuan->id_user_pengusul == (Auth::user()->id_user ?? Auth::id()) && $pengajuan->status_verifikasi_admin == 'Proses') {
            
            // Kembalikan Kuota RT
            $warga = $pengajuan->warga;
            $kuotaRT = KuotaRT::where('id_bansos', $pengajuan->id_bansos)
                              ->where('id_periode', $pengajuan->id_periode)
                              ->where('rt', $warga->rt)
                              ->where('rw', $warga->rw)
                              ->first();
                              
            if($kuotaRT && $kuotaRT->terpakai > 0) {
                $kuotaRT->decrement('terpakai');
            }

            if ($pengajuan->foto_rumah_depan) Storage::disk('public')->delete($pengajuan->foto_rumah_depan);
            if ($pengajuan->foto_rumah_dalam) Storage::disk('public')->delete($pengajuan->foto_rumah_dalam);

            $pengajuan->delete();
            return redirect()->route('rt.dashboard')->with('success', 'Pengajuan warga berhasil ditarik kembali dan kuota wilayah telah dikembalikan.');
        }

        return redirect()->route('rt.dashboard')->with('error', 'Akses ditolak!');
    }
}
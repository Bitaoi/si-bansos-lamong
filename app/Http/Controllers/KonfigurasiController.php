<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisBansos;
use App\Models\PeriodeBansos;
use App\Models\JadwalBansos;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KonfigurasiController extends Controller
{
    /**
     * 1. HALAMAN UTAMA PUSAT KONFIGURASI (INDEX)
     * Mengambil data untuk Tab 1 (Bansos), Tab 2 (Periode), dan Tab 3 (Jadwal)
     */
    public function index()
    {
        // Proteksi Keamanan Akses Admin
        if (!Auth::check() || Auth::user()->role !== 'Admin') { 
            abort(403, 'Akses Ditolak. Halaman ini khusus Admin.'); 
        }

        // Data untuk TAB 1: Master Program Bansos
        $jenisBansos = JenisBansos::all();

        // Data untuk TAB 2: Manajemen Periode Bantuan
        $periodes = PeriodeBansos::orderBy('created_at', 'desc')->get();

        // Data untuk TAB 3: Siklus Jadwal Tahapan (Urut berdasarkan periode terbaru & hari mulai)
        $jadwals = JadwalBansos::with('periode')
            ->orderBy('id_periode', 'desc')
            ->orderBy('hari_mulai', 'asc')
            ->get();

        // Data Master RT untuk di-looping di dalam Dropdown Pilihan Modal Alokasi Kuota
        $daftar_rt = User::where('role', 'RT')
            ->orderBy('wilayah_rt_rw', 'asc')
            ->get(); 

        return view('admin.konfigurasi.index', compact('jenisBansos', 'periodes', 'jadwals', 'daftar_rt'));
    }

    /**
     * 2. PROSES SIMPAN ALOKASI KUOTA RT PER PERIODE
     * Mengisi data ke tabel jembatan kuota_rts secara presisi menggunakan kolom rt & rw
     */
    public function storeKuotaRT(Request $request)
    {
        // Proteksi Keamanan Akses
        if (!Auth::check() || Auth::user()->role !== 'Admin') { 
            abort(403, 'Akses Ditolak.'); 
        }

        // Validasi Input Form Modal
        $request->validate([
            'id_periode' => 'required|exists:periode_bansos,id',
            'id_bansos'  => 'required|exists:jenis_bansos,id',
            'id_user'    => 'required|exists:users,id_user', 
            'kuota'      => 'required|integer|min:1',
        ]);

        // 1. Ambil data user RT berdasarkan id_user yang dipilih dari form modal
        $userRt = User::where('id_user', $request->id_user)->first();

        if (!$userRt) {
            return redirect()->back()->withErrors(['error' => 'Data Ketua RT tidak ditemukan.']);
        }

        // 2. Pecah nilai wilayah_rt_rw (Contoh: "01/03" dipecah menjadi rt = "01" dan rw = "03")
        $wilayah = explode('/', $userRt->wilayah_rt_rw);
        $rtValue = $wilayah[0] ?? '';
        $rwValue = $wilayah[1] ?? '';

        // 3. Periksa jatah kuota berdasarkan kombinasi id_periode, id_bansos, rt, dan rw
        $cekKuota = DB::table('kuota_rts')
            ->where('id_periode', $request->id_periode)
            ->where('id_bansos', $request->id_bansos)
            ->where('rt', $rtValue)
            ->where('rw', $rwValue)
            ->first();

        // 4. Eksekusi penyimpanan (Update jika sudah ada, Insert jika data baru)
        if ($cekKuota) {
            // Jika data alokasi sudah ada, akumulasikan/tambahkan kuotanya
            DB::table('kuota_rts')
                ->where('id_periode', $request->id_periode)
                ->where('id_bansos', $request->id_bansos)
                ->where('rt', $rtValue)
                ->where('rw', $rwValue)
                ->update([
                    'kuota' => $cekKuota->kuota + $request->kuota,
                    'updated_at' => now()
                ]);
        } else {
            // Jika benar-benar baru, lakukan insert data baru sesuai kolom database asli
            DB::table('kuota_rts')->insert([
                'id_periode' => $request->id_periode,
                'id_bansos'  => $request->id_bansos,
                'rt'         => $rtValue,
                'rw'         => $rwValue,
                'kuota'      => $request->kuota,
                'terpakai'   => 0, // Nilai default pemakaian jatah kuota awal
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Kembali ke halaman Pusat Konfigurasi dengan Tab Periode tetap aktif membawa notifikasi sukses
        return redirect()->back()->with('success', 'Alokasi jatah kuota RT berhasil disimpan dan diintegrasikan!');
    }
}
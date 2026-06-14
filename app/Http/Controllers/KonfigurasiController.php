<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisBansos;
use App\Models\PeriodeBansos;
use App\Models\JadwalBansos;
use App\Models\KuotaWilayah; // PERBAIKAN: Gunakan KuotaWilayah, hapus KuotaRT
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class KonfigurasiController extends Controller
{
    /**
     * 1. HALAMAN UTAMA PUSAT KONFIGURASI (INDEX)
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

        // Data untuk TAB 3: Siklus Jadwal Tahapan
        $jadwals = JadwalBansos::with('periode')
            ->orderBy('id_periode', 'desc')
            ->orderBy('hari_mulai', 'asc')
            ->get();

        // Data Master RT untuk di-looping di Dropdown Pilihan Modal
        $daftar_rt = User::where('role', 'RT')
            ->orderBy('wilayah_rt_rw', 'asc')
            ->get(); 

        // PERBAIKAN: Ambil riwayat alokasi kuota yang sudah ada untuk ditampilkan di halaman index
        $kuotaWilayah = KuotaWilayah::with(['jenisBansos', 'periode'])
            ->orderBy('rw', 'asc')
            ->orderBy('rt', 'asc')
            ->get();

        return view('admin.konfigurasi.index', compact('jenisBansos', 'periodes', 'jadwals', 'daftar_rt', 'kuotaWilayah'));
    }

    /**
     * 2. PROSES SIMPAN ALOKASI KUOTA RT PER PERIODE
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

        // 1. Ambil data user RT berdasarkan id_user
        $userRt = User::where('id_user', $request->id_user)->first();

        if (!$userRt) {
            return redirect()->back()->withErrors(['error' => 'Data Ketua RT tidak ditemukan.']);
        }

        // 2. Pecah nilai wilayah_rt_rw (Contoh: "01/03" menjadi rt = "01" dan rw = "03")
        $wilayah = explode('/', $userRt->wilayah_rt_rw);
        $rtValue = $wilayah[0] ?? '';
        $rwValue = $wilayah[1] ?? '';

        // 3. Periksa jatah kuota menggunakan Eloquent Model KuotaWilayah
        $cekKuota = KuotaWilayah::where('id_periode', $request->id_periode)
            ->where('id_bansos', $request->id_bansos)
            ->where('rt', $rtValue)
            ->where('rw', $rwValue)
            ->first();

        // 4. Eksekusi penyimpanan (Update jika sudah ada, Create jika data baru)
        if ($cekKuota) {
            // Jika data alokasi sudah ada, akumulasikan kuota_maksimal-nya
            $cekKuota->update([
                'kuota_maksimal' => $cekKuota->kuota_maksimal + $request->kuota
            ]);
        } else {
            // Jika benar-benar baru, gunakan KuotaWilayah::create
            KuotaWilayah::create([
                'id_periode'     => $request->id_periode,
                'id_bansos'      => $request->id_bansos,
                'rt'             => $rtValue,
                'rw'             => $rwValue,
                'kuota_maksimal' => $request->kuota,
                'kuota_terpakai' => 0, // Nilai default awal pemakaian
            ]);
        }

        return redirect()->back()->with('success', 'Alokasi jatah kuota wilayah berhasil disimpan dan diintegrasikan!');
    }
}
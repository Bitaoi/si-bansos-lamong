<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\JenisBansos;
use App\Models\PeriodeBansos;
use App\Models\KuotaWilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // 1. Tampilkan Daftar Akun RT
    public function indexRT()
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }
        
        // Ambil data user yang jabatannya RT
        $rts = User::where('role', 'RT')->latest('id_user')->paginate(10);
        
        return view('admin.rt.index', compact('rts'));
    }

    // 2. Tampilkan Form Tambah RT
    public function createRT()
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }
        
        return view('admin.rt.create');
    }

    // 3. Simpan Data Akun RT Baru
    public function storeRT(Request $request)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'wilayah_rt_rw' => 'required|string|max:20|unique:users,wilayah_rt_rw', // Cegah RT ganda
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:6',
        ], [
            'wilayah_rt_rw.unique' => 'Wilayah RT/RW ini sudah memiliki akun!',
            'username.unique' => 'Username sudah dipakai, silakan cari yang lain.'
        ]);

        $userBaru = User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'wilayah_rt_rw' => $request->wilayah_rt_rw,
            'username' => $request->username,
            'password' => Hash::make($request->password), // Memastikan password di-hash dengan aman
            'role' => 'RT',
        ]);

        // =========================================================================
        // PERBAIKAN: RE-KALKULASI OTOMATIS KUOTA SETELAH PENAMBAHAN RT BARU
        // =========================================================================
        $this->rekalkulasiSemuaKuotaAktif();

        return redirect()->route('admin.rt.index')->with('success', 'Akun Ketua RT berhasil ditambahkan dan seluruh kuota telah di-rekalkulasi ulang!');
    }

    // 4. Edit Akun RT (BY RT)
    public function updateProfile(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $request->validate([
            'username' => 'required|unique:users,username,'.$user->id_user, // Penyesuaian ke id_user
            'password' => 'nullable|min:5|confirmed'
        ]);

        $user->username = $request->username;
        if($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        return back()->with('success', 'Profil dan kata sandi anda berhasil diperbarui!');
    }

    // 5. Hapus Akun RT
    public function destroyRT($id)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }
        
        $user = User::where('id_user', $id)->firstOrFail();
        $user->delete();

        // =========================================================================
        // PERBAIKAN: RE-KALKULASI OTOMATIS KUOTA SETELAH PENGHAPUSAN RT
        // =========================================================================
        // Karena RT berkurang, jatahnya harus dikembalikan dan dibagi ke RT yang tersisa
        $this->rekalkulasiSemuaKuotaAktif();
        
        return redirect()->route('admin.rt.index')->with('success', 'Akun Ketua RT dihapus dan kuota program aktif telah disesuaikan kembali!');
    }

    /**
     * ALGORITMA PEMBANTU: Menghitung ulang seluruh kuota bansos yang sedang berjalan
     */
    private function rekalkulasiSemuaKuotaAktif()
    {
        $periodeAktif = PeriodeBansos::where('status', 'Aktif')->first();
        if (!$periodeAktif) return; // Jika tidak ada periode aktif, tidak perlu membagi apa-apa

        // Ambil program bansos yang aktif di periode ini
        $bansosAktif = JenisBansos::where('status', 'Aktif')->where('id_periode', $periodeAktif->id)->get();
        if ($bansosAktif->isEmpty()) return;

        // Ambil daftar RT yang masih aktif di dalam sistem
        $usersRT = User::where('role', 'RT')->get();
        $jumlahRT = $usersRT->count();

        if ($jumlahRT === 0) {
            // Jika semua RT dihapus, kosongkan tabel distribusi untuk periode ini
            KuotaWilayah::where('id_periode', $periodeAktif->id)->delete();
            return;
        }

        // Loop dan bagikan ulang jatah secara adil untuk masing-masing program bansos
        foreach ($bansosAktif as $bansos) {
            $totalKuota = $bansos->kuota;
            
            // Hapus alokasi kuota lama khusus untuk bansos ini agar digenerate ulang bersih
            KuotaWilayah::where('id_bansos', $bansos->id)->where('id_periode', $periodeAktif->id)->delete();

            $kuotaDasar = (int) floor($totalKuota / $jumlahRT);
            $sisaKuota = $totalKuota % $jumlahRT;

            foreach ($usersRT as $index => $rt) {
                $wilayah = explode('/', $rt->wilayah_rt_rw);
                $rt_val = isset($wilayah[0]) ? str_pad(trim($wilayah[0]), 3, '0', STR_PAD_LEFT) : '000';
                $rw_val = isset($wilayah[1]) ? str_pad(trim($wilayah[1]), 3, '0', STR_PAD_LEFT) : '000';

                // Implementasi Adil: Selisih max 1
                $kuotaFinal = $kuotaDasar + ($index < $sisaKuota ? 1 : 0);

                KuotaWilayah::create([
                    'id_periode' => $periodeAktif->id,
                    'id_bansos'  => $bansos->id,
                    'rt'         => $rt_val,
                    'rw'         => $rw_val,
                    'kuota'      => $kuotaFinal,
                    'terpakai'   => 0 // Reset pemakaian (Opsional: Jika sistem ini dipakai di tengah jalan, terpakai bisa disesuaikan, tapi standarnya 0)
                ]);
            }
        }
    }
}
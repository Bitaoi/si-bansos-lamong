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

        User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'wilayah_rt_rw' => $request->wilayah_rt_rw,
            'username' => $request->username,
            'password' => $request->password, // Password otomatis di-hash karena cast 'hashed' di Model
            'role' => 'RT',
        ]);

        // PERBAIKAN: Menjalankan ulang distribusi kuota agar RT baru otomatis mendapatkan jatah
        $this->rekalkulasiSemuaKuotaAktif();

        return redirect()->route('admin.rt.index')->with('success', 'Akun Ketua RT berhasil ditambahkan! Kuota Bansos telah disesuaikan.');
    }

    // 4. Edit Akun RT (BY RT)
    public function updateProfile(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        $request->validate([
            'username' => 'required|unique:users,username,'.$user->id,
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
        
        User::where('id_user', $id)->delete();
        
        // PERBAIKAN: Menjalankan ulang distribusi kuota agar jatah RT yang dihapus dikembalikan & diratakan ke RT lain
        $this->rekalkulasiSemuaKuotaAktif();

        return redirect()->route('admin.rt.index')->with('success', 'Akun Ketua RT berhasil dihapus! Kuota Bansos telah disesuaikan.');
    }

    /**
     * FUNGSI HELPER: Rekalkulasi Kuota RT Otomatis
     * Memastikan tabel kuota terupdate secara transparan dengan mekanisme "UpdateOrCreate"
     * tanpa menghapus data "terpakai" milik RT yang sedang berjalan.
     */
    private function rekalkulasiSemuaKuotaAktif()
    {
        $periodeAktif = PeriodeBansos::where('status', 'Aktif')->first();
        if (!$periodeAktif) return;

        $bansosAktif = JenisBansos::where('status', 'Aktif')->where('id_periode', $periodeAktif->id)->get();
        if ($bansosAktif->isEmpty()) return;

        $usersRT = User::where('role', 'RT')->get();
        $jumlahRT = $usersRT->count();

        if ($jumlahRT === 0) {
            KuotaWilayah::where('id_periode', $periodeAktif->id)->delete();
            return;
        }

        // Kumpulkan Nomenklatur RT-RW yang Valid Saat Ini
        $validWilayahs = $usersRT->map(function ($rt) {
            $wilayah = explode('/', $rt->wilayah_rt_rw);
            $rt_val = isset($wilayah[0]) ? str_pad(trim($wilayah[0]), 3, '0', STR_PAD_LEFT) : '000';
            $rw_val = isset($wilayah[1]) ? str_pad(trim($wilayah[1]), 3, '0', STR_PAD_LEFT) : '000';
            return $rt_val . '-' . $rw_val;
        })->toArray();

        foreach ($bansosAktif as $bansos) {
            $totalKuota = $bansos->kuota;
            
            // 1. Bersihkan Data Yatim (Misal RT dihapus, kuota wilayahnya harus ikut hangus)
            $existingKuotas = KuotaWilayah::where('id_bansos', $bansos->id)
                                          ->where('id_periode', $periodeAktif->id)
                                          ->get();

            foreach($existingKuotas as $ek) {
                $key = $ek->rt . '-' . $ek->rw;
                if (!in_array($key, $validWilayahs)) {
                    $ek->delete(); 
                }
            }

            // 2. Bagi rata dengan sisa pembagian ke RT awal
            $kuotaDasar = (int) floor($totalKuota / $jumlahRT);
            $sisaKuota = $totalKuota % $jumlahRT;

            foreach ($usersRT as $index => $rt) {
                $wilayah = explode('/', $rt->wilayah_rt_rw);
                $rt_val = isset($wilayah[0]) ? str_pad(trim($wilayah[0]), 3, '0', STR_PAD_LEFT) : '000';
                $rw_val = isset($wilayah[1]) ? str_pad(trim($wilayah[1]), 3, '0', STR_PAD_LEFT) : '000';

                $kuotaFinal = $kuotaDasar + ($index < $sisaKuota ? 1 : 0);

                // UpdateOrCreate mengamankan field 'terpakai' milik RT lama agar tidak ter-reset 0
                KuotaWilayah::updateOrCreate(
                    [
                        'id_periode' => $periodeAktif->id,
                        'id_bansos'  => $bansos->id,
                        'rt'         => $rt_val,
                        'rw'         => $rw_val,
                    ],
                    [
                        'kuota'      => $kuotaFinal,
                    ]
                );
            }
        }
    }
}
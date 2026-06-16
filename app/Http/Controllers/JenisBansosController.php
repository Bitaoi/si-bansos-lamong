<?php

namespace App\Http\Controllers;

use App\Models\JenisBansos;
use App\Models\PeriodeBansos;
use App\Models\KuotaWilayah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JenisBansosController extends Controller
{
    // 1. TAMPILKAN DAFTAR BANSOS
    public function index()
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }
        
        $bansos = JenisBansos::all();
        
        return view('admin.jenis_bansos.index', compact('bansos'));
    }

    // 2. FORM TAMBAH
    public function create()
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }

        $periodes = PeriodeBansos::all(); 
        return view('admin.jenis_bansos.create', compact('periodes'));
    }

    // 3. SIMPAN DATA (CREATE)
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }

        // PERBAIKAN: Nama-nama ini sekarang sudah 100% SAMA dengan name="..." di HTML form
        $request->validate([
            'id_periode'        => 'required|exists:periode_bansos,id',
            'nama_bansos'       => 'required|string|max:100',
            'kode_bansos'       => 'required|string|max:50',
            'sumber_dana'       => 'required|string',
            'deskripsi_bantuan' => 'nullable|string',
            'bentuk_penyerahan' => 'required|string',
            'nominal'           => 'required|string',
            'frekuensi'         => 'required|string',
            'tahun_anggaran'    => 'required|numeric',
            'kriteria_lainnya'  => 'nullable|string',
            'kuota'             => 'required|numeric',
            'deskripsi_kuota'   => 'nullable|string',
            'status'            => 'required|in:Aktif,Nonaktif',
        ]);

        $data = [
            'id_periode'        => $request->id_periode,
            'nama_bansos'       => $request->nama_bansos,
            'kode_bansos'       => $request->kode_bansos,
            'sumber_dana'       => $request->sumber_dana,
            'deskripsi_bantuan' => $request->deskripsi_bantuan, 
            'bentuk_penyerahan' => $request->bentuk_penyerahan,
            'bentuk_bantuan'    => '-', 
            'nominal'           => $request->nominal,
            'frekuensi'         => $request->frekuensi, 
            'tahun_anggaran'    => $request->tahun_anggaran,
            'kuota'             => $request->kuota, 
            'deskripsi_kuota'   => $request->deskripsi_kuota, 
            'kriteria_penerima' => '-', 
            'kriteria_lainnya'  => $request->kriteria_lainnya, 
            'status'            => $request->status,
            'kriteria_desil'    => json_encode($request->kriteria_desil ?? []) 
        ];
        
        $jenisBansos = JenisBansos::create($data);

        $this->distributeKuotaRT($jenisBansos, $request->id_periode);

        return redirect()->route('jenis-bansos.index')->with('success', 'Program Bansos berhasil ditambahkan!');
    }

    // 4. FORM EDIT
    public function edit($id)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }
        
        $jenisBansos = JenisBansos::findOrFail($id);
        $periodes = PeriodeBansos::all();
        
        return view('admin.jenis_bansos.edit', compact('jenisBansos', 'periodes'));
    }

    // 5. UPDATE DATA 
    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }

        // PERBAIKAN: Disamakan dengan form HTML
        $request->validate([
            'id_periode'        => 'required|exists:periode_bansos,id',
            'nama_bansos'       => 'required|string|max:100',
            'kode_bansos'       => 'required|string|max:50',
            'sumber_dana'       => 'required|string',
            'deskripsi_bantuan' => 'nullable|string',
            'bentuk_penyerahan' => 'required|string',
            'nominal'           => 'required|string',
            'frekuensi'         => 'required|string',
            'tahun_anggaran'    => 'required|numeric',
            'kriteria_lainnya'  => 'nullable|string',
            'kuota'             => 'required|numeric',
            'deskripsi_kuota'   => 'nullable|string',
            'status'            => 'required|in:Aktif,Nonaktif',
        ]);

        $jenisBansos = JenisBansos::findOrFail($id);
        
        $data = [
            'id_periode'        => $request->id_periode,
            'nama_bansos'       => $request->nama_bansos,
            'kode_bansos'       => $request->kode_bansos,
            'sumber_dana'       => $request->sumber_dana,
            'deskripsi_bantuan' => $request->deskripsi_bantuan,
            'bentuk_penyerahan' => $request->bentuk_penyerahan,
            'nominal'           => $request->nominal,
            'frekuensi'         => $request->frekuensi,
            'tahun_anggaran'    => $request->tahun_anggaran,
            'kuota'             => $request->kuota,
            'deskripsi_kuota'   => $request->deskripsi_kuota,
            'kriteria_lainnya'  => $request->kriteria_lainnya,
            'status'            => $request->status,
            'kriteria_desil'    => json_encode($request->kriteria_desil ?? [])
        ];
        
        $jenisBansos->update($data);

        $this->distributeKuotaRT($jenisBansos, $request->id_periode);

        return redirect()->route('jenis-bansos.index')->with('success', 'Data Program Bansos berhasil diperbarui!');
    }

    // 6. HAPUS DATA
    public function destroy($id)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }
        
        $bansos = JenisBansos::findOrFail($id);
        $bansos->delete();

        return redirect()->route('jenis-bansos.index')->with('success', 'Data Program Bansos berhasil dihapus!');
    }

    private function distributeKuotaRT($jenisBansos, $idPeriode)
    {
        $usersRT = User::where('role', 'RT')->get();
        $jumlahRT = $usersRT->count();
        $totalKuota = $jenisBansos->kuota;

        if ($jumlahRT > 0 && $totalKuota > 0) {
            
            $kuotaDasar = (int) floor($totalKuota / $jumlahRT);
            $sisaKuota = $totalKuota % $jumlahRT;

            foreach ($usersRT as $index => $rt) {
                $wilayah = explode('/', $rt->wilayah_rt_rw);
                $rt_val = isset($wilayah[0]) ? str_pad(trim($wilayah[0]), 3, '0', STR_PAD_LEFT) : '000';
                $rw_val = isset($wilayah[1]) ? str_pad(trim($wilayah[1]), 3, '0', STR_PAD_LEFT) : '000';

                $kuotaFinal = $kuotaDasar + ($index < $sisaKuota ? 1 : 0);

                KuotaWilayah::updateOrCreate(
                    [
                        'id_periode' => $idPeriode,
                        'id_bansos'  => $jenisBansos->id,
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
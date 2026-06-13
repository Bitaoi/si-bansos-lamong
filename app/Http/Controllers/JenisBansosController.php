<?php

namespace App\Http\Controllers;

use App\Models\JenisBansos;
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
        return view('admin.jenis_bansos.create');
    }

    // 3. SIMPAN DATA (CREATE)
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }

        // Validasi input
        $request->validate([
            'nama_bansos'          => 'required|string|max:100',
            'kode_bansos'          => 'required|string|max:50',
            'sumber_dana'          => 'required|string',
            'deskripsi_singkat'    => 'nullable|string',
            'bentuk_penyerahan'    => 'required|string',
            'nominal'              => 'required|string',
            'frekuensi_penyaluran' => 'required|string',
            'tahun_anggaran'       => 'required|numeric',
            'kriteria_tambahan'    => 'nullable|string',
            'kuota_penerima'       => 'required|numeric',
            'sasaran_kuota'        => 'nullable|string',
            'status'               => 'required|in:Aktif,Nonaktif',
        ]);

        // MAPPING: Sesuaikan dengan migrasi 'create_jenis_bansos_table'
        $data = [
            'nama_bansos'       => $request->nama_bansos,
            'kode_bansos'       => $request->kode_bansos,
            'sumber_dana'       => $request->sumber_dana,
            'deskripsi_bantuan' => $request->deskripsi_singkat, 
            'bentuk_penyerahan' => $request->bentuk_penyerahan,
            'bentuk_bantuan'    => '-', 
            'nominal'           => $request->nominal,
            'frekuensi'         => $request->frekuensi_penyaluran, 
            'tahun_anggaran'    => $request->tahun_anggaran,
            'kuota'             => $request->kuota_penerima, 
            'deskripsi_kuota'   => $request->sasaran_kuota, 
            'kriteria_penerima' => '-', 
            'kriteria_lainnya'  => $request->kriteria_tambahan, 
            'status'            => $request->status,
            'kriteria_desil'    => json_encode($request->kriteria_desil ?? []) // Pastikan di-encode jadi JSON
        ];
        
        JenisBansos::create($data);

        return redirect()->route('jenis-bansos.index')->with('success', 'Program Bansos berhasil ditambahkan!');
    }

    // 4. FORM EDIT
    public function edit($id)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }
        
        $jenisBansos = JenisBansos::findOrFail($id);
        
        return view('admin.jenis_bansos.edit', compact('jenisBansos'));
    }

    // 5. UPDATE DATA 
    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }

        $request->validate([
            'nama_bansos'          => 'required|string|max:100',
            'kode_bansos'          => 'required|string|max:50',
            'sumber_dana'          => 'required|string',
            'deskripsi_singkat'    => 'nullable|string',
            'bentuk_penyerahan'    => 'required|string',
            'nominal'              => 'required|string',
            'frekuensi_penyaluran' => 'required|string',
            'tahun_anggaran'       => 'required|numeric',
            'kriteria_tambahan'    => 'nullable|string',
            'kuota_penerima'       => 'required|numeric',
            'sasaran_kuota'        => 'nullable|string',
            'status'               => 'required|in:Aktif,Nonaktif',
        ]);

        $jenisBansos = JenisBansos::findOrFail($id);
        
        $data = [
            'nama_bansos'       => $request->nama_bansos,
            'kode_bansos'       => $request->kode_bansos,
            'sumber_dana'       => $request->sumber_dana,
            'deskripsi_bantuan' => $request->deskripsi_singkat,
            'bentuk_penyerahan' => $request->bentuk_penyerahan,
            'nominal'           => $request->nominal,
            'frekuensi'         => $request->frekuensi_penyaluran,
            'tahun_anggaran'    => $request->tahun_anggaran,
            'kuota'             => $request->kuota_penerima,
            'deskripsi_kuota'   => $request->sasaran_kuota,
            'kriteria_lainnya'  => $request->kriteria_tambahan,
            'status'            => $request->status,
            'kriteria_desil'    => json_encode($request->kriteria_desil ?? [])
        ];
        
        $jenisBansos->update($data);

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
}
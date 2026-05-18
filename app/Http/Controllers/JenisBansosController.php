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

    // 3. SIMPAN DATA 
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }

        $request->validate([
            'nama_bansos'       => 'required|string|max:100',
            'kode_bansos'       => 'required|string|max:50',
            'sumber_dana'       => 'required|string',
            'bentuk_penyerahan' => 'required|string',
            'nominal'           => 'required|string',
            'frekuensi'         => 'required|string',
            'tahun_anggaran'    => 'required|numeric',
            'kuota'             => 'required|numeric', // PERBAIKAN: Menambahkan validasi kuota saat tambah data
        ], [
            'kuota.required' => 'field kuota harus diisi.' // PESAN KUSTOM
        ]);

        $data = $request->all();
        
        $data['kriteria_desil'] = $request->kriteria_desil ?? [];
        $data['kriteria_penerima'] = '-'; 
        $data['bentuk_bantuan'] = '-'; 

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
            'nama_bansos'       => 'required|string|max:100',
            'kode_bansos'       => 'required|string|max:50',
            'sumber_dana'       => 'required|string',
            'bentuk_penyerahan' => 'required|string',
            'nominal'           => 'required|string',
            'frekuensi'         => 'required|string',
            'tahun_anggaran'    => 'required|numeric',
            'deskripsi_bantuan' => 'nullable|string',
            'kriteria_lainnya'  => 'nullable|string',
            'deskripsi_kuota'   => 'nullable|string',
            'kuota'             => 'required|numeric', // PERBAIKAN: Ubah nullable menjadi required
        ], [
            'kuota.required' => 'field kuota harus diisi.' // PESAN KUSTOM
        ]);

        $jenisBansos = JenisBansos::findOrFail($id);
        
        $data = $request->all();
        
        $data['kriteria_desil'] = $request->kriteria_desil ?? [];
        $data['kriteria_penerima'] = '-';
        $data['bentuk_bantuan'] = '-';

        $jenisBansos->update($data);

        return redirect()->route('jenis-bansos.index')->with('success', 'Data program Bansos berhasil diperbarui!');
    }

    // 6. HAPUS DATA
    public function destroy($id)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }

        $bansos = JenisBansos::findOrFail($id);
        $bansos->delete();

        return redirect()->route('jenis-bansos.index')->with('success', 'Data program Bansos berhasil dihapus!');
    }
}
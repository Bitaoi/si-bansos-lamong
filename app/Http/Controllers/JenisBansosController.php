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

        // Validasi disesuaikan dengan name="" di form create.blade.php yang baru
        $request->validate([
            'nama_bansos'       => 'required|string|max:100',
            'kode_bansos'       => 'required|string|max:50',
            'sumber_dana'       => 'required|string',
            'bentuk_penyerahan' => 'required|string',
            'nominal'           => 'required|string',
            'frekuensi'         => 'required|string',
            'tahun_anggaran'    => 'required|numeric',
            // Field deskripsi_bantuan, kuota, kriteria_lainnya boleh kosong (nullable)
        ]);

        $data = $request->all();
        
        // Handle checkbox Desil (Karena checkbox tidak mengirim data jika tidak dicentang)
        $data['kriteria_desil'] = $request->kriteria_desil ?? [];

        // Simpan
        JenisBansos::create($data);

        return redirect()->route('jenis-bansos.index')->with('success', 'Program Bansos berhasil ditambahkan!');
    }

    // 4. FORM EDIT
    public function edit($id)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }
        
        // Variabel diubah menjadi $jenisBansos agar sinkron dengan edit.blade.php
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
        ]);

        $jenisBansos = JenisBansos::findOrFail($id);
        
        $data = $request->all();
        
        // Handle checkbox Desil update
        $data['kriteria_desil'] = $request->kriteria_desil ?? [];

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
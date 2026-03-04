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

    // 3. SIMPAN DATA (PERBAIKAN UTAMA DISINI)
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }

        // Validasi sesuai name="" di form create.blade.php
        $request->validate([
            'nama_bansos'       => 'required|string|max:100',
            'sumber_dana'       => 'required|string',
            'bentuk_bantuan'    => 'required|string',
            'nominal'           => 'required|string',
            'frekuensi'         => 'required|string',
            'kriteria_penerima' => 'required|string', // Jangan pakai 'kriteria' lagi
            'tahun_anggaran'    => 'required|numeric',
            'status'            => 'required|in:Aktif,Non-Aktif',
            // Field lain boleh nullable, jadi tidak wajib divalidasi 'required'
        ]);

        // Cek Checkbox Syarat DTKS (Karena checkbox kalau tidak dicentang tidak mengirim data)
        $data = $request->all();
        $data['syarat_dtks'] = $request->has('syarat_dtks') ? 1 : 0;

        // Simpan
        JenisBansos::create($data);

        return redirect()->route('jenis-bansos.index')->with('success', 'Jenis Bansos berhasil ditambahkan!');
    }

    // 4. FORM EDIT
    public function edit($id)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }
        
        $bansos = JenisBansos::findOrFail($id);
        return view('admin.jenis_bansos.edit', compact('bansos'));
    }

    // 5. UPDATE DATA (PERBAIKAN JUGA DISINI)
    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }

        $request->validate([
            'nama_bansos'       => 'required|string|max:100',
            'sumber_dana'       => 'required|string',
            'bentuk_bantuan'    => 'required|string',
            'nominal'           => 'required|string',
            'frekuensi'         => 'required|string',
            'kriteria_penerima' => 'required|string',
            'tahun_anggaran'    => 'required|numeric',
            'status'            => 'required|in:Aktif,Non-Aktif',
        ]);

        $bansos = JenisBansos::findOrFail($id);
        
        // Handle checkbox update
        $data = $request->all();
        $data['syarat_dtks'] = $request->has('syarat_dtks') ? 1 : 0;

        $bansos->update($data);

        return redirect()->route('jenis-bansos.index')->with('success', 'Data berhasil diperbarui!');
    }

    // 6. HAPUS DATA
    public function destroy($id)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }

        $bansos = JenisBansos::findOrFail($id);
        $bansos->delete();

        return redirect()->route('jenis-bansos.index')->with('success', 'Data berhasil dihapus!');
    }
}
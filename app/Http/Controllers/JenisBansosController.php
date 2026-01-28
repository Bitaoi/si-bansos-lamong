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
            'nama_bansos' => 'required|string|max:100',
            'kriteria' => 'required|string',
        ]);

        JenisBansos::create($request->all());

        return redirect()->route('jenis-bansos.index')->with('success', 'Jenis Bansos berhasil ditambahkan!');
    }

    // 4. FORM EDIT
    public function edit($id)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }
        
        $bansos = JenisBansos::findOrFail($id);
        return view('admin.jenis_bansos.edit', compact('bansos'));
    }

    // 5. UPDATE DATA
    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }

        $request->validate([
            'nama_bansos' => 'required|string|max:100',
            'kriteria' => 'required|string',
        ]);

        $bansos = JenisBansos::findOrFail($id);
        $bansos->update($request->all());

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
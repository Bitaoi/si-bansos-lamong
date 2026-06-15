<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PeriodeBansos;
use App\Models\KuotaWilayah;
use Illuminate\Support\Facades\Auth;

class PeriodeBansosController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }

        $periodes = PeriodeBansos::orderBy('created_at', 'desc')->get();

        $kuotaWilayahs = KuotaWilayah::with('jenisBansos')->get();
        
        return view('admin.periode.index', compact('periodes', 'kuotaWilayahs'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }

        $request->validate([
            'nama_periode' => 'required|string|max:255', // Contoh: "Tahap 1 - Januari 2026"
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        PeriodeBansos::create([
            'nama_periode' => $request->nama_periode,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_akhir' => $request->tanggal_akhir,
            'status' => 'Aktif'
        ]);

        return back()->with('success', 'Periode Bantuan baru berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }

        $request->validate([
            'nama_periode' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:Aktif,Tutup'
        ]);

        $periode = PeriodeBansos::findOrFail($id);
        $periode->update($request->all());

        return back()->with('success', 'Data Periode Bantuan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }

        $periode = PeriodeBansos::findOrFail($id);
        $periode->delete();

        return back()->with('success', 'Periode Bantuan berhasil dihapus.');
    }
}
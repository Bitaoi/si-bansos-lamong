<?php

namespace App\Http\Controllers;

use App\Models\JadwalBansos;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    // UNTUK WARGA (PUBLIC TIMELINE)
    public function timelinePublik()
    {
        $jadwal = JadwalBansos::orderBy('hari_mulai', 'asc')->get();
        $hariIni = (int) date('j'); // Mengambil tanggal hari ini (1-31)
        
        return view('timeline', compact('jadwal', 'hariIni'));
    }

    // UNTUK ADMIN (PENGATURAN)
    public function indexAdmin()
    {
        $jadwal = JadwalBansos::orderBy('hari_mulai', 'asc')->get();
        return view('admin.jadwal.index', compact('jadwal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_tahapan' => 'required|string',
            'hari_mulai' => 'required|integer|min:1|max:31',
            'hari_selesai' => 'required|integer|min:1|max:31',
            'warna_bg' => 'required|string',
        ]);

        JadwalBansos::create([
            'nama_tahapan' => $request->nama_tahapan,
            'hari_mulai' => $request->hari_mulai,
            'hari_selesai' => $request->hari_selesai,
            'warna_bg' => $request->warna_bg,
            'deskripsi' => $request->deskripsi ?? '',
        ]);

        return back()->with('success', 'Jadwal tahapan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $jadwal = JadwalBansos::findOrFail($id);
        $jadwal->update([
            'hari_mulai' => $request->hari_mulai,
            'hari_selesai' => $request->hari_selesai,
        ]);
        return back()->with('success', 'Jadwal berhasil diperbarui!');
    }
}
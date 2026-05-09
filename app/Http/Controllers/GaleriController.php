<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }
        $galeris = Galeri::latest()->get();
        return view('admin.galeri.index', compact('galeris'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }

        $request->validate([
            'judul' => 'required|string|max:255',
            'foto'  => 'required|image|mimes:jpeg,png,jpg|max:2048' // Maksimal 2MB
        ]);

        // Simpan foto ke folder storage/app/public/galeri
        $fotoPath = $request->file('foto')->store('galeri', 'public');

        Galeri::create([
            'judul' => $request->judul,
            'foto'  => $fotoPath
        ]);

        return redirect()->back()->with('success', 'Foto Galeri Desa berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }
        
        $galeri = Galeri::findOrFail($id);
        
        // Hapus file fisik fotonya dari storage jika ada
        if(Storage::disk('public')->exists($galeri->foto)) {
            Storage::disk('public')->delete($galeri->foto);
        }
        
        // Hapus data dari database
        $galeri->delete();

        return redirect()->back()->with('success', 'Foto Galeri Desa berhasil dihapus!');
    }
}
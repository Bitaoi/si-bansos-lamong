<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return redirect()->route('admin.rt.index')->with('success', 'Akun Ketua RT berhasil ditambahkan!');
    }

    // 4. Hapus Akun RT
    public function destroyRT($id)
    {
        if (Auth::user()->role !== 'Admin') { abort(403); }
        
        User::where('id_user', $id)->delete();
        
        return redirect()->route('admin.rt.index')->with('success', 'Akun Ketua RT berhasil dihapus!');
    }
}
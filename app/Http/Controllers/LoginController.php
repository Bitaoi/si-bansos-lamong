<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // 1. Menampilkan Halaman Login
    public function index()
    {
        return view('auth.login');
    }

    // 2. Proses Login (Verifikasi)
    public function authenticate(Request $request)
    {
        // Validasi input form
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        // Coba login menggunakan Auth Laravel
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Cek Role user untuk mengarahkan ke Dashboard yang benar
            $user = Auth::user();

            if ($user->role === 'Admin') {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->role === 'RT') {
                return redirect()->intended('/rt/dashboard');
            }

            // Jika role tidak dikenali
            return redirect()->intended('/');
        }

        // Jika login gagal (Skenario Gagal Gambar 3.3)
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    // 3. Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
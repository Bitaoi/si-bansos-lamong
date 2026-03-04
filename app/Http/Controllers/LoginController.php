<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Hapus function index() karena kita pakai Modal di Home

    // 1. PROSES LOGIN
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $role = Auth::user()->role;

            // Arahkan sesuai Role
            if ($role === 'Admin') {
                return redirect()->intended('/admin/dashboard');
            } elseif ($role === 'RT') {
                return redirect()->intended('/rt/dashboard');
            }

            // Jika role aneh, tendang keluar
            Auth::logout();
            return back()->withErrors(['login_error' => 'Akses ditolak. Peran tidak dikenali.']);
        }

        // JIKA GAGAL: Kembali ke Home dengan Error khusus 'login_error'
        return back()->withErrors([
            'login_error' => 'Username atau Password salah!',
        ])->onlyInput('username');
    }

    // 2. PROSES LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // Kembali ke Halaman Depan
    }
}
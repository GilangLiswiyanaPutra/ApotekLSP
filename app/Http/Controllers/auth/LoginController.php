<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /** Menampilkan halaman form login */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /** Menangani proses login */
    public function login(Request $request)
    {
        // 1. Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Coba lakukan login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // 3. [PENTING] Arahkan berdasarkan role
            if ($user->role === 'pelanggan') {
                // Jika role adalah 'pelanggan', arahkan ke dashboard
                return redirect()->intended('/dashboard_pelanggan');
            }

            // Untuk role lainnya (admin, apoteker), arahkan ke halaman lain
            // Misalnya, kita arahkan ke halaman manajemen obat
            return redirect()->intended('/obats');
        }

        // 4. Jika login gagal
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /** Menangani proses logout */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
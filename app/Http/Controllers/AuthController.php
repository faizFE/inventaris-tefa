<?php

namespace App\Http\Controllers; // lokasi/folder controller ini berada

// "use" = import class dari luar supaya bisa dipakai di sini
use Illuminate\Http\Request;            // untuk menangkap data dari form (input user)
use Illuminate\Support\Facades\Auth;   // untuk proses login, logout, cek user

class AuthController extends Controller
{
    // METHOD 1: menampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
        // artinya: tampilkan file resources/views/auth/login.blade.php
    }

    // METHOD 2: memproses form login yang dikirim user
    public function login(Request $request)
    {
        // VALIDASI: cek dulu inputan sebelum diproses
        $request->validate([
            'email'    => 'required|email', // wajib diisi & harus format email
            'password' => 'required',       // wajib diisi
        ]);
        // kalau validasi gagal → otomatis balik ke halaman login + tampil pesan error

        // AUTH ATTEMPT: coba login dengan email & password yang diinput
        if (Auth::attempt($request->only('email', 'password'))) {
            // $request->only('email', 'password') = ambil HANYA email & password dari form
            // Auth::attempt() = cocokkan dengan data di database
            // kalau cocok → return true, kalau tidak → return false

            $request->session()->regenerate();
            // regenerate session ID untuk keamanan
            // mencegah "session fixation attack"

            return redirect()->route('dashboard');
            // login berhasil → redirect ke halaman dashboard
        }

        // sampai sini berarti login GAGAL (email/password salah)
        return back()->withErrors([
            'email' => 'Email atau password salah.',
            // pesan error ini bisa ditampilkan di view dengan $errors->first('email')
        ]);
        // back() = kembali ke halaman sebelumnya (halaman login)
    }

    // METHOD 3: proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        // hapus data autentikasi user yang sedang login

        $request->session()->invalidate();
        // hapus semua data session yang tersimpan

        $request->session()->regenerateToken();
        // buat CSRF token baru untuk keamanan setelah logout

        return redirect()->route('login');
        // setelah logout → redirect ke halaman login
    }
}
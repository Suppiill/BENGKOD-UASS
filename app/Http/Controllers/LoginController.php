<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse; // Tambahkan ini untuk type-hinting

class LoginController extends Controller
{
    /**
     * Menampilkan halaman form login.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        // Mengarahkan ke view yang berisi form login.
        // Pastikan file ini ada di: resources/views/auth/login.blade.php
        return view('auth.login');
    }

    /**
     * Menangani permintaan autentikasi (proses login).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate(Request $request): RedirectResponse
    {
        // 1. Validasi input yang masuk dari form (email dan password wajib diisi).
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // 2. Mencoba untuk melakukan autentikasi pengguna.
        // Auth::attempt akan otomatis melakukan hashing pada password input
        // dan membandingkannya dengan hash di database.
        if (Auth::attempt($credentials)) {
            // Jika berhasil, perbarui session untuk keamanan.
            $request->session()->regenerate();

            // 3. Dapatkan data pengguna yang sedang login.
            $user = Auth::user();

            // 4. Arahkan pengguna berdasarkan peran (role) mereka.
            // Menggunakan switch lebih rapi untuk banyak peran.
            switch ($user->role) {
                case 'admin':
                    // Jika peran adalah 'admin', arahkan ke dashboard admin.
                    return redirect()->route('admin.dashboard');

                case 'dokter':
                    // Jika peran adalah 'dokter', arahkan ke dashboard dokter.
                    return redirect()->route('dokter');

                case 'pasien':
                    // Jika peran adalah 'pasien', arahkan ke dashboard pasien.
                    return redirect()->route('pasien.dashboard');

                default:
                    // Jika peran tidak dikenali, arahkan ke halaman home sebagai fallback.
                    return redirect('/home');
            }
        }

        // 5. Jika autentikasi gagal (email atau password salah).
        // Kembalikan ke halaman login dengan pesan error.
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Menangani proses logout pengguna.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        // Logout pengguna saat ini.
        Auth::logout();

        // Jadikan session tidak valid.
        $request->session()->invalidate();

        // Buat ulang token CSRF.
        $request->session()->regenerateToken();

        // Arahkan kembali ke halaman login.
        return redirect('/login');
    }
}

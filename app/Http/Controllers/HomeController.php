<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\JadwalOperasi;
use App\Models\Notifikasi;
use App\Models\User;
use App\Models\Obat; // <-- 1. TAMBAHKAN MODEL OBAT DI SINI

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Menampilkan dashboard untuk dokter.
     */
    public function dokter()
    {
        $dokterId = Auth::id(); // Simpan ID dokter agar lebih rapi

        // Data untuk kartu Jadwal Operasi
        $jumlahJadwal = JadwalOperasi::where('dokter_id', $dokterId)
                                      ->where('status', 'Terjadwal')
                                      ->count();
        
        // Menghitung semua user yang memiliki peran 'pasien'
        $jumlahPasien = User::where('role', 'pasien')->count();
        
        // Menghitung semua data dari tabel obat
        $jumlahObat = Obat::count(); 

        // Data untuk kartu Notifikasi
        $jumlahNotifikasi = Notifikasi::where('user_id', $dokterId)
                                      ->where('is_read', false)
                                      ->count();

        // Mengirim semua variabel ke view
        return view('dokter.index', compact(
            'jumlahJadwal',
            'jumlahPasien',
            'jumlahObat',
            'jumlahNotifikasi'
        ));
    }
    public function profil()
    {
        $dokter = Auth::user();
        // Pastikan path ini sesuai
        return view('dokter.profil.index', compact('dokter'));
    }
    public function updateProfil(Request $request)
    {
        // 1. Ambil user (dokter) yang sedang login
        $dokter = Auth::user();

        // 2. Validasi semua input dari form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                // Pastikan email unik, kecuali untuk email dokter ini sendiri
                Rule::unique('users')->ignore($dokter->id),
            ],
            // Pastikan Anda punya kolom 'spesialis' di tabel 'users'
            'spesialis' => 'required|string|max:100',
            // Password boleh kosong (nullable), tapi jika diisi, harus minimal 8 karakter
            // dan cocok dengan field konfirmasi (password_confirmation)
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // 3. Update data dokter dengan data baru dari request
        $dokter->name = $request->name;
        $dokter->email = $request->email;
        $dokter->spesialis = $request->spesialis;

        // 4. Cek apakah user mengisi password baru
        if ($request->filled('password')) {
            // Jika diisi, hash password baru sebelum disimpan
            $dokter->password = Hash::make($request->password);
        }

        // 5. Simpan semua perubahan ke database
        $dokter->save();

        // 6. Redirect kembali ke halaman profil dengan pesan sukses
        return redirect()->route('dokter.profil')->with('success', 'Profil Anda berhasil diperbarui!');
    }
}
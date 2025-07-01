<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\JadwalOperasi;
use App\Models\Notifikasi;
use App\Models\Obat;

class HomeController extends Controller
{
    /**
     * Membuat instance controller baru.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Menampilkan dashboard aplikasi.
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
        $dokterId = Auth::id();
        $jumlahJadwal = JadwalOperasi::where('dokter_id', $dokterId)->where('status', 'Terjadwal')->count();
        $jumlahPasien = User::where('role', 'pasien')->count();
        $jumlahObat = Obat::count();
        $jumlahNotifikasi = Notifikasi::where('user_id', $dokterId)->where('is_read', false)->count();

        return view('dokter.index', compact(
            'jumlahJadwal',
            'jumlahPasien',
            'jumlahObat',
            'jumlahNotifikasi'
        ));
    }

    /**
     * Menampilkan halaman profil dokter.
     * Memanggil view 'dokter.profil' (asumsi file adalah resources/views/dokter/profil.blade.php)
     * Atau 'dokter.profil.index' jika file adalah resources/views/dokter/profil/index.blade.php
     */
    public function profil()
    {
        // Sesuaikan baris ini berdasarkan lokasi file profil.blade.php Anda
        // Jika Anda mengikuti Opsi 1 (direkomendasikan): return view('dokter.profil');
        // Jika Anda mengikuti Opsi 2: return view('dokter.profil.index');
        return view('dokter.profil.index'); // Menggunakan opsi 1 sebagai default
    }

    /**
     * Memperbarui profil dokter. (Disesuaikan dengan nama kolom 'alamat' dan 'no_hp')
     */
    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        // Validasi disesuaikan dengan form baru dan nama kolom yang benar
        $request->validate([
            'name' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255', // Menggunakan 'alamat'
            'no_hp' => 'nullable|string|max:20',    // Menggunakan 'no_hp'
        ]);

        // Update informasi dasar dengan nama kolom yang benar
        $user->name = $request->name;
        $user->alamat = $request->alamat; // Menyimpan alamat
        $user->no_hp = $request->no_hp;   // Menyimpan nomor telepon

        // Simpan perubahan ke database
        $user->save();

        // Redirect kembali ke halaman profil dengan pesan sukses
        return redirect()->route('dokter.profil')->with('success', 'Profil berhasil diperbarui!');
    }
}

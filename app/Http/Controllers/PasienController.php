<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Periksa;
use App\Models\Resep;
use App\Models\JadwalOperasi;

class PasienController extends Controller
{
    /**
     * Menampilkan dashboard utama untuk pasien.
     */
    public function dashboard()
    {
        $pasienId = Auth::id();

        // Hitung jumlah total riwayat pemeriksaan
        $jumlahRiwayat = Periksa::where('pasien_id', $pasienId)->count();

        // Hitung jumlah resep yang pernah diterima
        $jumlahResep = 0; // Ganti dengan: Resep::where('pasien_id', $pasienId)->count();

        // Hitung jadwal yang akan datang
        $jumlahJadwal = JadwalOperasi::where('pasien_id', $pasienId)
                                      ->where('waktu_operasi', '>=', now())
                                      ->count();
        
        // Hitung pesan/notifikasi yang belum dibaca
        $jumlahPesan = 1; // Ganti dengan query ke model Notifikasi

        return view('pasien.dashboard', compact(
            'jumlahRiwayat', 
            'jumlahResep', 
            'jumlahJadwal', 
            'jumlahPesan'
        ));
    }

    /**
     * Menampilkan halaman riwayat pemeriksaan pasien.
     */
    public function riwayatPemeriksaan()
    {
        $riwayatPemeriksaan = Periksa::where('pasien_id', Auth::id())
                                ->with('dokter') 
                                ->latest()
                                ->get();
    
        return view('pasien.periksa.index', compact('riwayatPemeriksaan'));
    }

    /**
     * Menampilkan halaman resep obat pasien.
     */
    public function resepObat()
    {
        $resepObat = []; // Ganti dengan query: Resep::where('pasien_id', Auth::id())->with('obat')->latest()->get();

        return view('pasien.obat.index', compact('resepObat'));
    }

    public function profilMedis()
    {
        $pasien = Auth::user();

        // Ambil 5 riwayat pemeriksaan terakhir
        $riwayatPemeriksaan = Periksa::where('pasien_id', $pasien->id)
                                    ->with('dokter')
                                    ->latest('tanggal_periksa')
                                    ->take(5)->get();

        // Ambil semua jadwal yang akan datang
        $jadwalOperasi = JadwalOperasi::where('pasien_id', $pasien->id)
                                        ->where('waktu_operasi', '>=', now())
                                        ->orderBy('waktu_operasi')->get();

        // Kirim semua data yang sudah dikumpulkan ke view
        return view('pasien.profil.medis', compact(
            'pasien', 
            'riwayatPemeriksaan', 
            'jadwalOperasi'
        ));
    }
}
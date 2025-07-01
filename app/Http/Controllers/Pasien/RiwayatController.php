<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Periksa; // PENTING: Gunakan Model Periksa agar konsisten
use Illuminate\Support\Facades\Auth;

class RiwayatController extends Controller
{
    /**
     * Menampilkan daftar semua riwayat pemeriksaan pasien.
     */
    public function index()
    {
        // Mengambil data dari tabel 'periksa' untuk pasien yang login
        $riwayatPemeriksaan = Periksa::where('pasien_id', Auth::id())
                                      ->with('dokter', 'jadwal.poli')
                                      ->latest()
                                      ->get();
        
        // Mengirim data ke view 'pasien.riwayat.index'
        return view('pasien.riwayat.index', compact('riwayatPemeriksaan'));
    }

    /**
     * Menampilkan detail satu riwayat pemeriksaan.
     * FUNGSI INI AKAN MEMPERBAIKI ERROR 403 FORBIDDEN ANDA.
     */
    public function show(Periksa $periksa)
    {
        // --- INI ADALAH PENGECEKAN KEAMANAN PENTING ---
        // Memastikan riwayat yang akan dilihat adalah milik pasien yang sedang login.
        if ($periksa->pasien_id !== Auth::id()) {
            // Jika bukan, tolak akses dengan pesan 403 Forbidden.
            abort(403, 'AKSES DITOLAK. ANDA TIDAK BERHAK MELIHAT RIWAYAT INI.');
        }

        // Jika akses diizinkan, muat relasi yang diperlukan untuk halaman detail
        $periksa->load('pasien', 'dokter', 'jadwal.poli', 'detail.obat');
        
        // Mengirim data ke view 'pasien.riwayat.show'
        return view('pasien.riwayat.show', compact('periksa'));
    }
}

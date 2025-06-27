<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JanjiTemu; // Jangan lupa import Model
use Illuminate\Support\Facades\Auth; // Jangan lupa import Auth

class RiwayatController extends Controller
{
    public function index()
    {
        // Ambil semua janji temu milik pasien yang sedang login
        // Diurutkan dari yang terbaru
        $riwayatJanjiTemu = JanjiTemu::where('pasien_id', Auth::id())
                                 ->with('dokter') // 'with()' bagus untuk performa, memuat data dokter sekaligus
                                 ->orderBy('created_at', 'desc') // Urutkan agar yang baru dibuat ada di paling atas
                                 ->get();
        // Kirim data ke view milik pasien
        return view('pasien.riwayat.index', compact('riwayatJanjiTemu'));
    }

    public function show(JanjiTemu $janjiTemu)
    {
        // Keamanan: pastikan pasien hanya bisa melihat riwayatnya sendiri
        if ($janjiTemu->pasien_id != Auth::id()) {
            abort(403);
        }

        // Kita tidak perlu query lagi, karena data sudah dimuat dari route model binding
        // Untuk memastikan relasi termuat, kita bisa load di sini
        $janjiTemu->load(['dokter', 'periksa.detailPeriksa.obat']);

        return view('pasien.riwayat.show', compact('janjiTemu'));
    }
}
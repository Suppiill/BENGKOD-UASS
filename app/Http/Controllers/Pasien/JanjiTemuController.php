<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Poli;
use App\Models\JadwalPeriksa;
use App\Models\Periksa;
use Illuminate\Support\Facades\Auth;

class JanjiTemuController extends Controller
{
    /**
     * Menampilkan halaman pendaftaran poli beserta riwayatnya.
     */
    public function halamanDaftarPoli()
    {
        $pasien = Auth::user(); 
        $daftar_poli = Poli::all();
        
        // Mengambil riwayat dari tabel periksas, bukan janji_temus
        $riwayat_daftar = Periksa::with(['dokter', 'jadwal.poli'])
                                  ->where('pasien_id', $pasien->id)
                                  ->latest() // Mengurutkan berdasarkan 'created_at' dari yang terbaru
                                  ->get();

        return view('pasien.poli_daftar', compact('pasien', 'daftar_poli', 'riwayat_daftar'));
    }

    /**
     * Menyimpan pendaftaran baru langsung sebagai data 'Pemeriksaan'.
     * Nama fungsi diubah agar sesuai dengan route yang ada.
     */
    public function storePoli(Request $request)
    {
        $request->validate([
            'id_jadwal' => 'required|exists:jadwal_periksas,id',
            'keluhan' => 'required|string|max:1000',
        ]);

        $jadwal = JadwalPeriksa::find($request->id_jadwal);
        
        Periksa::create([
            'pasien_id' => Auth::id(),
            'dokter_id' => $jadwal->dokter_id,
            'jadwal_id' => $jadwal->id,
            'keluhan' => $request->keluhan,
            'status' => 'menunggu', // Status awal adalah 'menunggu'
        ]);

        return redirect()->route('pasien.poli.daftar')
                         ->with('success', 'Berhasil mendaftar! Silakan tunggu panggilan dari dokter.');
    }
}

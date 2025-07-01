<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\JadwalPeriksa;
use App\Models\User;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalPeriksaController extends Controller
{
    /**
     * Menampilkan halaman daftar jadwal periksa milik dokter yang login.
     * FUNGSI INI YANG SEBELUMNYA HILANG.
     */
    public function index()
    {
        // Mengurutkan jadwal agar yang aktif selalu di atas
        $jadwals = JadwalPeriksa::where('dokter_id', Auth::id())
                    ->orderBy('status', 'desc')
                    ->get();
        return view('dokter.jadwal_periksa.index', compact('jadwals'));
    }

    /**
     * Menampilkan halaman dengan form untuk menambah jadwal baru.
     */
    public function create()
    {
        return view('dokter.jadwal_periksa.create');
    }

    /**
     * Menyimpan jadwal baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        JadwalPeriksa::create([
            'dokter_id' => Auth::id(),
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status' => false, // Defaultnya tidak aktif
        ]);

        return redirect()->route('dokter.jadwal-periksa.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit jadwal yang spesifik.
     */
    public function edit(JadwalPeriksa $jadwalPeriksa)
    {
        if ($jadwalPeriksa->dokter_id != Auth::id()) {
            abort(403);
        }
        return view('dokter.jadwal_periksa.edit', compact('jadwalPeriksa'));
    }

    /**
     * Memperbarui status jadwal dari halaman edit.
     */
    public function update(Request $request, JadwalPeriksa $jadwalPeriksa)
    {
        if ($jadwalPeriksa->dokter_id != Auth::id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|boolean',
        ]);
        
        if ($request->status == 1) {
            JadwalPeriksa::where('dokter_id', Auth::id())
                          ->where('id', '!=', $jadwalPeriksa->id)
                          ->update(['status' => false]);
        }

        $jadwalPeriksa->update([
            'status' => $request->status,
        ]);

        return redirect()->route('dokter.jadwal-periksa.index')->with('success', 'Status jadwal berhasil diperbarui.');
    }

    /**
     * Menghapus jadwal.
     */
    public function destroy(JadwalPeriksa $jadwalPeriksa)
    {
        if ($jadwalPeriksa->dokter_id != Auth::id()) {
            abort(403);
        }
        $jadwalPeriksa->delete();
        return redirect()->route('dokter.jadwal-periksa.index')->with('success', 'Jadwal berhasil dihapus.');
    }

    /**
     * Mengambil data jadwal berdasarkan ID poli untuk keperluan AJAX.
     */
    public function getJadwalByPoli($poli_id)
    {
        $dokterIds = User::where('role', 'dokter')
                         ->where('poli_id', $poli_id)
                         ->pluck('id');

        $jadwals = JadwalPeriksa::with('dokter')
                    ->whereIn('dokter_id', $dokterIds)
                    ->where('status', true) // Hanya ambil jadwal yang aktif untuk pasien
                    ->get();

        return response()->json($jadwals);
    }
}

<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\JadwalPeriksa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalPeriksaController extends Controller
{
    // ... (method-method lain seperti index, create, store, dll. tidak diubah)

    /**
     * Mengambil data jadwal berdasarkan ID poli untuk keperluan AJAX.
     */
    public function getJadwalByPoli($poli_id)
    {
        // 1. Cari semua dokter yang bertugas di poli dengan ID yang dipilih.
        $dokterIds = User::where('role', 'dokter')
                         ->where('poli_id', $poli_id)
                         ->pluck('id');

        // 2. Dari daftar dokter tersebut, cari semua jadwal mereka.
        $jadwals = JadwalPeriksa::with('dokter')
                    ->whereIn('dokter_id', $dokterIds)
                    // --- BARIS FILTER STATUS DI BAWAH INI SUDAH DIHAPUS ---
                    ->get();

        // 3. Kembalikan hasilnya dalam format JSON.
        return response()->json($jadwals);
    }

    // --- SISA METHOD DI BAWAH INI TIDAK PERLU DIUBAH ---
    public function index()
    {
        $jadwals = JadwalPeriksa::where('dokter_id', Auth::id())->orderBy('status', 'desc')->get();
        return view('dokter.jadwal_periksa.index', compact('jadwals'));
    }
    public function create()
    {
        // Anda mungkin perlu mengirim data poli ke sini jika belum
        $polis = \App\Models\Poli::all();
        return view('dokter.jadwal_periksa.create', compact('polis'));
    }
    public function store(Request $request)
    {
        // Pastikan validasi Anda tidak lagi memerlukan poli_id jika formnya tidak ada
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
            'status' => false,
        ]);
        return redirect()->route('dokter.jadwal-periksa.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }
    public function edit(JadwalPeriksa $jadwalPeriksa)
    {
        if ($jadwalPeriksa->dokter_id != Auth::id()) { abort(403); }
        return view('dokter.jadwal_periksa.edit', compact('jadwalPeriksa'));
    }
    public function update(Request $request, JadwalPeriksa $jadwalPeriksa)
    {
        if ($jadwalPeriksa->dokter_id != Auth::id()) { abort(403); }
        $request->validate(['status' => 'required|boolean']);
        if ($request->status == 1) {
            JadwalPeriksa::where('dokter_id', Auth::id())->where('id', '!=', $jadwalPeriksa->id)->update(['status' => false]);
        }
        $jadwalPeriksa->update(['status' => $request->status]);
        return redirect()->route('dokter.jadwal-periksa.index')->with('success', 'Status jadwal berhasil diperbarui.');
    }
    public function destroy(JadwalPeriksa $jadwalPeriksa)
    {
        if ($jadwalPeriksa->dokter_id != Auth::id()) { abort(403); }
        $jadwalPeriksa->delete();
        return redirect()->route('dokter.jadwal-periksa.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}

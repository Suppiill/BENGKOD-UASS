<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalOperasi;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class JadwalOperasiController extends Controller
{
    /**
     * Menampilkan halaman daftar semua jadwal operasi dengan filter.
     */
    public function index(Request $request) // <-- 1. Tambahkan Request $request di sini
    {
        // Memulai query dasar
        $query = JadwalOperasi::where('dokter_id', Auth::id());

        // Menerapkan filter berdasarkan input dari form
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('waktu_operasi', '>=', $request->tanggal_mulai);
        }

        // 👇 2. TAMBAHKAN BLOK IF UNTUK FILTER TANGGAL SELESAI 👇
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('waktu_operasi', '<=', $request->tanggal_selesai);
        }

        // Eksekusi query setelah semua filter diterapkan
        $jadwals = $query->with('pasien')->latest('waktu_operasi')->get();

        // Tampilkan view dan kirim data 'jadwals'
        return view('dokter.jadwal.index', compact('jadwals'));
    }

    /**
     * Menampilkan form untuk membuat jadwal operasi baru.
     */
    public function create()
    {
        $pasiens = User::where('role', 'pasien')->get();
        return view('dokter.jadwal.create', compact('pasiens'));
    }

    /**
     * Menyimpan data jadwal operasi baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|exists:users,id',
            'jenis_operasi' => 'required|string|max:255',
            'waktu_operasi' => 'required|date',
            'ruang_operasi' => 'required|string|max:255',
            'catatan' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['dokter_id'] = Auth::id();

        JadwalOperasi::create($data);

        return redirect()->route('dokter.jadwal.index')
                         ->with('success', 'Jadwal operasi baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit jadwal operasi.
     */
    public function edit($id)
    {
        $jadwal = JadwalOperasi::findOrFail($id);
        $pasiens = User::where('role', 'pasien')->get();
        
        return view('dokter.jadwal.edit', compact('jadwal', 'pasiens'));
    }

    /**
     * Memperbarui data jadwal operasi di database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'pasien_id' => 'required|exists:users,id',
            'jenis_operasi' => 'required|string|max:255',
            'waktu_operasi' => 'required|date',
            'ruang_operasi' => 'required|string|max:255',
            'status' => 'required|in:Terjadwal,Selesai,Dibatalkan',
            'catatan' => 'nullable|string',
        ]);

        $jadwal = JadwalOperasi::findOrFail($id);
        $jadwal->update($request->all());

        return redirect()->route('dokter.jadwal.index')
                         ->with('success', 'Jadwal operasi berhasil diperbarui.');
    }

    /**
     * Menghapus (membatalkan) data jadwal operasi.
     */
    public function destroy($id)
    {
        $jadwal = JadwalOperasi::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('dokter.jadwal.index')
                         ->with('success', 'Jadwal operasi telah dihapus/dibatalkan.');
    }
}
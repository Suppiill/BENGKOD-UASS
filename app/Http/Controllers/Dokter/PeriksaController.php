<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// Import Models
use App\Models\JanjiTemu;
use App\Models\Periksa;
use App\Models\DetailPeriksa;
use App\Models\Obat;

class PeriksaController extends Controller
{
    /**
     * Menampilkan daftar pasien yang siap untuk diperiksa.
     */
    public function index()
    {
        // --- INI BAGIAN YANG DIPERBAIKI ---
        // Mengubah filter dari 'diterima' menjadi 'menunggu'
        // Ini akan mengambil semua pasien yang baru mendaftar
        $daftarPeriksa = JanjiTemu::with('pasien')
                            ->where('dokter_id', Auth::id())
                            ->where('status', 'menunggu') 
                            ->get();
        
        return view('dokter.periksa.index', compact('daftarPeriksa'));
    }

    /**
     * Menampilkan form untuk memulai pemeriksaan.
     * Saat dokter mulai memeriksa, statusnya diubah menjadi 'diterima'.
     */
    public function periksa(JanjiTemu $janjiTemu)
    {
        if ($janjiTemu->dokter_id != Auth::id()) {
            abort(403);
        }

        // Saat dokter mengklik tombol 'Edit/Mulai Periksa',
        // kita anggap janji temu telah diterima.
        $janjiTemu->update(['status' => 'diterima']);

        $obats = Obat::all();
        return view('dokter.periksa.form', compact('janjiTemu', 'obats'));
    }

    /**
     * Menyimpan data hasil pemeriksaan baru.
     */
    public function store(Request $request, JanjiTemu $janjiTemu)
    {
        $request->validate([
            'catatan' => 'required|string',
            'diagnosa' => 'required|string', // Menggunakan 'diagnosa'
        ]);

        DB::beginTransaction();
        try {
            $totalHarga = 0;
            if ($request->has('obat_id')) {
                foreach ($request->obat_id as $index => $id_obat) {
                    $obat = Obat::find($id_obat);
                    $totalHarga += $obat->harga * $request->jumlah[$index];
                }
            }

            $periksa = Periksa::create([
                'id_janji' => $janjiTemu->id,
                'id_pasien' => $janjiTemu->pasien_id,
                'id_dokter' => Auth::id(),
                'tgl_periksa' => now(),
                'catatan' => $request->catatan,
                'diagnosa' => $request->diagnosa, // Menggunakan 'diagnosa'
                'total_harga_obat' => $totalHarga,
            ]);

            if ($request->has('obat_id')) {
                foreach ($request->obat_id as $index => $id_obat) {
                    DetailPeriksa::create([
                        'id_periksa' => $periksa->id,
                        'id_obat' => $id_obat,
                        'jumlah' => $request->jumlah[$index],
                    ]);
                }
            }

            // Update status janji temu menjadi 'selesai'
            $janjiTemu->update(['status' => 'selesai']);

            DB::commit();
            return redirect()->route('dokter.periksa.index')->with('success', 'Pemeriksaan berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data. ' . $e->getMessage());
        }
    }
    
    // ... (Sisa method riwayat, edit, update tidak perlu diubah)
    public function riwayat()
    {
        $riwayatPeriksa = Periksa::with('pasien')->where('id_dokter', Auth::id())->latest('tgl_periksa')->get();
        return view('dokter.riwayat.index', compact('riwayatPeriksa'));
    }
    public function edit(Periksa $periksa)
    {
        if ($periksa->id_dokter != Auth::id()) { abort(403); }
        $periksa->load('pasien', 'detailPeriksa.obat');
        $obats = Obat::all();
        return view('dokter.periksa.edit', compact('periksa', 'obats'));
    }
    public function update(Request $request, Periksa $periksa)
    {
        if ($periksa->id_dokter != Auth::id()) { abort(403); }
        $request->validate(['catatan' => 'required|string', 'diagnosa' => 'required|string']);
        $periksa->update(['catatan' => $request->catatan, 'diagnosa' => $request->diagnosa]);
        return redirect()->route('dokter.riwayat.index')->with('success', 'Data pemeriksaan berhasil diperbarui.');
    }
}

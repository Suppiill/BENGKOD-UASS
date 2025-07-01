<?php

// Pastikan namespace ini sesuai dengan lokasi file Anda
namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Periksa;
use App\Models\Obat;
use App\Models\DetailPeriksa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PeriksaController extends Controller
{
    // ... (fungsi index, create, store Anda tidak perlu diubah) ...
    public function index()
    {
        $dokterId = Auth::id();
        $daftarPeriksa = Periksa::with('pasien')
                                ->where('dokter_id', $dokterId)
                                ->whereDate('tgl_periksa', now())
                                ->orderBy('status', 'asc')
                                ->orderBy('created_at', 'asc')
                                ->get();
        return view('dokter.periksa.index', compact('daftarPeriksa'));
    }
    public function create(Periksa $periksa)
    {
        if ($periksa->dokter_id != Auth::id()) { abort(403, 'Akses tidak diizinkan.'); }
        $obats = Obat::get(['id', 'nama_obat', 'harga']); 
        return view('dokter.periksa.form', compact('periksa', 'obats'));
    }
    public function store(Request $request, Periksa $periksa)
    {
        if ($periksa->dokter_id != Auth::id()) { abort(403, 'Akses tidak diizinkan.'); }
        $request->validate([
            'catatan' => 'required|string',
            'obat_id' => 'nullable|array',
            'obat_id.*' => 'exists:obat,id',
        ]);
        DB::transaction(function () use ($request, $periksa) {
            $totalHarga = 0;
            DetailPeriksa::where('periksa_id', $periksa->id)->delete();
            if ($request->has('obat_id')) {
                foreach ($request->obat_id as $id_obat) {
                    $obat = Obat::find($id_obat);
                    if ($obat) {
                        $jumlah = 1;
                        DetailPeriksa::create(['periksa_id' => $periksa->id, 'obat_id' => $id_obat, 'jumlah' => $jumlah]);
                        $totalHarga += $obat->harga * $jumlah;
                    }
                }
            }
            $periksa->update(['catatan' => $request->catatan, 'diagnosa' => 'Sesuai resep.', 'total_harga_obat' => $totalHarga, 'status' => 'selesai']);
        });
        return redirect()->route('dokter.periksa.index')->with('success', 'Data pemeriksaan berhasil disimpan!');
    }
    public function riwayat()
    {
        $riwayatPeriksa = Periksa::with('pasien')->where('dokter_id', Auth::id())->where('status', 'selesai')->latest('tgl_periksa')->get();
        return view('dokter.riwayat.index', compact('riwayatPeriksa'));
    }


    /**
     * Menampilkan form edit pemeriksaan.
     * ================================================
     * == FUNGSI INI YANG DIPERBAIKI SECARA KESELURUHAN ==
     * ================================================
     */
    public function edit(Periksa $periksa)
    {
        if ($periksa->dokter_id != Auth::id()) {
            abort(403, 'Akses tidak diizinkan.');
        }
        
        // Memuat relasi detail resep yang sudah ada
        $periksa->load('detail');
        
        // Mengambil semua obat yang tersedia
        $obats = Obat::get(['id', 'nama_obat', 'harga']);

        // MEMBUAT VARIABEL BARU: Ambil semua 'obat_id' dari detail resep
        // dan ubah menjadi array. Inilah variabel yang hilang.
        $selectedObatIds = $periksa->detail->pluck('obat_id')->toArray();
        
        // Kirim semua data yang diperlukan ke view, termasuk variabel baru
        return view('dokter.periksa.edit', compact('periksa', 'obats', 'selectedObatIds')); 
    }

    /**
     * Memperbarui data pemeriksaan.
     */
    public function update(Request $request, Periksa $periksa)
    {
        // Logika update sama dengan store karena kita menghapus resep lama terlebih dahulu
        return $this->store($request, $periksa);
    }
}

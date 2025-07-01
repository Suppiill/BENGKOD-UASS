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
    /**
     * Menampilkan daftar pasien yang antre.
     */
    public function index()
    {
        $dokterId = Auth::id();
        $daftarPeriksa = Periksa::with('pasien')
                                ->where('dokter_id', $dokterId)
                                ->where('status', 'menunggu')
                                ->whereDate('tgl_periksa', now())
                                ->orderBy('created_at', 'asc')
                                ->get();
        return view('dokter.periksa.index', compact('daftarPeriksa'));
    }

    /**
     * Menampilkan form untuk memulai pemeriksaan.
     */
    public function create(Periksa $periksa)
    {
        if ($periksa->dokter_id != Auth::id()) {
            abort(403, 'Akses tidak diizinkan.');
        }

        // Mengambil data obat untuk ditampilkan di select box
        $obats = Obat::get(['id', 'nama_obat', 'harga']); 

        return view('dokter.periksa.form', compact('periksa', 'obats'));
    }

    /**
     * Menyimpan hasil pemeriksaan dan resep obat.
     * Logika disesuaikan untuk form dengan select multiple.
     */
    public function store(Request $request, Periksa $periksa)
    {
        if ($periksa->dokter_id != Auth::id()) {
            abort(403, 'Akses tidak diizinkan.');
        }

        // --- PERBAIKAN VALIDASI ---
        // Validasi disesuaikan untuk form select multiple (tidak ada lagi 'jumlah')
        $request->validate([
            'catatan' => 'required|string',
            'obat_id' => 'nullable|array',
            'obat_id.*' => 'exists:obat,id', // Validasi ke tabel 'obat'
        ]);

        DB::transaction(function () use ($request, $periksa) {
            $totalHarga = 0;

            // Hapus detail resep lama (penting untuk fitur edit agar tidak duplikat)
            DetailPeriksa::where('periksa_id', $periksa->id)->delete();

            // --- PERBAIKAN LOGIKA PENYIMPANAN ---
            // Proses setiap item obat yang dipilih dari select box
            if ($request->has('obat_id')) {
                foreach ($request->obat_id as $id_obat) {
                    $obat = Obat::find($id_obat);
                    
                    if ($obat) {
                        // Untuk form select multiple, kita asumsikan jumlahnya selalu 1
                        $jumlah = 1; 

                        // Simpan setiap item ke tabel detail_periksa
                        DetailPeriksa::create([
                            'periksa_id' => $periksa->id,
                            'obat_id' => $id_obat, // Menggunakan nama kolom yang benar
                            'jumlah' => $jumlah,
                        ]);
                        
                        // Akumulasi total harga
                        $totalHarga += $obat->harga * $jumlah;
                    }
                }
            }
            
            // Update data pemeriksaan utama
            $periksa->update([
                'catatan' => $request->catatan,
                'diagnosa' => 'Sesuai resep.',
                'total_harga_obat' => $totalHarga,
                'status' => 'selesai',
            ]);
        });

        return redirect()->route('dokter.periksa.index')->with('success', 'Data pemeriksaan berhasil disimpan!');
    }
    
    /**
     * Menampilkan riwayat pemeriksaan.
     */
    public function riwayat()
    {
        $riwayatPeriksa = Periksa::with('pasien')
                                ->where('dokter_id', Auth::id())
                                ->where('status', 'selesai')
                                ->latest('tgl_periksa')
                                ->get();
        return view('dokter.riwayat.index', compact('riwayatPeriksa'));
    }

    /**
     * Menampilkan form edit pemeriksaan.
     */
    public function edit(Periksa $periksa)
    {
        if ($periksa->dokter_id != Auth::id()) {
            abort(403, 'Akses tidak diizinkan.');
        }

        $periksa->load('detail.obat'); 
        $obats = Obat::get(['id', 'nama_obat', 'harga']);
        
        // Membuat variabel untuk menampung ID obat yang sudah dipilih
        $selectedObatIds = $periksa->detail->pluck('obat_id')->toArray();
        
        return view('dokter.periksa.edit', compact('periksa', 'obats', 'selectedObatIds')); 
    }

    /**
     * Memperbarui data pemeriksaan.
     */
    public function update(Request $request, Periksa $periksa)
    {
        return $this->store($request, $periksa);
    }
}

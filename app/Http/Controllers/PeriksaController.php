<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Periksa;
use App\Models\User; // Pastikan ini ada

class PeriksaController extends Controller
{
    /**
     * Menampilkan daftar semua user dengan peran 'pasien'.
     */
    public function index()
    {
        $pasiens = User::where('role', 'pasien')->latest()->get();
        return view('dokter.periksa.index', compact('pasiens'));
    }

    /**
     * Menampilkan form untuk mengedit data pasien.
     */
    public function edit($id)
    {
        // Cari data pasien di tabel 'users' berdasarkan ID yang di-klik
        $pasien = User::findOrFail($id);

        // Tampilkan view 'dokter.periksa.edit' dan kirim data '$pasien' ke dalamnya
        return view('dokter.periksa.edit', compact('pasien'));
    }

    /**
     * Memperbarui data pasien di database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
        ]);

        $pasien = User::findOrFail($id);
        $pasien->update($request->all());

        return redirect()->route('dokter.periksa.index')->with('success', 'Data pasien berhasil diperbarui!');
    }

    /**
     * Menghapus data pasien dari database.
     */
    public function destroy($id)
    {
        $pasien = User::findOrFail($id);
        $pasien->delete();

        return redirect()->route('dokter.periksa.index')->with('success', 'Data pasien berhasil dihapus.');
    }

    // CRUD opsional lain yang mungkin belum terpakai
    public function create() 
    {
        return view('dokter.periksa.create');
    }
    public function store(Request $request) 
    {
        Periksa::create($request->all());
        return redirect()->route('dokter.periksa.index')->with('success', 'Data pemeriksaan berhasil ditambahkan!');
    }
    public function show($id) {}
}
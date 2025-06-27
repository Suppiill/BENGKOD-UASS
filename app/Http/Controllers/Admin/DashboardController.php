<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Obat;
use App\Models\Poli;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung semua user dengan role 'dokter'
        $jumlahDokter = User::where('role', 'dokter')->count();

        // Hitung semua user dengan role 'pasien'
        $jumlahPasien = User::where('role', 'pasien')->count();

        // Hitung semua jenis obat yang ada
        $jumlahObat = Obat::count();

        // Contoh data untuk poli, Anda bisa menggantinya nanti
        $jumlahPoli = Poli::count(); 

        // Kirim semua data ke view
        return view('admin.dashboard', compact(
            'jumlahDokter',
            'jumlahPasien',
            'jumlahObat',
            'jumlahPoli'
        ));
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JanjiTemu extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'jadwal_id', // Pastikan kolom ini ada di database dan di sini
        'tanggal_janji',
        'waktu_janji',
        'keluhan',
        'status',
        'nomor_antrian',
    ];

    /**
     * Mendefinisikan relasi "milik" ke model User (sebagai Pasien).
     */
    public function pasien()
    {
        return $this->belongsTo(User::class, 'pasien_id');
    }

    /**
     * Mendefinisikan relasi "milik" ke model User (sebagai Dokter).
     */
    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }

    // =================================================================
    // == INI ADALAH RELASI BARU YANG MEMPERBAIKI ERROR ==
    // =================================================================
    /**
     * Mendefinisikan relasi "milik" ke model JadwalPeriksa.
     * Nama fungsi ini "jadwal" harus sama dengan yang dipanggil di controller/view.
     */
    public function jadwal()
    {
        // 'jadwal_id' adalah foreign key di tabel 'janji_temus'
        return $this->belongsTo(JadwalPeriksa::class, 'jadwal_id'); 
    }
}

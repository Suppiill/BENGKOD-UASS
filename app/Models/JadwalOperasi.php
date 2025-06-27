<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalOperasi extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jadwal_operasis'; // Nama tabel di database

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     * Ini penting untuk keamanan saat menggunakan metode create().
     *
     * @var array
     */
    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'jenis_operasi',
        'waktu_operasi',
        'ruang_operasi',
        'status',
        'catatan',
    ];

    /**
     * Mendefinisikan relasi "belongsTo" ke model User (sebagai pasien).
     * Satu jadwal operasi dimiliki oleh satu pasien.
     */
    public function pasien()
    {
        // 'pasien_id' adalah foreign key di tabel ini, 'id' adalah primary key di tabel users.
        return $this->belongsTo(User::class, 'pasien_id', 'id');
    }

    /**
     * Mendefinisikan relasi "belongsTo" ke model User (sebagai dokter).
     * Satu jadwal operasi ditangani oleh satu dokter.
     */
    public function dokter()
    {
        // 'dokter_id' adalah foreign key di tabel ini, 'id' adalah primary key di tabel users.
        return $this->belongsTo(User::class, 'dokter_id', 'id');
    }
}
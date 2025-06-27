<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini.
     *
     * @var string
     */
    protected $table = 'pasien'; // Atau 'pasiens' jika Anda mengikuti konvensi plural Laravel

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'alamat',
        'no_ktp',
        'no_hp',
        // Tambahkan atribut lain yang mungkin relevan untuk pasien
    ];

    /**
     * Mendefinisikan relasi one-to-many ke model Periksa.
     * Satu pasien bisa memiliki banyak data pemeriksaan.
     */
    public function periksa()
    {
        return $this->hasMany(Periksa::class);
    }
}
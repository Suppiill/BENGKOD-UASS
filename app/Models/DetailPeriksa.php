<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPeriksa extends Model
{
    use HasFactory;

    // Nama tabelnya 'detail_periksas' (plural), jadi kita tidak perlu protected $table
    // karena sudah sesuai dengan konvensi Laravel.

    /**
     * The attributes that are mass assignable.
     * ======================================================================
     * == INI ADALAH PERBAIKANNYA: Mengubah 'id_obat' menjadi 'obat_id'    ==
     * == agar sesuai dengan nama kolom di database.                     ==
     * ======================================================================
     */
    protected $fillable = [
        'periksa_id',
        'obat_id', // Nama kolom diperbaiki
        'jumlah',
    ];

    /**
     * Mendefinisikan relasi ke model Obat.
     */
    public function obat()
    {
        // Pastikan foreign key di sini juga benar
        return $this->belongsTo(Obat::class, 'obat_id');
    }

    /**
     * Mendefinisikan relasi ke model Periksa.
     */
    public function periksa()
    {
        return $this->belongsTo(Periksa::class, 'periksa_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPeriksa extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'dokter_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'status',
        'poli_id', // 1. TAMBAHKAN INI untuk izin menyimpan
    ];

    /**
     * Mendefinisikan relasi ke model User (Dokter).
     */
    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }
    
    // ===============================================
    // == 2. TAMBAHKAN FUNGSI RELASI INI ==
    // ===============================================
    /**
     * Mendefinisikan relasi ke model Poli.
     */
    public function poli()
    {
        return $this->belongsTo(Poli::class, 'poli_id');
    }
}

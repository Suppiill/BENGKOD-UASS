<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periksa extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'tanggal_periksa' => 'date',
    ];

    /**
     * The attributes that are mass assignable.
     * PASTIKAN SEMUA KOLOM INI ADA DI DALAM DAFTAR.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'tanggal_periksa',
        'keluhan',
        'diagnosis',
        'catatan_dokter',
        'status',
        'biaya_periksa',
        'janji_temu_id',
        'diagnosa',
        'catatan'
    ];

    /**
     * Mendefinisikan relasi ke model User (sebagai pasien).
     */
    public function pasien()
    {
        return $this->belongsTo(User::class, 'pasien_id');
    }

    /**
     * Mendefinisikan relasi ke model User (sebagai dokter).
     */
    public function dokter()
    {
        return $this->belongsTo(User::class, 'dokter_id');
    }

    public function janjiTemu()
    {
        return $this->belongsTo(JanjiTemu::class);
    }

    public function detailPeriksa()
    {
        return $this->hasMany(DetailPeriksa::class);
    }
}
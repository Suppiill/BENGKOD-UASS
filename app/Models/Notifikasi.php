<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory; // Standar Laravel, baik untuk ditambahkan

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     * Ini adalah daftar kolom yang diizinkan untuk diisi menggunakan metode create().
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'pesan',
        'link',
        'is_read',
    ];

    /**
     * Mendefinisikan relasi "belongsTo" ke model User.
     * Artinya, satu notifikasi ini "milik" satu user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
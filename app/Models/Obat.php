<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * Baris ini memberitahu Laravel bahwa nama tabel yang benar adalah 'obat' (tunggal).
     *
     * @var string
     */
    protected $table = 'obat'; // TAMBAHKAN BARIS INI

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_obat',
        'kemasan',
        'harga',
    ];
}

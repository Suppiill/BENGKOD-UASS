<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPeriksa extends Model
{
    protected $fillable = ['periksa_id', 'obat_id', 'jumlah'];

    public function obat()
    {
        return $this->belongsTo(Obat::class);
    }
}

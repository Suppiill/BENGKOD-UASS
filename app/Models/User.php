<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'alamat',
        'no_hp',
        'nik',
        'email',
        'role',
        'password',
        'poli_id',
        'spesialis',
        'no_rm',
    ];

    public function periksaSebagaiPasien()
    {
        return $this->hasMany(Periksa::class, 'id_pasien');
    }

    public function periksaSebagaiDokter()
    {
        return $this->hasMany(Periksa::class, 'id_dokter');
    }
    
    public function poli()
    {
        return $this->belongsTo(Poli::class, 'poli_id');
    }

    // ========================================================
    // == TAMBAHKAN FUNGSI RELASI INI ==
    // ========================================================
    /**
     * Mendefinisikan relasi bahwa seorang User (Dokter) memiliki banyak Jadwal Periksa.
     */
    public function jadwals()
    {
        // 'dokter_id' adalah foreign key di tabel 'jadwal_periksas'
        return $this->hasMany(JadwalPeriksa::class, 'dokter_id');
    }


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}

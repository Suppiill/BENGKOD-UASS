<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // 1. Membuat atau Memperbarui Pengguna Admin
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'], // Kunci untuk mencari
            [
                'name' => 'Admin',
                'alamat' => 'Kantor Pusat',
                'no_hp' => '081234567890',
                'nik' => '1111222233334444',
                'role' => 'admin',
                'password' => Hash::make('password')
            ]
        );

        // 2. Membuat atau Memperbarui Pengguna Dokter
        User::updateOrCreate(
            ['email' => 'dokterNaufal@gmail.com'], // Kunci untuk mencari
            [
                'name' => 'Dr. Naufal',
                'alamat' => 'Jalan Selalu No. 1, Semarang',
                'no_hp' => '081234567891',
                'nik' => '5555666677778888',
                'role' => 'dokter',
                'password' => Hash::make('password'),
                // Anda bisa menugaskan dokter ini ke sebuah poli jika datanya sudah ada
                // 'poli_id' => 1, 
            ]
        );

        // 3. Membuat atau Memperbarui Pengguna Pasien
        User::updateOrCreate(
            ['email' => 'supil@gmail.com'], // Kunci untuk mencari
            [
                'name' => 'Supil',
                'alamat' => 'Jalan denganmu No. 12, Semarang',
                'no_hp' => '081234567892',
                'nik' => '9999888877776666',
                'role' => 'pasien',
                'password' => Hash::make('password'),
                'no_rm' => '202506-001', // Contoh Nomor Rekam Medis
            ]
        );
    }
}

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
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'], // Kunci pencarian
            [
                'name' => 'Administrator',
                'alamat' => 'Kantor Pusat',
                'no_hp' => '081234567890',
                'nik' => '1234567890123456',
                'role' => 'admin',
                'password' => Hash::make('password') // Ini akan memperbaiki password yang salah.
            ]
        );
    }
}

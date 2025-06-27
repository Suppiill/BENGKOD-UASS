<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    // Arahkan ke halaman login setelah registrasi berhasil
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        // Tambahkan validasi untuk field baru
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:255'],
            'no_hp' => ['required', 'string', 'max:15'],
            'nik' => ['required', 'string', 'digits:16', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // Tambahkan field baru dan atur 'role' secara otomatis
        return User::create([
            'name' => $data['name'],
            'alamat' => $data['alamat'],
            'no_hp' => $data['no_hp'],
            'nik' => $data['nik'],
            'email' => $data['email'],
            'role' => 'pasien', // <-- OTOMATIS MENJADI PASIEN
            'password' => Hash::make($data['password']),
        ]);
    }
}
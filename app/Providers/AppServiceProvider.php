<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate; // <-- Tambahkan ini
use App\Models\User;                  // <-- Tambahkan ini

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Semua logika "penjaga keamanan" (Gate) kita letakkan di sini.

        Gate::define('is-admin', function (User $user) {
            return $user->role == 'admin';
        });

        Gate::define('is-dokter', function (User $user) {
            return $user->role == 'dokter';
        });

        Gate::define('is-pasien', function (User $user) {
            return $user->role == 'pasien';
        });
    }
}
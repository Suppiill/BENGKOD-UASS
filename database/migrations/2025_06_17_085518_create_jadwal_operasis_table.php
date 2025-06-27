<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jadwal_operasis', function (Blueprint $table) {
            $table->id();

            // PASTIKAN DUA BARIS INI ADA
            $table->foreignId('pasien_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('dokter_id')->constrained('users')->onDelete('cascade');

            $table->string('jenis_operasi');
            $table->dateTime('waktu_operasi');
            $table->string('ruang_operasi');
            $table->enum('status', ['Terjadwal', 'Selesai', 'Dibatalkan'])->default('Terjadwal');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_operasis');
    }
};

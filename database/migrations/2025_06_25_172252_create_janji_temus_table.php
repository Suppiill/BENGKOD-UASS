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
        Schema::create('janji_temus', function (Blueprint $table) {
            $table->id(); // Kolom ID otomatis (primary key)
            
            // Kolom untuk menghubungkan ke tabel users (dokter)
            $table->foreignId('dokter_id')->constrained('users')->onDelete('cascade');
            
            // Kolom untuk menghubungkan ke tabel users (pasien)
            $table->foreignId('pasien_id')->constrained('users')->onDelete('cascade');
            
            $table->date('tanggal_janji'); // Kolom tanggal janji temu
            $table->time('waktu_janji'); // Kolom waktu janji temu
            $table->text('keluhan'); // Kolom untuk keluhan pasien
            
            // Kolom status dengan nilai yang sudah ditentukan
            $table->enum('status', ['menunggu', 'diterima', 'ditolak', 'selesai'])->default('menunggu');
            
            $table->timestamps(); // Kolom created_at dan updated_at otomatis
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('janji_temus');
    }
};

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
        Schema::create('periksas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('janji_temu_id')->constrained('janji_temus')->onDelete('cascade');
            $table->foreignId('pasien_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('dokter_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal_periksa'); // Tanggal janji temu
            $table->text('keluhan');         // Keluhan awal dari pasien
            $table->text('diagnosis')->nullable(); // Diisi dokter nanti
            $table->text('catatan_dokter')->nullable(); // Diisi dokter nanti
            $table->enum('status', ['Dijadwalkan', 'Selesai', 'Dibatalkan'])->default('Dijadwalkan');
            $table->integer('total_harga_obat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periksas');
    }
};

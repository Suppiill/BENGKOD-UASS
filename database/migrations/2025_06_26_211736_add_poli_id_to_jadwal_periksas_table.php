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
            Schema::table('jadwal_periksas', function (Blueprint $table) {
                // TAMBAHKAN KODE INI
                // Menambahkan kolom poli_id setelah kolom dokter_id
                // Dibuat nullable() agar data jadwal lama Anda tidak error
                $table->unsignedBigInteger('poli_id')->nullable()->after('dokter_id');

                // Menambahkan "kunci asing" untuk menghubungkan ke tabel polis
                $table->foreign('poli_id')->references('id')->on('polis')->onDelete('set null');
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::table('jadwal_periksas', function (Blueprint $table) {
                // Kode untuk membatalkan perubahan jika perlu
                $table->dropForeign(['poli_id']);
                $table->dropColumn('poli_id');
            });
        }
    };
    
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
            Schema::table('users', function (Blueprint $table) {
                // TAMBAHKAN KODE INI DI DALAM FUNGSI up()
                $table->unsignedBigInteger('poli_id')->nullable()->after('role');

                // Menambahkan foreign key constraint (opsional tapi sangat direkomendasikan)
                // Ini akan menghubungkan kolom ini ke tabel 'polis'
                // dan memastikan integritas data.
                $table->foreign('poli_id')->references('id')->on('polis')->onDelete('set null');
            });
        }

        /**
         * Reverse the migrations.
         */
        public function down(): void
        {
            Schema::table('users', function (Blueprint $table) {
                // Kode ini untuk membatalkan perubahan jika diperlukan
                $table->dropForeign(['poli_id']);
                $table->dropColumn('poli_id');
            });
        }
    };
    
    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up(): void
        {
            Schema::table('users', function (Blueprint $table) {
                // Menambahkan kolom no_rm setelah kolom no_hp
                // Dibuat nullable() agar data lama tidak error, dan unique() agar tidak ada yang sama
                $table->string('no_rm')->nullable()->unique()->after('no_hp');
            });
        }

        public function down(): void
        {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('no_rm');
            });
        }
    };
    
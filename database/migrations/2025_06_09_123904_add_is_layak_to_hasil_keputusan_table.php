// database/migrations/..._add_is_layak_to_hasil_keputusan_table.php
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
        Schema::table('hasil_keputusans', function (Blueprint $table) {
            $table->boolean('is_layak')->default(false)->after('rekomendasi_akhir'); // Tambahkan kolom ini
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hasil_keputusans', function (Blueprint $table) {
            $table->dropColumn('is_layak');
        });
    }
};
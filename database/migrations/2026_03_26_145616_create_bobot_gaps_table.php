<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bobot_gaps', function (Blueprint $table) {
            $table->id();
            $table->double('selisih_gap')->unique(); // cth: 0, 1, -1, 2, -2
            $table->double('bobot_nilai'); // cth: 5, 4.5, 4, 3.5, 3
            $table->string('keterangan')->nullable(); // cth: 'Tidak ada Gap (Sesuai)'
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bobot_gaps');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('detail_riwayat_rekomendasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('riwayat_id')->constrained('riwayat_rekomendasis')->onDelete('cascade');
            $table->foreignId('makanan_id')->constrained('makanans')->onDelete('cascade');
            
            // Menyimpan detail perhitungan Profile Matching [cite: 1001-1003]
            $table->double('nilai_ncf')->nullable();
            $table->double('nilai_nsf')->nullable();
            $table->double('nilai_akhir')->nullable(); // Skor total
            $table->string('status_kelayakan')->nullable(); // Misal: "Sangat Direkomendasikan"
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_riwayat_rekomendasis');
    }
};
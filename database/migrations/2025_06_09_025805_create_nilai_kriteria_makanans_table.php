<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilai_kriteria_makanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('makanan_id')->constrained('makanans')->onDelete('cascade');
            $table->foreignId('kriteria_id')->constrained('kriterias')->onDelete('cascade');
            $table->double('nilai'); // Nilai aktual makanan untuk kriteria tsb
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilai_kriteria_makanans');
    }
};
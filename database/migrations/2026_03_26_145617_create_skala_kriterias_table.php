<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skala_kriterias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kriteria_id')->constrained('kriterias')->onDelete('cascade');
            $table->double('batas_bawah'); // cth: 0
            $table->double('batas_atas'); // cth: 25
            $table->integer('nilai_skala'); // cth: 5
            $table->string('keterangan')->nullable(); // cth: 'Sangat Rendah'
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skala_kriterias');
    }
};
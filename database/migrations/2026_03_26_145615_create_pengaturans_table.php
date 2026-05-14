<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pengaturan')->unique(); // cth: 'persentase_ncf', 'persentase_nsf'
            $table->double('nilai'); // cth: 60, 40
            $table->string('keterangan')->nullable(); // cth: 'Persentase untuk Core Factor'
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturans');
    }
};
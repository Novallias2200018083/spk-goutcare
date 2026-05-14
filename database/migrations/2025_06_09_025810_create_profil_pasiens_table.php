<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('profil_pasiens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Mode input dinamis
            $table->enum('metode_input', ['otomatis', 'manual'])->default('otomatis');
            
            // Data Fisik untuk Hitung BMR Otomatis
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->integer('umur')->nullable();
            $table->double('berat_badan')->nullable(); // kg
            $table->double('tinggi_badan')->nullable(); // cm
            $table->enum('tingkat_aktivitas', ['rendah', 'sedang', 'tinggi'])->nullable();
            $table->enum('fase_asam_urat', ['akut', 'normal'])->nullable();
            
            // Target Nutrisi Ideal (Profil Target) [cite: 1305-1306]
            $table->double('kebutuhan_kalori')->nullable();
            $table->double('kebutuhan_protein')->nullable();
            $table->double('kebutuhan_lemak')->nullable();
            $table->double('kebutuhan_karbohidrat')->nullable();
            $table->double('toleransi_purin')->nullable();
            
            $table->text('catatan_tambahan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profil_pasiens');
    }
};
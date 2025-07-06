<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profil_pasiens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->double('kebutuhan_kalori')->nullable();
            $table->double('kebutuhan_protein')->nullable();
            $table->double('kebutuhan_lemak')->nullable();
            $table->double('toleransi_purin')->nullable(); // Maksimal purin yang ditoleransi
            $table->text('catatan_tambahan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_pasiens');
    }
};
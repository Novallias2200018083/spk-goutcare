<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hasil_keputusans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('makanan_terpilih_id')->nullable()->constrained('makanans')->onDelete('set null');
            $table->timestamp('tanggal_keputusan')->useCurrent();
            $table->double('nilai_saw')->nullable();
            $table->double('nilai_profile_matching')->nullable();
            $table->text('rekomendasi_akhir')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hasil_keputusans');
    }
};
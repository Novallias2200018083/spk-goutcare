<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('makanans', function (Blueprint $table) {
            // Menandai apakah makanan ini diinput oleh user (true) atau admin (false)
            $table->boolean('is_user_input')->default(false)->after('deskripsi');
            // Jika diinput user, siapa user-nya. Nullable karena makanan admin tidak punya user_id
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade')->after('is_user_input');
        });
    }

    public function down(): void
    {
        Schema::table('makanans', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['is_user_input', 'user_id']);
        });
    }
};
<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Kriteria;

class KriteriaSeeder extends Seeder
{
    public function run(): void
    {
        Kriteria::create(['nama_kriteria' => 'Kadar Purin', 'bobot' => 0.4, 'tipe' => 'cost']);
        Kriteria::create(['nama_kriteria' => 'Kalori', 'bobot' => 0.2, 'tipe' => 'benefit']);
        Kriteria::create(['nama_kriteria' => 'Protein', 'bobot' => 0.2, 'tipe' => 'benefit']);
        Kriteria::create(['nama_kriteria' => 'Lemak', 'bobot' => 0.2, 'tipe' => 'cost']);
        // Tambahkan kriteria lain jika diperlukan
    }
}
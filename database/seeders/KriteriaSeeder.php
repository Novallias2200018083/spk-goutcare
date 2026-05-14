<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kriteria;

class KriteriaSeeder extends Seeder
{
    public function run(): void
    {
        // Berdasarkan Tabel 2.7 Kriteria dan Kategori Kriteria yang digunakan
        Kriteria::create(['nama_kriteria' => 'Kandungan Purin', 'tipe_faktor' => 'core']);
        Kriteria::create(['nama_kriteria' => 'Kandungan Kalori', 'tipe_faktor' => 'secondary']);
        Kriteria::create(['nama_kriteria' => 'Kandungan Lemak', 'tipe_faktor' => 'secondary']);
        Kriteria::create(['nama_kriteria' => 'Kandungan Protein', 'tipe_faktor' => 'core']);
        Kriteria::create(['nama_kriteria' => 'Kandungan Karbohidrat', 'tipe_faktor' => 'secondary']);
    }
}
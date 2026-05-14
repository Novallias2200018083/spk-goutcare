<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kriteria;
use Illuminate\Support\Facades\DB;

class SkalaKriteriaSeeder extends Seeder
{
    public function run(): void
    {
        $kPurin = Kriteria::where('nama_kriteria', 'Kandungan Purin')->first()->id;
        $kKalori = Kriteria::where('nama_kriteria', 'Kandungan Kalori')->first()->id;
        $kLemak = Kriteria::where('nama_kriteria', 'Kandungan Lemak')->first()->id;
        $kProtein = Kriteria::where('nama_kriteria', 'Kandungan Protein')->first()->id;
        $kKarbo = Kriteria::where('nama_kriteria', 'Kandungan Karbohidrat')->first()->id;

        $skala = [
            // C1 - Purin (Semakin rendah semakin baik) - Tabel 2.8
            ['kriteria_id' => $kPurin, 'batas_bawah' => 0, 'batas_atas' => 25, 'nilai_skala' => 5, 'keterangan' => 'Sangat Rendah'],
            ['kriteria_id' => $kPurin, 'batas_bawah' => 26, 'batas_atas' => 50, 'nilai_skala' => 4, 'keterangan' => 'Rendah'],
            ['kriteria_id' => $kPurin, 'batas_bawah' => 51, 'batas_atas' => 100, 'nilai_skala' => 3, 'keterangan' => 'Sedang'],
            ['kriteria_id' => $kPurin, 'batas_bawah' => 101, 'batas_atas' => 200, 'nilai_skala' => 2, 'keterangan' => 'Tinggi'],
            ['kriteria_id' => $kPurin, 'batas_bawah' => 201, 'batas_atas' => 9999, 'nilai_skala' => 1, 'keterangan' => 'Sangat Tinggi'],

            // C2 - Kalori (Semakin rendah semakin baik) - Tabel 2.9
            ['kriteria_id' => $kKalori, 'batas_bawah' => 0, 'batas_atas' => 50, 'nilai_skala' => 5, 'keterangan' => 'Sangat Rendah'],
            ['kriteria_id' => $kKalori, 'batas_bawah' => 51, 'batas_atas' => 100, 'nilai_skala' => 4, 'keterangan' => 'Rendah'],
            ['kriteria_id' => $kKalori, 'batas_bawah' => 101, 'batas_atas' => 200, 'nilai_skala' => 3, 'keterangan' => 'Sedang'],
            ['kriteria_id' => $kKalori, 'batas_bawah' => 201, 'batas_atas' => 300, 'nilai_skala' => 2, 'keterangan' => 'Tinggi'],
            ['kriteria_id' => $kKalori, 'batas_bawah' => 301, 'batas_atas' => 9999, 'nilai_skala' => 1, 'keterangan' => 'Sangat Tinggi'],

            // C3 - Lemak (Semakin rendah semakin baik) - Tabel 2.10
            ['kriteria_id' => $kLemak, 'batas_bawah' => 0, 'batas_atas' => 2, 'nilai_skala' => 5, 'keterangan' => 'Sangat Rendah'],
            ['kriteria_id' => $kLemak, 'batas_bawah' => 2.1, 'batas_atas' => 5, 'nilai_skala' => 4, 'keterangan' => 'Rendah'],
            ['kriteria_id' => $kLemak, 'batas_bawah' => 5.1, 'batas_atas' => 10, 'nilai_skala' => 3, 'keterangan' => 'Sedang'],
            ['kriteria_id' => $kLemak, 'batas_bawah' => 10.1, 'batas_atas' => 20, 'nilai_skala' => 2, 'keterangan' => 'Tinggi'],
            ['kriteria_id' => $kLemak, 'batas_bawah' => 20.1, 'batas_atas' => 9999, 'nilai_skala' => 1, 'keterangan' => 'Sangat Tinggi'],

            // C4 - Protein (Semakin tinggi semakin baik - namun di Tabel 2.11 tertulis >20 skala 5)
            ['kriteria_id' => $kProtein, 'batas_bawah' => 20.1, 'batas_atas' => 9999, 'nilai_skala' => 5, 'keterangan' => 'Sangat Tinggi'],
            ['kriteria_id' => $kProtein, 'batas_bawah' => 15, 'batas_atas' => 20, 'nilai_skala' => 4, 'keterangan' => 'Tinggi'],
            ['kriteria_id' => $kProtein, 'batas_bawah' => 10, 'batas_atas' => 14.9, 'nilai_skala' => 3, 'keterangan' => 'Sedang'], // Disesuaikan sedikit agar tidak ada gap desimal
            ['kriteria_id' => $kProtein, 'batas_bawah' => 5, 'batas_atas' => 9.9, 'nilai_skala' => 2, 'keterangan' => 'Rendah'],
            ['kriteria_id' => $kProtein, 'batas_bawah' => 0, 'batas_atas' => 4.9, 'nilai_skala' => 1, 'keterangan' => 'Sangat Rendah'],

            // C5 - Karbohidrat (Semakin tinggi semakin baik) - Tabel 2.12
            // Catatan: Di tabel 2.12 skripsi, kategori "Sangat Rendah (0-5)" diberi skala 5. Ini menandakan semakin RENDAH semakin BAIK, berbeda dengan teks sebelumnya. Saya ikuti angka tabel agar perhitungan cocok dengan Bab 3.
            ['kriteria_id' => $kKarbo, 'batas_bawah' => 0, 'batas_atas' => 5, 'nilai_skala' => 5, 'keterangan' => 'Sangat Rendah'],
            ['kriteria_id' => $kKarbo, 'batas_bawah' => 6, 'batas_atas' => 15, 'nilai_skala' => 4, 'keterangan' => 'Rendah'],
            ['kriteria_id' => $kKarbo, 'batas_bawah' => 15.1, 'batas_atas' => 30, 'nilai_skala' => 3, 'keterangan' => 'Sedang'],
            ['kriteria_id' => $kKarbo, 'batas_bawah' => 30.1, 'batas_atas' => 50, 'nilai_skala' => 2, 'keterangan' => 'Tinggi'],
            ['kriteria_id' => $kKarbo, 'batas_bawah' => 50.1, 'batas_atas' => 9999, 'nilai_skala' => 1, 'keterangan' => 'Sangat Tinggi'],
        ];

        DB::table('skala_kriterias')->insert($skala);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Makanan;
use App\Models\NilaiKriteriaMakanan;
use App\Models\Kriteria;

class MakananSeeder extends Seeder
{
    public function run(): void
    {
        $kPurin = Kriteria::where('nama_kriteria', 'Kandungan Purin')->first();
        $kKalori = Kriteria::where('nama_kriteria', 'Kandungan Kalori')->first();
        $kLemak = Kriteria::where('nama_kriteria', 'Kandungan Lemak')->first();
        $kProtein = Kriteria::where('nama_kriteria', 'Kandungan Protein')->first();
        $kKarbo = Kriteria::where('nama_kriteria', 'Kandungan Karbohidrat')->first();

        if (!$kPurin || !$kKalori || !$kProtein || !$kLemak || !$kKarbo) {
            $this->command->info('Silakan jalankan KriteriaSeeder terlebih dahulu!');
            return;
        }

        // Data berdasarkan Tabel 2.14 Data alternatif makanan beserta kandungan nutrisinya

        // A1. Nasi Goreng
        $m1 = Makanan::create(['nama_makanan' => 'Nasi Goreng', 'deskripsi' => 'Alternatif makanan A1', 'is_user_input' => 0]);
        $this->addNilai($m1->id, $kPurin->id, 30);
        $this->addNilai($m1->id, $kKalori->id, 168);
        $this->addNilai($m1->id, $kLemak->id, 6.23);
        $this->addNilai($m1->id, $kProtein->id, 6.3);
        $this->addNilai($m1->id, $kKarbo->id, 21.06);

        // A2. Tahu
        $m2 = Makanan::create(['nama_makanan' => 'Tahu', 'deskripsi' => 'Alternatif makanan A2', 'is_user_input' => 0]);
        $this->addNilai($m2->id, $kPurin->id, 68);
        $this->addNilai($m2->id, $kKalori->id, 78);
        $this->addNilai($m2->id, $kLemak->id, 4.9);
        $this->addNilai($m2->id, $kProtein->id, 7.9);
        $this->addNilai($m2->id, $kKarbo->id, 2.1);

        // A3. Ayam Goreng
        $m3 = Makanan::create(['nama_makanan' => 'Ayam Goreng', 'deskripsi' => 'Alternatif makanan A3', 'is_user_input' => 0]);
        $this->addNilai($m3->id, $kPurin->id, 170);
        $this->addNilai($m3->id, $kKalori->id, 165);
        $this->addNilai($m3->id, $kLemak->id, 3.6);
        $this->addNilai($m3->id, $kProtein->id, 31);
        $this->addNilai($m3->id, $kKarbo->id, 20);

        // A4. Bayam
        $m4 = Makanan::create(['nama_makanan' => 'Bayam', 'deskripsi' => 'Alternatif makanan A4', 'is_user_input' => 0]);
        $this->addNilai($m4->id, $kPurin->id, 57);
        $this->addNilai($m4->id, $kKalori->id, 40);
        $this->addNilai($m4->id, $kLemak->id, 2.25);
        $this->addNilai($m4->id, $kProtein->id, 2.9);
        $this->addNilai($m4->id, $kKarbo->id, 3.6);

        // A5. Brokoli
        $m5 = Makanan::create(['nama_makanan' => 'Brokoli', 'deskripsi' => 'Alternatif makanan A5', 'is_user_input' => 0]);
        $this->addNilai($m5->id, $kPurin->id, 81);
        $this->addNilai($m5->id, $kKalori->id, 34);
        $this->addNilai($m5->id, $kLemak->id, 0.37);
        $this->addNilai($m5->id, $kProtein->id, 2.8);
        $this->addNilai($m5->id, $kKarbo->id, 6.64);

        // A6. Tempe
        $m6 = Makanan::create(['nama_makanan' => 'Tempe', 'deskripsi' => 'Alternatif makanan A6', 'is_user_input' => 0]);
        $this->addNilai($m6->id, $kPurin->id, 190);
        $this->addNilai($m6->id, $kKalori->id, 193);
        $this->addNilai($m6->id, $kLemak->id, 10.8);
        $this->addNilai($m6->id, $kProtein->id, 18.54);
        $this->addNilai($m6->id, $kKarbo->id, 9.39);

        // A7. Kentang Goreng
        $m7 = Makanan::create(['nama_makanan' => 'Kentang Goreng', 'deskripsi' => 'Alternatif makanan A7', 'is_user_input' => 0]);
        $this->addNilai($m7->id, $kPurin->id, 6.5);
        $this->addNilai($m7->id, $kKalori->id, 87);
        $this->addNilai($m7->id, $kLemak->id, 0.1);
        $this->addNilai($m7->id, $kProtein->id, 1.87);
        $this->addNilai($m7->id, $kKarbo->id, 20.13);
    }

    private function addNilai($makananId, $kriteriaId, $nilai)
    {
        NilaiKriteriaMakanan::create([
            'makanan_id' => $makananId,
            'kriteria_id' => $kriteriaId,
            'nilai' => $nilai
        ]);
    }
}
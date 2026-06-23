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

        // Data 20 alternatif makanan berdasarkan evaluasi terbaru

        // A1. Nasi Putih
        $m1 = Makanan::create(['nama_makanan' => 'Nasi Putih', 'deskripsi' => 'Alternatif makanan A1', 'is_user_input' => 0]);
        $this->addNilai($m1->id, $kPurin->id, 25.9);
        $this->addNilai($m1->id, $kKalori->id, 180);
        $this->addNilai($m1->id, $kLemak->id, 0.3);
        $this->addNilai($m1->id, $kProtein->id, 3.0);
        $this->addNilai($m1->id, $kKarbo->id, 39.8);

        // A2. Roti Putih
        $m2 = Makanan::create(['nama_makanan' => 'Roti Putih', 'deskripsi' => 'Alternatif makanan A2', 'is_user_input' => 0]);
        $this->addNilai($m2->id, $kPurin->id, 4.4);
        $this->addNilai($m2->id, $kKalori->id, 248);
        $this->addNilai($m2->id, $kLemak->id, 1.2);
        $this->addNilai($m2->id, $kProtein->id, 8.0);
        $this->addNilai($m2->id, $kKarbo->id, 50.0);

        // A3. Spaghetti (Rebus)
        $m3 = Makanan::create(['nama_makanan' => 'Spaghetti (Rebus)', 'deskripsi' => 'Alternatif makanan A3', 'is_user_input' => 0]);
        $this->addNilai($m3->id, $kPurin->id, 6.8);
        $this->addNilai($m3->id, $kKalori->id, 139);
        $this->addNilai($m3->id, $kLemak->id, 2.1);
        $this->addNilai($m3->id, $kProtein->id, 7.4);
        $this->addNilai($m3->id, $kKarbo->id, 22.6);

        // A4. Biskuit
        $m4 = Makanan::create(['nama_makanan' => 'Biskuit', 'deskripsi' => 'Alternatif makanan A4', 'is_user_input' => 0]);
        $this->addNilai($m4->id, $kPurin->id, 14.1);
        $this->addNilai($m4->id, $kKalori->id, 458);
        $this->addNilai($m4->id, $kLemak->id, 14.4);
        $this->addNilai($m4->id, $kProtein->id, 6.9);
        $this->addNilai($m4->id, $kKarbo->id, 75.1);

        // A5. Mie Kering (Olahan)
        $m5 = Makanan::create(['nama_makanan' => 'Mie Kering (Olahan)', 'deskripsi' => 'Alternatif makanan A5', 'is_user_input' => 0]);
        $this->addNilai($m5->id, $kPurin->id, 21.6);
        $this->addNilai($m5->id, $kKalori->id, 339);
        $this->addNilai($m5->id, $kLemak->id, 1.7);
        $this->addNilai($m5->id, $kProtein->id, 10.0);
        $this->addNilai($m5->id, $kKarbo->id, 6.3);

        // A6. Tahu Goreng
        $m6 = Makanan::create(['nama_makanan' => 'Tahu Goreng', 'deskripsi' => 'Alternatif makanan A6', 'is_user_input' => 0]);
        $this->addNilai($m6->id, $kPurin->id, 54.4);
        $this->addNilai($m6->id, $kKalori->id, 115);
        $this->addNilai($m6->id, $kLemak->id, 9.7);
        $this->addNilai($m6->id, $kProtein->id, 8.5);
        $this->addNilai($m6->id, $kKarbo->id, 2.5);

        // A7. Tahu (Sutra/Kinu)
        $m7 = Makanan::create(['nama_makanan' => 'Tahu (Sutra/Kinu)', 'deskripsi' => 'Alternatif makanan A7', 'is_user_input' => 0]);
        $this->addNilai($m7->id, $kPurin->id, 20.0);
        $this->addNilai($m7->id, $kKalori->id, 80);
        $this->addNilai($m7->id, $kLemak->id, 10.9);
        $this->addNilai($m7->id, $kProtein->id, 4.7);
        $this->addNilai($m7->id, $kKarbo->id, 0.8);

        // A8. Tempe Goreng
        $m8 = Makanan::create(['nama_makanan' => 'Tempe Goreng', 'deskripsi' => 'Alternatif makanan A8', 'is_user_input' => 0]);
        $this->addNilai($m8->id, $kPurin->id, 141.5);
        $this->addNilai($m8->id, $kKalori->id, 350);
        $this->addNilai($m8->id, $kLemak->id, 24.5);
        $this->addNilai($m8->id, $kProtein->id, 26.6);
        $this->addNilai($m8->id, $kKarbo->id, 10.4);

        // A9. Susu Kedelai
        $m9 = Makanan::create(['nama_makanan' => 'Susu Kedelai', 'deskripsi' => 'Alternatif makanan A9', 'is_user_input' => 0]);
        $this->addNilai($m9->id, $kPurin->id, 22.0);
        $this->addNilai($m9->id, $kKalori->id, 41);
        $this->addNilai($m9->id, $kLemak->id, 2.5);
        $this->addNilai($m9->id, $kProtein->id, 3.5);
        $this->addNilai($m9->id, $kKarbo->id, 5.0);

        // A10. Sosis Daging Sapi
        $m10 = Makanan::create(['nama_makanan' => 'Sosis Daging Sapi', 'deskripsi' => 'Alternatif makanan A10', 'is_user_input' => 0]);
        $this->addNilai($m10->id, $kPurin->id, 45.5);
        $this->addNilai($m10->id, $kKalori->id, 448);
        $this->addNilai($m10->id, $kLemak->id, 42.3);
        $this->addNilai($m10->id, $kProtein->id, 14.5);
        $this->addNilai($m10->id, $kKarbo->id, 2.3);

        // A11. Kornet Daging Sapi
        $m11 = Makanan::create(['nama_makanan' => 'Kornet Daging Sapi', 'deskripsi' => 'Alternatif makanan A11', 'is_user_input' => 0]);
        $this->addNilai($m11->id, $kPurin->id, 47.0);
        $this->addNilai($m11->id, $kKalori->id, 289);
        $this->addNilai($m11->id, $kLemak->id, 0.0);
        $this->addNilai($m11->id, $kProtein->id, 16.0);
        $this->addNilai($m11->id, $kKarbo->id, 25.0);

        // A12. Ayam Goreng (Dada)
        $m12 = Makanan::create(['nama_makanan' => 'Ayam Goreng (Dada)', 'deskripsi' => 'Alternatif makanan A12', 'is_user_input' => 0]);
        $this->addNilai($m12->id, $kPurin->id, 141.2);
        $this->addNilai($m12->id, $kKalori->id, 298);
        $this->addNilai($m12->id, $kLemak->id, 16.8);
        $this->addNilai($m12->id, $kProtein->id, 34.2);
        $this->addNilai($m12->id, $kKarbo->id, 0.1);

        // A13. Ikan Sarden Kalengan
        $m13 = Makanan::create(['nama_makanan' => 'Ikan Sarden Kalengan', 'deskripsi' => 'Alternatif makanan A13', 'is_user_input' => 0]);
        $this->addNilai($m13->id, $kPurin->id, 132.9);
        $this->addNilai($m13->id, $kKalori->id, 338);
        $this->addNilai($m13->id, $kLemak->id, 27.0);
        $this->addNilai($m13->id, $kProtein->id, 21.1);
        $this->addNilai($m13->id, $kKarbo->id, 1.0);

        // A14. Telur Ayam Dadar
        $m14 = Makanan::create(['nama_makanan' => 'Telur Ayam Dadar', 'deskripsi' => 'Alternatif makanan A14', 'is_user_input' => 0]);
        $this->addNilai($m14->id, $kPurin->id, 0.0);
        $this->addNilai($m14->id, $kKalori->id, 251);
        $this->addNilai($m14->id, $kLemak->id, 19.4);
        $this->addNilai($m14->id, $kProtein->id, 16.3);
        $this->addNilai($m14->id, $kKarbo->id, 1.4);

        // A15. Telur Bebek Asin
        $m15 = Makanan::create(['nama_makanan' => 'Telur Bebek Asin', 'deskripsi' => 'Alternatif makanan A15', 'is_user_input' => 0]);
        $this->addNilai($m15->id, $kPurin->id, 0.0);
        $this->addNilai($m15->id, $kKalori->id, 179);
        $this->addNilai($m15->id, $kLemak->id, 13.3);
        $this->addNilai($m15->id, $kProtein->id, 13.6);
        $this->addNilai($m15->id, $kKarbo->id, 4.4);

        // A16. Keju (Cheddar)
        $m16 = Makanan::create(['nama_makanan' => 'Keju (Cheddar)', 'deskripsi' => 'Alternatif makanan A16', 'is_user_input' => 0]);
        $this->addNilai($m16->id, $kPurin->id, 6.0);
        $this->addNilai($m16->id, $kKalori->id, 326);
        $this->addNilai($m16->id, $kLemak->id, 20.3);
        $this->addNilai($m16->id, $kProtein->id, 22.8);
        $this->addNilai($m16->id, $kKarbo->id, 13.1);

        // A17. Yoghurt
        $m17 = Makanan::create(['nama_makanan' => 'Yoghurt', 'deskripsi' => 'Alternatif makanan A17', 'is_user_input' => 0]);
        $this->addNilai($m17->id, $kPurin->id, 5.2);
        $this->addNilai($m17->id, $kKalori->id, 52);
        $this->addNilai($m17->id, $kLemak->id, 2.5);
        $this->addNilai($m17->id, $kProtein->id, 3.3);
        $this->addNilai($m17->id, $kKarbo->id, 4.0);

        // A18. Susu Kental Manis
        $m18 = Makanan::create(['nama_makanan' => 'Susu Kental Manis', 'deskripsi' => 'Alternatif makanan A18', 'is_user_input' => 0]);
        $this->addNilai($m18->id, $kPurin->id, 0.16);
        $this->addNilai($m18->id, $kKalori->id, 343);
        $this->addNilai($m18->id, $kLemak->id, 10.0);
        $this->addNilai($m18->id, $kProtein->id, 8.2);
        $this->addNilai($m18->id, $kKarbo->id, 55.0);

        // A19. Cokelat Manis Batang
        $m19 = Makanan::create(['nama_makanan' => 'Cokelat Manis Batang', 'deskripsi' => 'Alternatif makanan A19', 'is_user_input' => 0]);
        $this->addNilai($m19->id, $kPurin->id, 8.1);
        $this->addNilai($m19->id, $kKalori->id, 527);
        $this->addNilai($m19->id, $kLemak->id, 2.0);
        $this->addNilai($m19->id, $kProtein->id, 29.8);
        $this->addNilai($m19->id, $kKarbo->id, 62.7);

        // A20. Kecap Asin / Manis
        $m20 = Makanan::create(['nama_makanan' => 'Kecap Asin / Manis', 'deskripsi' => 'Alternatif makanan A20', 'is_user_input' => 0]);
        $this->addNilai($m20->id, $kPurin->id, 45.2);
        $this->addNilai($m20->id, $kKalori->id, 71);
        $this->addNilai($m20->id, $kLemak->id, 1.3);
        $this->addNilai($m20->id, $kProtein->id, 5.7);
        $this->addNilai($m20->id, $kKarbo->id, 9.0);
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
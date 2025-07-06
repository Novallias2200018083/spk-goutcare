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
        // Pastikan kriteria sudah ada
        $kriteriaPurin = Kriteria::where('nama_kriteria', 'Kadar Purin')->first();
        $kriteriaKalori = Kriteria::where('nama_kriteria', 'Kalori')->first();
        $kriteriaProtein = Kriteria::where('nama_kriteria', 'Protein')->first();
        $kriteriaLemak = Kriteria::where('nama_kriteria', 'Lemak')->first();

        if (!$kriteriaPurin || !$kriteriaKalori || !$kriteriaProtein || !$kriteriaLemak) {
            $this->command->info('Please run KriteriaSeeder first!');
            return;
        }

        // Contoh Data Makanan
        $makanan1 = Makanan::create(['nama_makanan' => 'Daging Ayam (dada tanpa kulit)', 'deskripsi' => 'Rendah purin, tinggi protein.']);
        NilaiKriteriaMakanan::create(['makanan_id' => $makanan1->id, 'kriteria_id' => $kriteriaPurin->id, 'nilai' => 100]); // mg/100g
        NilaiKriteriaMakanan::create(['makanan_id' => $makanan1->id, 'kriteria_id' => $kriteriaKalori->id, 'nilai' => 165]); // kkal/100g
        NilaiKriteriaMakanan::create(['makanan_id' => $makanan1->id, 'kriteria_id' => $kriteriaProtein->id, 'nilai' => 31]); // gram/100g
        NilaiKriteriaMakanan::create(['makanan_id' => $makanan1->id, 'kriteria_id' => $kriteriaLemak->id, 'nilai' => 3.6]); // gram/100g

        $makanan2 = Makanan::create(['nama_makanan' => 'Salmon', 'deskripsi' => 'Sumber Omega-3, purin sedang.']);
        NilaiKriteriaMakanan::create(['makanan_id' => $makanan2->id, 'kriteria_id' => $kriteriaPurin->id, 'nilai' => 170]);
        NilaiKriteriaMakanan::create(['makanan_id' => $makanan2->id, 'kriteria_id' => $kriteriaKalori->id, 'nilai' => 208]);
        NilaiKriteriaMakanan::create(['makanan_id' => $makanan2->id, 'kriteria_id' => $kriteriaProtein->id, 'nilai' => 20]);
        NilaiKriteriaMakanan::create(['makanan_id' => $makanan2->id, 'kriteria_id' => $kriteriaLemak->id, 'nilai' => 13]);

        $makanan3 = Makanan::create(['nama_makanan' => 'Telur', 'deskripsi' => 'Sangat rendah purin, protein lengkap.']);
        NilaiKriteriaMakanan::create(['makanan_id' => $makanan3->id, 'kriteria_id' => $kriteriaPurin->id, 'nilai' => 10]);
        NilaiKriteriaMakanan::create(['makanan_id' => $makanan3->id, 'kriteria_id' => $kriteriaKalori->id, 'nilai' => 155]);
        NilaiKriteriaMakanan::create(['makanan_id' => $makanan3->id, 'kriteria_id' => $kriteriaProtein->id, 'nilai' => 13]);
        NilaiKriteriaMakanan::create(['makanan_id' => $makanan3->id, 'kriteria_id' => $kriteriaLemak->id, 'nilai' => 11]);

        $makanan4 = Makanan::create(['nama_makanan' => 'Bayam', 'deskripsi' => 'Sayuran hijau, purin sedang-tinggi, tapi aman jika tidak berlebihan.']);
        NilaiKriteriaMakanan::create(['makanan_id' => $makanan4->id, 'kriteria_id' => $kriteriaPurin->id, 'nilai' => 57]);
        NilaiKriteriaMakanan::create(['makanan_id' => $makanan4->id, 'kriteria_id' => $kriteriaKalori->id, 'nilai' => 23]);
        NilaiKriteriaMakanan::create(['makanan_id' => $makanan4->id, 'kriteria_id' => $kriteriaProtein->id, 'nilai' => 2.9]);
        NilaiKriteriaMakanan::create(['makanan_id' => $makanan4->id, 'kriteria_id' => $kriteriaLemak->id, 'nilai' => 0.4]);

        $makanan5 = Makanan::create(['nama_makanan' => 'Roti Gandum', 'deskripsi' => 'Karbohidrat kompleks, purin rendah.']);
        NilaiKriteriaMakanan::create(['makanan_id' => $makanan5->id, 'kriteria_id' => $kriteriaPurin->id, 'nilai' => 20]);
        NilaiKriteriaMakanan::create(['makanan_id' => $makanan5->id, 'kriteria_id' => $kriteriaKalori->id, 'nilai' => 265]);
        NilaiKriteriaMakanan::create(['makanan_id' => $makanan5->id, 'kriteria_id' => $kriteriaProtein->id, 'nilai' => 11]);
        NilaiKriteriaMakanan::create(['makanan_id' => $makanan5->id, 'kriteria_id' => $kriteriaLemak->id, 'nilai' => 3]);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfileMatchingSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Insert Data Pengaturan (Core 60% & Secondary 40%)
        DB::table('pengaturans')->insert([
            ['nama_pengaturan' => 'persentase_ncf', 'nilai' => 60, 'keterangan' => 'Persentase Core Factor'],
            ['nama_pengaturan' => 'persentase_nsf', 'nilai' => 40, 'keterangan' => 'Persentase Secondary Factor'],
        ]);

        // 2. Insert Data Tabel Bobot Gap (Merujuk Tabel 2.2 di Skripsi)
        DB::table('bobot_gaps')->insert([
            ['selisih_gap' => 0, 'bobot_nilai' => 5, 'keterangan' => 'Tidak ada Gap (Sesuai)'],
            ['selisih_gap' => 1, 'bobot_nilai' => 4.5, 'keterangan' => 'Kelebihan 1 tingkat'],
            ['selisih_gap' => -1, 'bobot_nilai' => 4, 'keterangan' => 'Kurang 1 tingkat'],
            ['selisih_gap' => 2, 'bobot_nilai' => 3.5, 'keterangan' => 'Kelebihan 2 tingkat'],
            ['selisih_gap' => -2, 'bobot_nilai' => 3, 'keterangan' => 'Kurang 2 tingkat'],
            ['selisih_gap' => 3, 'bobot_nilai' => 2.5, 'keterangan' => 'Kelebihan 3 tingkat'],
            ['selisih_gap' => -3, 'bobot_nilai' => 2, 'keterangan' => 'Kurang 3 tingkat'],
            ['selisih_gap' => 4, 'bobot_nilai' => 1.5, 'keterangan' => 'Kelebihan 4 tingkat'],
            ['selisih_gap' => -4, 'bobot_nilai' => 1, 'keterangan' => 'Kurang 4 tingkat'],
        ]);
    }
}
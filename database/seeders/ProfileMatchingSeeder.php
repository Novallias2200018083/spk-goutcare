<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfileMatchingSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Insert Data Pengaturan (Core 60% & Secondary 40% + Skala Target Default)
        DB::table('pengaturans')->insert([
            ['nama_pengaturan' => 'persentase_ncf', 'tipe' => 'persentase', 'nilai' => 60, 'keterangan' => 'Persentase Core Factor'],
            ['nama_pengaturan' => 'persentase_nsf', 'tipe' => 'persentase', 'nilai' => 40, 'keterangan' => 'Persentase Secondary Factor'],
            
            // Aturan Target Skala Default (1 - 5)
            ['nama_pengaturan' => 'target_purin_akut', 'tipe' => 'skala', 'nilai' => 4, 'keterangan' => 'Target Skala Purin (Fase Akut)'],
            ['nama_pengaturan' => 'target_purin_normal', 'tipe' => 'skala', 'nilai' => 3, 'keterangan' => 'Target Skala Purin (Fase Normal)'],
            
            ['nama_pengaturan' => 'target_kalori_kurus', 'tipe' => 'skala', 'nilai' => 2, 'keterangan' => 'Target Skala Kalori (IMT Kurus)'],
            ['nama_pengaturan' => 'target_kalori_normal', 'tipe' => 'skala', 'nilai' => 3, 'keterangan' => 'Target Skala Kalori (IMT Normal)'],
            ['nama_pengaturan' => 'target_kalori_obesitas', 'tipe' => 'skala', 'nilai' => 4, 'keterangan' => 'Target Skala Kalori (IMT Obesitas)'],
            
            ['nama_pengaturan' => 'target_lemak_normal', 'tipe' => 'skala', 'nilai' => 3, 'keterangan' => 'Target Skala Lemak (IMT Normal/Kurus)'],
            ['nama_pengaturan' => 'target_lemak_obesitas', 'tipe' => 'skala', 'nilai' => 4, 'keterangan' => 'Target Skala Lemak (IMT Obesitas)'],
            
            ['nama_pengaturan' => 'target_protein_default', 'tipe' => 'skala', 'nilai' => 3, 'keterangan' => 'Target Skala Protein Default'],
            ['nama_pengaturan' => 'target_karbohidrat_default', 'tipe' => 'skala', 'nilai' => 3, 'keterangan' => 'Target Skala Karbohidrat Default'],
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
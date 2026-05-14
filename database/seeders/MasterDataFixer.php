<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kriteria;
use App\Models\Pengaturan;
use App\Models\BobotGap;
use Illuminate\Support\Facades\DB;

class MasterDataFixer extends Seeder
{
    public function run(): void
    {
        // 1. Pastikan Kriteria punya tipe_faktor yang benar
        $kriterias = [
            'Kandungan Purin' => 'core',
            'Kandungan Kalori' => 'secondary',
            'Kandungan Lemak' => 'secondary',
            'Kandungan Protein' => 'core',
            'Kandungan Karbohidrat' => 'secondary',
        ];

        foreach ($kriterias as $nama => $tipe) {
            Kriteria::where('nama_kriteria', 'like', "%$nama%")->update(['tipe_faktor' => $tipe]);
        }

        // 2. Pastikan Pengaturan Persentase ada
        Pengaturan::updateOrCreate(
            ['nama_pengaturan' => 'persentase_ncf'],
            ['nilai' => 60, 'keterangan' => 'Persentase Core Factor']
        );
        Pengaturan::updateOrCreate(
            ['nama_pengaturan' => 'persentase_nsf'],
            ['nilai' => 40, 'keterangan' => 'Persentase Secondary Factor']
        );

        // 3. Pastikan Bobot GAP lengkap (Mencegah nilai 0 jika gap tidak terdefinisi)
        $gaps = [
            0 => 5,
            1 => 4.5,
            -1 => 4,
            2 => 3.5,
            -2 => 3,
            3 => 2.5,
            -3 => 2,
            4 => 1.5,
            -4 => 1,
        ];

        foreach ($gaps as $selisih => $bobot) {
            BobotGap::updateOrCreate(
                ['selisih_gap' => $selisih],
                ['bobot_nilai' => $bobot, 'keterangan' => "Gap $selisih"]
            );
        }
    }
}

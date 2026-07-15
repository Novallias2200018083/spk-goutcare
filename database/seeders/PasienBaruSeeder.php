<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ProfilPasien;
use App\Models\Makanan;
use App\Models\NilaiKriteriaMakanan;
use Illuminate\Support\Facades\Hash;

class PasienBaruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1. Buat User Pasien Baru
        $user = User::create([
            'name' => 'Pasien Testing Gout',
            'email' => 'pasientest@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'pasien',
        ]);

        // 2. Buat Profil Pasien (Default dummy data)
        ProfilPasien::create([
            'user_id' => $user->id,
            'metode_input' => 'manual',
            'jenis_kelamin' => 'L',
            'umur' => 45,
            'berat_badan' => 70, // kg
            'tinggi_badan' => 170, // cm
            'tingkat_aktivitas' => 'sedang',
            'fase_asam_urat' => 'normal',
            'toleransi_purin' => 500,
            'kebutuhan_kalori' => 2000,
            'kebutuhan_protein' => 60,
            'kebutuhan_lemak' => 50,
            'kebutuhan_karbohidrat' => 300,
        ]);

        // 3. Data Makanan dari Screenshot
        $makananData = [
            [
                'nama' => 'Nasi Goreng',
                'deskripsi' => 'Alternatif makanan A1',
                'nilai' => [
                    1 => 30,      // Purin
                    2 => 168,     // Kalori
                    3 => 6.23,    // Lemak
                    4 => 6.3,     // Protein
                    5 => 21.06    // Karbohidrat
                ]
            ],
            [
                'nama' => 'Tahu',
                'deskripsi' => 'Alternatif makanan A2',
                'nilai' => [
                    1 => 68,
                    2 => 78,
                    3 => 4.9,
                    4 => 7.9,
                    5 => 2.1
                ]
            ],
            [
                'nama' => 'Ayam Goreng',
                'deskripsi' => 'Alternatif makanan A3',
                'nilai' => [
                    1 => 170,
                    2 => 165,
                    3 => 3.6,
                    4 => 31,
                    5 => 20
                ]
            ],
            [
                'nama' => 'Bayam',
                'deskripsi' => 'Alternatif makanan A4',
                'nilai' => [
                    1 => 57,
                    2 => 40,
                    3 => 2.25,
                    4 => 2.9,
                    5 => 3.6
                ]
            ],
            [
                'nama' => 'Brokoli',
                'deskripsi' => 'Alternatif makanan A5',
                'nilai' => [
                    1 => 81,
                    2 => 34,
                    3 => 0.37,
                    4 => 2.8,
                    5 => 6.64
                ]
            ],
            [
                'nama' => 'Tempe',
                'deskripsi' => 'Alternatif makanan A6',
                'nilai' => [
                    1 => 190,
                    2 => 193,
                    3 => 10.8,
                    4 => 18.54,
                    5 => 9.39
                ]
            ],
            [
                'nama' => 'Kentang Goreng',
                'deskripsi' => 'Alternatif makanan A7',
                'nilai' => [
                    1 => 6.5,
                    2 => 87,
                    3 => 0.1,
                    4 => 1.87,
                    5 => 20.13
                ]
            ]
        ];

        // 4. Masukkan ke database
        foreach ($makananData as $data) {
            $makanan = Makanan::create([
                'user_id' => $user->id, // Makanan pribadi
                'nama_makanan' => $data['nama'],
                'deskripsi' => $data['deskripsi'],
                'is_user_input' => true,
            ]);

            foreach ($data['nilai'] as $kriteriaId => $nilai) {
                NilaiKriteriaMakanan::create([
                    'makanan_id' => $makanan->id,
                    'kriteria_id' => $kriteriaId,
                    'nilai' => $nilai,
                ]);
            }
        }
    }
}

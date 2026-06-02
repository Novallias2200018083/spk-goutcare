<?php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin SPK',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $pasien = User::create([
            'name' => 'Pasien A',
            'email' => 'pasien_a@example.com',
            'password' => Hash::make('password'),
            'role' => 'pasien',
        ]);

        // Berdasarkan Tabel 2.13 Profil Kebutuhan Gizi Ideal / Target (Pak Agus)
        \App\Models\ProfilPasien::create([
            'user_id' => $pasien->id,
            'toleransi_purin' => 90,
            'kebutuhan_kalori' => 120,
            'kebutuhan_protein' => 12,
            'kebutuhan_lemak' => 4,
        ]);
    }
}
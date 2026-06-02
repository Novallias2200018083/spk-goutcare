<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Makanan;
use App\Models\Kriteria;
use App\Services\SpkService;

$user = User::where('name', 'Pasien A')->first();
$profilPasien = $user->profilPasien;
$allMakanans = Makanan::with('nilaiKriterias.kriteria')->get();
$kriterias = Kriteria::all();

$spkService = new SpkService();
$result = $spkService->hitungRekomendasi($profilPasien, $allMakanans, $kriterias, true);

echo "TARGET KEBUTUHAN (SKALA):\n";
print_r($result['targetKebutuhanSkala']);
echo "\n";

echo "NORMALISASI PM:\n";
foreach($result['normalisasiPM'] as $makananId => $data) {
    $makanan = Makanan::find($makananId);
    echo $makanan->nama_makanan . " (ID: $makananId)\n";
    echo "  - NCF: " . $data['nilai_ncf'] . "\n";
    echo "  - NSF: " . $data['nilai_nsf'] . "\n";
    echo "  - Total PM: " . $data['nilai_total_pm'] . "\n";
}
echo "\n";

echo "HASIL AKHIR REKOMENDASI:\n";
foreach($result['finalRecommendations'] as $idx => $rec) {
    echo ($idx + 1) . ". " . $rec['nama_makanan'] . " - Nilai PM: " . $rec['nilai_profile_matching'] . " | Layak: " . ($rec['is_layak'] ? 'Ya' : 'Tidak') . "\n";
}

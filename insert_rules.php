<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$count = \App\Models\Pengaturan::where('tipe', 'skala')->count();
if ($count == 0) {
    \App\Models\Pengaturan::insert([
        ['nama_pengaturan' => 'target_purin_akut', 'tipe' => 'skala', 'nilai' => 5, 'keterangan' => 'Target Skala Purin (Fase Akut)'],
        ['nama_pengaturan' => 'target_purin_normal', 'tipe' => 'skala', 'nilai' => 3, 'keterangan' => 'Target Skala Purin (Fase Normal)'],
        ['nama_pengaturan' => 'target_kalori_kurus', 'tipe' => 'skala', 'nilai' => 2, 'keterangan' => 'Target Skala Kalori (IMT Kurus)'],
        ['nama_pengaturan' => 'target_kalori_normal', 'tipe' => 'skala', 'nilai' => 3, 'keterangan' => 'Target Skala Kalori (IMT Normal)'],
        ['nama_pengaturan' => 'target_kalori_obesitas', 'tipe' => 'skala', 'nilai' => 4, 'keterangan' => 'Target Skala Kalori (IMT Obesitas)'],
        ['nama_pengaturan' => 'target_lemak_normal', 'tipe' => 'skala', 'nilai' => 3, 'keterangan' => 'Target Skala Lemak (IMT Normal/Kurus)'],
        ['nama_pengaturan' => 'target_lemak_obesitas', 'tipe' => 'skala', 'nilai' => 4, 'keterangan' => 'Target Skala Lemak (IMT Obesitas)'],
        ['nama_pengaturan' => 'target_protein_default', 'tipe' => 'skala', 'nilai' => 3, 'keterangan' => 'Target Skala Protein Default'],
        ['nama_pengaturan' => 'target_karbohidrat_default', 'tipe' => 'skala', 'nilai' => 3, 'keterangan' => 'Target Skala Karbohidrat Default']
    ]);
    echo "Inserted 9 rules.\n";
} else {
    echo "Rules already exist.\n";
}

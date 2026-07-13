<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\RiwayatRekomendasi;
use Illuminate\Support\Facades\Auth;

class RiwayatRekomendasiController extends Controller
{
    // 1. Menampilkan semua riwayat milik user dengan filter
    public function index(\Illuminate\Http\Request $request)
    {
        $query = RiwayatRekomendasi::where('user_id', Auth::id());

        // Filter Tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_rekomendasi', $request->tanggal);
        }

        // Filter Jenis Makanan (Sistem / Pribadi)
        if ($request->filled('jenis_makanan') && $request->jenis_makanan !== 'semua') {
            $jenis = $request->jenis_makanan; // 'sistem' atau 'pribadi'
            $query->whereHas('detailRiwayats.makanan', function ($q) use ($jenis) {
                if ($jenis == 'sistem') {
                    $q->whereNull('user_id');
                } else if ($jenis == 'pribadi') {
                    $q->whereNotNull('user_id');
                }
            });
        }

        $riwayats = $query->latest()->get();
            
        return view('pasien.riwayat.index', compact('riwayats'));
    }

    // 2. Menampilkan detail makanan yang direkomendasikan pada riwayat tertentu
    public function show($id)
    {
        // Mengambil riwayat beserta detail dan relasi makanannya
        $riwayat = RiwayatRekomendasi::where('user_id', Auth::id())
            ->with(['detailRiwayats.makanan'])
            ->findOrFail($id);

        // Mengurutkan detail dari nilai akhir tertinggi ke terendah (Ranking)
        $detailRiwayats = $riwayat->detailRiwayats->sortByDesc('nilai_akhir');

        return view('pasien.riwayat.show', compact('riwayat', 'detailRiwayats'));
    }

    // 3. Export Hasil Rekomendasi ke PDF
    public function exportPdf($id)
    {
        $riwayat = RiwayatRekomendasi::where('user_id', Auth::id())
            ->with(['detailRiwayats.makanan'])
            ->findOrFail($id);

        $detailRiwayats = $riwayat->detailRiwayats->sortByDesc('nilai_akhir');
        
        // Memuat view khusus untuk PDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pasien.riwayat.pdf', compact('riwayat', 'detailRiwayats'));
        
        // Opsi ukuran kertas dan orientasi
        $pdf->setPaper('a4', 'portrait');

        $filename = 'Hasil_Rekomendasi_GoutCare_' . $riwayat->tanggal_rekomendasi->format('Ymd_Hi') . '.pdf';

        return $pdf->download($filename);
    }
}
<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\RiwayatRekomendasi;
use Illuminate\Support\Facades\Auth;

class RiwayatRekomendasiController extends Controller
{
    // 1. Menampilkan semua riwayat milik user
    public function index()
    {
        $riwayats = RiwayatRekomendasi::where('user_id', Auth::id())
            ->latest()
            ->get();
            
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
}
<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PasienDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Mengambil relasi profil pasien
        $profil = $user->profilPasien; 
        
        // Mengambil 5 riwayat rekomendasi terakhir
        $riwayats = $user->riwayatRekomendasis()->latest()->take(5)->get();

        // Mengambil detail rekomendasi terbaik dari riwayat terbaru
        $latestRiwayat = $user->riwayatRekomendasis()->with(['detailRiwayats.makanan'])->latest()->first();
        $rekomendasiTerbaik = $latestRiwayat ? $latestRiwayat->detailRiwayats()
            ->whereIn('status_kelayakan', ['Direkomendasikan', 'Cukup Direkomendasikan'])
            ->orderBy('nilai_akhir', 'desc')
            ->take(5)
            ->get() : collect();

        return view('pasien.dashboard', compact('profil', 'riwayats', 'rekomendasiTerbaik'));
    }
}
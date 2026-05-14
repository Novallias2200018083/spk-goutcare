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

        return view('pasien.dashboard', compact('profil', 'riwayats'));
    }
}
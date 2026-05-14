<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Makanan;
use App\Models\RiwayatRekomendasi;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Menghitung total pasien yang terdaftar
        $totalPasien = User::where('role', 'pasien')->count();

        // Menghitung total makanan standar dari sistem (bukan inputan user)
        $totalMakanan = Makanan::where('is_user_input', false)->count();

        // Menghitung total riwayat rekomendasi yang sudah dilakukan
        $totalRekomendasi = RiwayatRekomendasi::count();

        // Menghitung total kriteria yang ada
        $totalKriteria = \App\Models\Kriteria::count();

        // Mengirim data ke view dashboard admin
        return view('admin.dashboard.index', compact(
            'totalPasien', 
            'totalMakanan', 
            'totalKriteria',
            'totalRekomendasi'
        ));
    }
}
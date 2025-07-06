<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Makanan;
use App\Models\Kriteria;
use App\Models\HasilKeputusan; // Pastikan model HasilKeputusan di-import



class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalMakanan = Makanan::count();
        $totalKriteria = Kriteria::count();
        $totalRekomendasi = HasilKeputusan::count(); // Menghitung total rekomendasi yang telah dihasilkan
        return view('admin.dashboard', compact('totalUsers', 'totalMakanan', 'totalKriteria', 'totalRekomendasi'));
    }
}
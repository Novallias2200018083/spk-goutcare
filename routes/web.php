<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\MakananController;
use App\Http\Controllers\Admin\KriteriaController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\SkalaKriteriaController;
use App\Http\Controllers\Admin\BobotGapController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Pasien\PasienDashboardController;
use App\Http\Controllers\Pasien\ProfilKesehatanController;
use App\Http\Controllers\Pasien\RiwayatRekomendasiController;
use App\Http\Controllers\Pasien\MakananPribadiController;
use App\Http\Controllers\Pasien\RekomendasiController;
use App\Http\Controllers\Admin\LaporanController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Rute Halaman Depan
Route::get('/', function () {
    return view('welcome');
});

// Grup Rute yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    // Rute Profil Pengguna (umum untuk semua role)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Group Route untuk Pasien
    Route::prefix('pasien')->name('pasien.')->middleware(['auth', 'role:pasien'])->group(function () {
        
        // Route Dashboard Pasien
        Route::get('/dashboard', [PasienDashboardController::class, 'index'])->name('dashboard');
        
        // Route Profil Kesehatan & Kalkulator BMR
        Route::get('/profil', [ProfilKesehatanController::class, 'index'])->name('profil.index');
        Route::post('/profil', [ProfilKesehatanController::class, 'store'])->name('profil.store');
        Route::get('/profil/summary', [ProfilKesehatanController::class, 'show'])->name('profil.show');

        // Route Makanan Pribadi
        Route::resource('makanan_pribadi', MakananPribadiController::class)->except(['show']);

        // Route Jelajahi Menu (Sistem)
        Route::get('/menu', [App\Http\Controllers\Pasien\MakananSistemController::class, 'index'])->name('menu.index');

        // Route Riwayat Rekomendasi
        Route::get('/riwayat', [RiwayatRekomendasiController::class, 'index'])->name('riwayat.index');
        Route::get('/riwayat/{id}', [RiwayatRekomendasiController::class, 'show'])->name('riwayat.show');

        // Route Rekomendasi (Engine Profile Matching)
        Route::get('/rekomendasi', [RekomendasiController::class, 'index'])->name('rekomendasi.index');
        Route::post('/rekomendasi/hitung', [RekomendasiController::class, 'hitung'])->name('rekomendasi.hitung');

    });



    // Group Route untuk Admin
    Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
        
        // Route Dashboard Admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Route CRUD Pengguna (Pasien)
        Route::resource('pengguna', PenggunaController::class);


        Route::resource('makanan', MakananController::class);
        Route::resource('kriteria', KriteriaController::class);

        // Custom names untuk resource agar URL dan name route lebih rapi
        Route::resource('skala', SkalaKriteriaController::class)->parameters(['skala' => 'id']);
        Route::resource('bobot', BobotGapController::class)->parameters(['bobot' => 'id']);
        
        // Route khusus Pengaturan karena tidak pakai pola resource penuh
        Route::get('pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
        Route::post('pengaturan/update', [PengaturanController::class, 'update'])->name('pengaturan.update');

        // Route Laporan Rekomendasi
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');
    });

    // --- Redirect setelah login (sebagai fallback atau initial dashboard) ---
    // Jika user mengakses /dashboard, arahkan sesuai rolenya
    Route::get('/dashboard', function () {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif (Auth::user()->role === 'pasien') {
            return redirect()->route('pasien.dashboard');
        }
        // Jika role tidak dikenal atau belum diatur, bisa arahkan ke halaman default
        return redirect('/');
    })->name('dashboard');
});

// Mengimpor rute autentikasi Laravel Breeze (login, register, dll.)
require __DIR__.'/auth.php';

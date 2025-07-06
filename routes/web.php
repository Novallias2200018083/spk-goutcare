<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // Pastikan Auth diimpor untuk redirect setelah login

// Impor semua Controller Admin dengan alias yang jelas
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MakananController as AdminMakananController; // Alias untuk Admin\MakananController
use App\Http\Controllers\Admin\KriteriaController as AdminKriteriaController; // Alias untuk Admin\KriteriaController
use App\Http\Controllers\Admin\UserController as AdminUserController; // Alias untuk Admin\UserController

// Impor semua Controller Pasien
use App\Http\Controllers\Pasien\DashboardController as PasienDashboardController;
use App\Http\Controllers\Pasien\ProfilPasienController;
use App\Http\Controllers\Pasien\UserMakananController; // Pasien\UserMakananController

// Impor Controller Rekomendasi (jika di root namespace Controller)
use App\Http\Controllers\RekomendasiController;


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

    // --- Routes untuk Pasien ---
    Route::middleware(['role:pasien'])->prefix('pasien')->name('pasien.')->group(function () {
        // Dashboard Pasien
        Route::get('/dashboard', [PasienDashboardController::class, 'index'])->name('dashboard');
        
        // Profil Gizi Pasien
        Route::get('/profil', [ProfilPasienController::class, 'show'])->name('profil.show');
        Route::get('/profil/create', [ProfilPasienController::class, 'create'])->name('profil.create');
        Route::post('/profil', [ProfilPasienController::class, 'store'])->name('profil.store');
        Route::get('/profil/edit', [ProfilPasienController::class, 'edit'])->name('profil.edit');
        Route::put('/profil', [ProfilPasienController::class, 'update'])->name('profil.update');

        // Rekomendasi Makanan
        Route::get('/rekomendasi', [RekomendasiController::class, 'index'])->name('rekomendasi.index');
        
        // Riwayat Rekomendasi
        Route::get('/history-rekomendasi', [RekomendasiController::class, 'history'])->name('history');

        Route::delete('/history-rekomendasi/{hasilKeputusan}', [RekomendasiController::class, 'destroy'])->name('history.destroy'); // <-- TAMBAHKAN INI
        Route::get('/history-rekomendasi/{hasilKeputusan}', [RekomendasiController::class, 'show'])->name('history.show');

        // Manajemen Makanan Pribadi oleh Pengguna (Pasien)
        // Menggunakan UserMakananController untuk mengelola Makanan yang diinput user
        Route::resource('user-makanan', UserMakananController::class)->except(['show']); 
    });

    // --- Routes untuk Admin ---
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        // Dashboard Admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        
        // Manajemen Makanan Umum oleh Admin
        Route::resource('makanan', AdminMakananController::class); // Menggunakan alias AdminMakananController
        
        // Manajemen Kriteria oleh Admin
        Route::resource('kriteria', AdminKriteriaController::class); // Menggunakan alias AdminKriteriaController
        
        // Manajemen Pengguna oleh Admin
        Route::resource('users', AdminUserController::class)->except(['show']); // Menggunakan alias AdminUserController
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


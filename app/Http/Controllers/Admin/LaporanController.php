<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RiwayatRekomendasi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    // 1. Menampilkan halaman daftar riwayat seluruh pasien dengan fitur filter
    public function index(Request $request)
    {
        $query = RiwayatRekomendasi::with(['user', 'detailRiwayats.makanan'])->latest();

        // Fitur Filter Berdasarkan Tanggal
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $tanggal_awal = Carbon::parse($request->tanggal_awal)->startOfDay();
            $tanggal_akhir = Carbon::parse($request->tanggal_akhir)->endOfDay();
            
            $query->whereBetween('tanggal_rekomendasi', [$tanggal_awal, $tanggal_akhir]);
        }

        $laporans = $query->get();

        return view('admin.laporan.index', compact('laporans'));
    }

    // 2. Fitur Cetak Laporan (Print / Simpan ke PDF bawaan browser)
    public function cetak(Request $request)
    {
        $query = RiwayatRekomendasi::with(['user', 'detailRiwayats.makanan'])->latest();

        $tanggal_awal = null;
        $tanggal_akhir = null;

        // Terapkan filter yang sama jika Admin mencetak dari hasil filter
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $tanggal_awal = Carbon::parse($request->tanggal_awal)->startOfDay();
            $tanggal_akhir = Carbon::parse($request->tanggal_akhir)->endOfDay();
            
            $query->whereBetween('tanggal_rekomendasi', [$tanggal_awal, $tanggal_akhir]);
        }

        $laporans = $query->get();

        // Kita akan menggunakan view khusus cetak yang bersih dari sidebar/navbar
        return view('admin.laporan.cetak', compact('laporans', 'tanggal_awal', 'tanggal_akhir'));
    }

    public function show($id)
    {
        $riwayat = RiwayatRekomendasi::with(['user.profilPasien', 'detailRiwayats.makanan.nilaiKriterias'])->findOrFail($id);
        
        $profil = $riwayat->user->profilPasien;
        
        // Data Master untuk perhitungan ulang GAP demi display
        $kriterias = \App\Models\Kriteria::all();
        $skalas = \App\Models\SkalaKriteria::all();
        $bobotGaps = \App\Models\BobotGap::all();
        
        // Tentukan Target Skala (Re-calculate based on saved profile)
        $targetSkala = [];
        $tinggiMeter = $profil->tinggi_badan / 100;
        $imt = ($tinggiMeter > 0) ? ($profil->berat_badan / ($tinggiMeter * $tinggiMeter)) : 0;
        
        foreach ($kriterias as $k) {
            $kName = strtolower($k->nama_kriteria);
            $skala = 3;
            if (str_contains($kName, 'purin')) {
                $skala = (strtolower($profil->fase_asam_urat) == 'akut') ? 4 : 3;
            } elseif (str_contains($kName, 'kalori')) {
                if ($imt < 18.5) $skala = 2;
                elseif ($imt >= 25) $skala = 4;
                else $skala = 3;
            } elseif (str_contains($kName, 'lemak')) {
                $skala = ($imt >= 25) ? 4 : 3;
            } elseif (str_contains($kName, 'protein')) {
                $skala = 3;
            } elseif (str_contains($kName, 'karbohidrat')) {
                $skala = 3;
            }
            $targetSkala[$k->id] = $skala;
        }

        return view('admin.laporan.show', compact('riwayat', 'profil', 'kriterias', 'skalas', 'bobotGaps', 'targetSkala', 'imt'));
    }
}
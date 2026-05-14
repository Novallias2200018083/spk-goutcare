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
}
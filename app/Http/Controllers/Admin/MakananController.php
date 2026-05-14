<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Makanan;
use App\Models\Kriteria;
use App\Models\NilaiKriteriaMakanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MakananController extends Controller
{
    // 1. Menampilkan daftar makanan (Hanya yang bukan inputan user/pasien)
    public function index()
    {
        $makanans = Makanan::where('is_user_input', false)
            ->with('nilaiKriterias.kriteria') // Load relasi agar efisien
            ->latest()
            ->get();
        return view('admin.makanan.index', compact('makanans'));
    }

    // 2. Menampilkan form tambah makanan
    public function create()
    {
        // Ambil semua kriteria untuk di-looping di form input (Purin, Kalori, dll)
        $kriterias = Kriteria::all();
        return view('admin.makanan.create', compact('kriterias'));
    }

    // 3. Menyimpan data makanan dan nilai gizinya
    public function store(Request $request)
    {
        $request->validate([
            'nama_makanan' => 'required|string|max:255',
            'deskripsi'    => 'nullable|string',
            'nilai'        => 'required|array', // Input nilai gizi berupa array berdasar ID kriteria
        ]);

        // Gunakan transaction agar jika ada error, data dibatalkan (rollback) semua
        DB::beginTransaction();
        try {
            // Simpan ke tabel makanans
            $makanan = Makanan::create([
                'nama_makanan'  => $request->nama_makanan,
                'deskripsi'     => $request->deskripsi,
                'is_user_input' => false,
                'user_id'       => null, // Null karena ini milik sistem (Admin)
            ]);

            // Simpan ke tabel nilai_kriteria_makanans
            foreach ($request->nilai as $kriteria_id => $nilai) {
                NilaiKriteriaMakanan::create([
                    'makanan_id'  => $makanan->id,
                    'kriteria_id' => $kriteria_id,
                    'nilai'       => $nilai,
                ]);
            }

            DB::commit();
            return redirect()->route('admin.makanan.index')->with('success', 'Makanan dan nilai gizi berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // 4. Menampilkan form edit makanan
    public function edit($id)
    {
        $makanan = Makanan::with('nilaiKriterias')->findOrFail($id);
        $kriterias = Kriteria::all();
        return view('admin.makanan.edit', compact('makanan', 'kriterias'));
    }

    // 5. Memperbarui data makanan dan nilai gizinya
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_makanan' => 'required|string|max:255',
            'deskripsi'    => 'nullable|string',
            'nilai'        => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            $makanan = Makanan::findOrFail($id);
            $makanan->update([
                'nama_makanan' => $request->nama_makanan,
                'deskripsi'    => $request->deskripsi,
            ]);

            // Update nilai gizi (Hapus yang lama, insert yang baru agar bersih)
            $makanan->nilaiKriterias()->delete();
            foreach ($request->nilai as $kriteria_id => $nilai) {
                NilaiKriteriaMakanan::create([
                    'makanan_id'  => $makanan->id,
                    'kriteria_id' => $kriteria_id,
                    'nilai'       => $nilai,
                ]);
            }

            DB::commit();
            return redirect()->route('admin.makanan.index')->with('success', 'Data makanan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // 6. Menghapus makanan
    public function destroy($id)
    {
        $makanan = Makanan::findOrFail($id);
        $makanan->delete(); // Otomatis menghapus nilaiKriteria karena ada foreign key 'on delete cascade' di DB-mu
        
        return redirect()->route('admin.makanan.index')->with('success', 'Makanan berhasil dihapus.');
    }
}
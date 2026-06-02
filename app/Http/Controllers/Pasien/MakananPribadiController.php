<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Makanan;
use App\Models\Kriteria;
use App\Models\NilaiKriteriaMakanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MakananPribadiController extends Controller
{
    // 1. Menampilkan daftar makanan khusus milik user yang sedang login
    public function index()
    {
        $makanans = Auth::user()->makananCustom()->with('nilaiKriterias.kriteria')->latest()->paginate(10);
        return view('pasien.makanan_pribadi.index', compact('makanans'));
    }

    // 2. Form tambah makanan pribadi
    public function create()
    {
        $kriterias = Kriteria::all();
        return view('pasien.makanan_pribadi.create', compact('kriterias'));
    }

    // 3. Menyimpan makanan pribadi
    public function store(Request $request)
    {
        $request->validate([
            'nama_makanan' => 'required|string|max:255',
            'deskripsi'    => 'nullable|string',
            'nilai'        => 'required|array', // Nilai gizi (purin, kalori, dll)
        ]);

        DB::beginTransaction();
        try {
            // Simpan ke tabel makanans dengan is_user_input = true dan user_id = id pasien
            $makanan = Makanan::create([
                'nama_makanan'  => $request->nama_makanan,
                'deskripsi'     => $request->deskripsi,
                'is_user_input' => true,
                'user_id'       => Auth::id(),
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
            return redirect()->route('pasien.makanan_pribadi.index')->with('success', 'Makanan pribadi berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // 4. Form edit makanan pribadi
    public function edit($id)
    {
        $makanan = Makanan::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $kriterias = Kriteria::all();
        $makananNilai = $makanan->nilaiKriterias->pluck('nilai', 'kriteria_id')->toArray();

        return view('pasien.makanan_pribadi.edit', compact('makanan', 'kriterias', 'makananNilai'));
    }

    // 5. Update makanan pribadi
    public function update(Request $request, $id)
    {
        $makanan = Makanan::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'nama_makanan' => 'required|string|max:255',
            'deskripsi'    => 'nullable|string',
            'nilai'        => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            $makanan->update([
                'nama_makanan' => $request->nama_makanan,
                'deskripsi'    => $request->deskripsi,
            ]);

            // Update nilai kriteria
            foreach ($request->nilai as $kriteria_id => $nilai) {
                NilaiKriteriaMakanan::updateOrCreate(
                    ['makanan_id' => $makanan->id, 'kriteria_id' => $kriteria_id],
                    ['nilai' => $nilai]
                );
            }

            DB::commit();
            return redirect()->route('pasien.makanan_pribadi.index')->with('success', 'Makanan pribadi berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // 6. Menghapus makanan pribadi
    public function destroy($id)
    {
        // Pastikan hanya bisa menghapus makanannya sendiri
        $makanan = Makanan::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $makanan->delete(); 
        
        return redirect()->route('pasien.makanan_pribadi.index')->with('success', 'Makanan pribadi berhasil dihapus.');
    }
}
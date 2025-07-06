<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Makanan; // Pastikan model Makanan diimpor
use App\Models\Kriteria; // Pastikan model Kriteria diimpor
use App\Models\NilaiKriteriaMakanan; // Pastikan model NilaiKriteriaMakanan diimpor
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Diperlukan untuk Rule::unique
use Illuminate\Validation\ValidationException; // Diperlukan untuk menangani error validasi

class MakananController extends Controller
{
    /**
     * Menampilkan daftar makanan umum (yang diinput oleh admin).
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Hanya ambil makanan yang diinput admin (is_user_input = false)
        // Eager load relasi nilaiKriteria dan kriteria di dalamnya
        $makanans = Makanan::where('is_user_input', false)
                           ->with('nilaiKriteria.kriteria')
                           ->paginate(10);

        // Ambil semua kriteria untuk ditampilkan di header tabel (jika diperlukan untuk views)
        $kriterias = Kriteria::all(); 
        
        return view('admin.makanan.index', compact('makanans', 'kriterias'));
    }

    /**
     * Menampilkan form untuk membuat makanan umum baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $kriterias = Kriteria::all();
        return view('admin.makanan.create', compact('kriterias'));
    }

    /**
     * Menyimpan makanan umum baru ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_makanan' => [
                'required',
                'string',
                'max:255',
                // Pastikan nama makanan unik hanya untuk makanan yang diinput admin
                Rule::unique('makanans')->where(function ($query) {
                    return $query->where('is_user_input', false);
                }),
            ],
            'deskripsi' => 'nullable|string',
            'nilai_kriteria' => 'required|array',
            'nilai_kriteria.*' => 'required|numeric|min:0', // Validasi setiap nilai kriteria
        ]);

        try {
            // Buat entri makanan baru dengan menandainya sebagai input admin
            $makanan = Makanan::create([
                'nama_makanan' => $request->nama_makanan,
                'deskripsi' => $request->deskripsi,
                'is_user_input' => false, // Set sebagai makanan umum/admin
                'user_id' => null, // Tidak ada user pemilik spesifik
            ]);

            // Simpan nilai-nilai kriteria terkait makanan ini
            foreach ($request->nilai_kriteria as $kriteriaId => $nilai) {
                NilaiKriteriaMakanan::create([
                    'makanan_id' => $makanan->id,
                    'kriteria_id' => $kriteriaId,
                    'nilai' => $nilai,
                ]);
            }

            return redirect()->route('admin.makanan.index')->with('success', 'Makanan umum berhasil ditambahkan.');
        } catch (ValidationException $e) {
            // Tangani error validasi
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Tangani error umum lainnya
            return back()->with('error', 'Gagal menambahkan makanan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menampilkan form untuk mengedit makanan umum yang ada.
     *
     * @param  \App\Models\Makanan  $makanan
     * @return \Illuminate\View\View
     */
    public function edit(Makanan $makanan)
    {
        // Pastikan hanya makanan umum (bukan input user) yang bisa diedit melalui panel admin
        if ($makanan->is_user_input) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit makanan pribadi melalui panel admin.');
        }

        // Muat relasi nilaiKriteria dan kriteria terkait
        $makanan->load('nilaiKriteria.kriteria');
        $kriterias = Kriteria::all();
        
        // Siapkan array nilai kriteria yang ada untuk mengisi form
        $makananNilai = $makanan->nilaiKriteria->pluck('nilai', 'kriteria_id')->toArray();

        return view('admin.makanan.edit', compact('makanan', 'kriterias', 'makananNilai'));
    }

    /**
     * Memperbarui makanan umum yang ada di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Makanan  $makanan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Makanan $makanan)
    {
        // Pastikan hanya makanan umum yang bisa diupdate
        if ($makanan->is_user_input) {
            abort(403, 'Anda tidak memiliki akses untuk mengupdate makanan pribadi melalui panel admin.');
        }

        $request->validate([
            'nama_makanan' => [
                'required',
                'string',
                'max:255',
                // Pastikan nama makanan unik di antara makanan umum lainnya, kecuali makanan yang sedang diedit
                Rule::unique('makanans')->where(function ($query) {
                    return $query->where('is_user_input', false);
                })->ignore($makanan->id),
            ],
            'deskripsi' => 'nullable|string',
            'nilai_kriteria' => 'required|array',
            'nilai_kriteria.*' => 'required|numeric|min:0',
        ]);

        try {
            // Perbarui data dasar makanan
            $makanan->update([
                'nama_makanan' => $request->nama_makanan,
                'deskripsi' => $request->deskripsi,
            ]);

            // Perbarui nilai-nilai kriteria.
            // Metode updateOrCreate lebih efisien: jika ada, update; jika tidak, buat.
            foreach ($request->nilai_kriteria as $kriteriaId => $nilai) {
                NilaiKriteriaMakanan::updateOrCreate(
                    ['makanan_id' => $makanan->id, 'kriteria_id' => $kriteriaId],
                    ['nilai' => $nilai]
                );
            }

            return redirect()->route('admin.makanan.index')->with('success', 'Makanan umum berhasil diperbarui.');
        } catch (ValidationException $e) {
            // Tangani error validasi
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Tangani error umum lainnya
            return back()->with('error', 'Gagal memperbarui makanan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menghapus makanan umum dari database.
     *
     * @param  \App\Models\Makanan  $makanan
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Makanan $makanan)
    {
        // Pastikan hanya makanan umum yang bisa dihapus
        if ($makanan->is_user_input) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus makanan pribadi melalui panel admin.');
        }

        try {
            // Laravel akan otomatis menghapus NilaiKriteriaMakanan terkait karena onDelete('cascade') di migrasi
            $makanan->delete(); 
            return redirect()->route('admin.makanan.index')->with('success', 'Makanan umum berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus makanan: ' . $e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Makanan; // Menggunakan model Makanan karena makanan pribadi disimpan di tabel ini
use App\Models\Kriteria; // Untuk mengambil daftar kriteria
use App\Models\NilaiKriteriaMakanan; // Untuk mengelola nilai kriteria makanan
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan user yang sedang login
use Illuminate\Validation\Rule; // Diperlukan untuk validasi Rule::unique
use Illuminate\Validation\ValidationException; // Untuk menangani error validasi
use Illuminate\Support\Facades\Log; // Untuk logging, jika diperlukan
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException; // Digunakan untuk error 404 eksplisit

class UserMakananController extends Controller
{
    /**
     * Menampilkan daftar makanan pribadi yang diinput oleh user yang sedang login.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Hanya tampilkan makanan yang diinput oleh user yang sedang login,
        // dan pastikan itu adalah makanan pribadi (is_user_input = true).
        // Relasi `makanans()` di model User sudah memiliki scope `where('is_user_input', true)`.
        $userMakanans = Auth::user()->makanans()->with('nilaiKriteria.kriteria')->paginate(10);
        
        // Ambil semua kriteria untuk ditampilkan di header tabel di view
        $kriterias = Kriteria::all(); 

        return view('pasien.user_makanan.index', compact('userMakanans', 'kriterias'));
    }

    /**
     * Menampilkan form untuk membuat makanan pribadi baru.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $kriterias = Kriteria::all();
        return view('pasien.user_makanan.create', compact('kriterias'));
    }

    /**
     * Menyimpan makanan pribadi baru ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Aturan validasi untuk data makanan pribadi
        $request->validate([
            'nama_makanan' => [
                'required',
                'string',
                'max:255',
                // Pastikan nama makanan unik per user untuk makanan pribadi mereka
                Rule::unique('makanans')->where(function ($query) {
                    return $query->where('user_id', Auth::id())
                                 ->where('is_user_input', true);
                }),
            ],
            'deskripsi' => 'nullable|string',
            'nilai_kriteria' => 'required|array', // Pastikan ini adalah array
            'nilai_kriteria.*' => 'required|numeric|min:0', // Setiap nilai kriteria harus diisi, numerik, dan tidak negatif
        ], [
            // Pesan error kustom
            'nama_makanan.required' => 'Nama makanan wajib diisi.',
            'nama_makanan.unique' => 'Anda sudah memiliki makanan pribadi dengan nama ini.',
            'nilai_kriteria.*.required' => 'Nilai kriteria wajib diisi.',
            'nilai_kriteria.*.numeric' => 'Nilai kriteria harus berupa angka.',
            'nilai_kriteria.*.min' => 'Nilai kriteria tidak boleh negatif.',
        ]);

        try {
            // Buat entri makanan baru dan tandai sebagai input user
            $makanan = Makanan::create([
                'nama_makanan' => $request->nama_makanan,
                'deskripsi' => $request->deskripsi,
                'is_user_input' => true, // Tandai sebagai input pengguna
                'user_id' => Auth::id(), // Simpan ID pengguna yang menginput
            ]);

            // Simpan nilai-nilai kriteria terkait makanan ini
            foreach ($request->nilai_kriteria as $kriteriaId => $nilai) {
                NilaiKriteriaMakanan::create([
                    'makanan_id' => $makanan->id,
                    'kriteria_id' => $kriteriaId,
                    'nilai' => $nilai,
                ]);
            }

            return redirect()->route('pasien.user-makanan.index')->with('success', 'Makanan pribadi Anda berhasil ditambahkan.');
        } catch (ValidationException $e) {
            // Tangani error validasi
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Tangani error umum lainnya
            return back()->with('error', 'Gagal menambahkan makanan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menampilkan form untuk mengedit makanan pribadi yang ada.
     *
     * @param  \App\Models\Makanan  $user_makanan  Objek makanan yang akan diedit.
     * @return \Illuminate\View\View
     */
    public function edit(Makanan $user_makanan)
    {
        // Jika model binding gagal dan $user_makanan adalah null, Laravel seharusnya melempar 404 secara otomatis.
        // Namun, jika ada konfigurasi yang menekan ini atau masalah unik, kita bisa menambahkan pengecekan manual.
        if (is_null($user_makanan)) {
            Log::error("Makanan not found in UserMakananController@edit for ID: " . request()->route('user_makanan'));
            throw new NotFoundHttpException('Makanan tidak ditemukan atau tidak valid.');
        }

        // Pastikan user hanya bisa mengedit makanannya sendiri DAN itu adalah makanan pribadi (bukan makanan umum)
        if ($user_makanan->user_id !== Auth::id() || !$user_makanan->is_user_input) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit makanan ini.'); // Forbidden
        }

        // Muat relasi nilaiKriteria dan kriteria terkait untuk mengisi form
        $user_makanan->load('nilaiKriteria.kriteria');
        $kriterias = Kriteria::all();
        
        // Siapkan array nilai kriteria yang ada untuk mengisi form
        $makananNilai = $user_makanan->nilaiKriteria->pluck('nilai', 'kriteria_id')->toArray();

        return view('pasien.user_makanan.edit', compact('user_makanan', 'kriterias', 'makananNilai'));
    }

    /**
     * Memperbarui makanan pribadi yang ada di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Makanan  $user_makanan Objek makanan yang akan diperbarui.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Makanan $user_makanan)
    {
        // Jika model binding gagal dan $user_makanan adalah null, Laravel seharusnya melempar 404 secara otomatis.
        if (is_null($user_makanan)) {
            Log::error("Makanan not found in UserMakananController@update for ID: " . request()->route('user_makanan'));
            throw new NotFoundHttpException('Makanan tidak ditemukan atau tidak valid.');
        }

        // Pastikan user hanya bisa mengupdate makanannya sendiri DAN itu adalah makanan pribadi
        if ($user_makanan->user_id !== Auth::id() || !$user_makanan->is_user_input) {
            abort(403, 'Anda tidak memiliki akses untuk memperbarui makanan ini.'); // Forbidden
        }

        // Aturan validasi untuk data makanan pribadi saat update
        $request->validate([
            'nama_makanan' => [
                'required',
                'string',
                'max:255',
                // Pastikan nama makanan unik per user untuk makanan pribadi mereka, kecuali makanan yang sedang diedit
                Rule::unique('makanans')->where(function ($query) {
                    return $query->where('user_id', Auth::id())
                                 ->where('is_user_input', true);
                })->ignore($user_makanan->id),
            ],
            'deskripsi' => 'nullable|string',
            'nilai_kriteria' => 'required|array',
            'nilai_kriteria.*' => 'required|numeric|min:0',
        ], [
            // Pesan error kustom
            'nama_makanan.required' => 'Nama makanan wajib diisi.',
            'nama_makanan.unique' => 'Anda sudah memiliki makanan pribadi dengan nama ini.',
            'nilai_kriteria.*.required' => 'Nilai kriteria wajib diisi.',
            'nilai_kriteria.*.numeric' => 'Nilai kriteria harus berupa angka.',
            'nilai_kriteria.*.min' => 'Nilai kriteria tidak boleh negatif.',
        ]);

        try {
            // Perbarui data dasar makanan
            $user_makanan->update([
                'nama_makanan' => $request->nama_makanan,
                'deskripsi' => $request->deskripsi,
                // is_user_input dan user_id tidak perlu diubah karena sudah set saat create
            ]);

            // Perbarui nilai-nilai kriteria.
            // Gunakan `updateOrCreate` untuk efisiensi: jika ada, update; jika tidak, buat.
            foreach ($request->nilai_kriteria as $kriteriaId => $nilai) {
                NilaiKriteriaMakanan::updateOrCreate(
                    ['makanan_id' => $user_makanan->id, 'kriteria_id' => $kriteriaId],
                    ['nilai' => $nilai]
                );
            }

            return redirect()->route('pasien.user-makanan.index')->with('success', 'Makanan pribadi Anda berhasil diperbarui.');
        } catch (ValidationException $e) {
            // Tangani error validasi
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Tangani error umum lainnya
            return back()->with('error', 'Gagal memperbarui makanan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menghapus makanan pribadi dari database.
     *
     * @param  \App\Models\Makanan  $user_makanan Objek makanan yang akan dihapus.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Makanan $user_makanan)
    {
        // Jika model binding gagal dan $user_makanan adalah null, Laravel seharusnya melempar 404 secara otomatis.
        if (is_null($user_makanan)) {
            Log::error("Makanan not found in UserMakananController@destroy for ID: " . request()->route('user_makanan'));
            throw new NotFoundHttpException('Makanan tidak ditemukan atau tidak valid.');
        }

        // Pastikan user hanya bisa menghapus makanannya sendiri DAN itu adalah makanan pribadi
        if ($user_makanan->user_id !== Auth::id() || !$user_makanan->is_user_input) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus makanan ini.'); // Forbidden
        }

        try {
            // Laravel akan otomatis menghapus NilaiKriteriaMakanan terkait karena onDelete('cascade') di migrasi
            $user_makanan->delete();
            return redirect()->route('pasien.user-makanan.index')->with('success', 'Makanan pribadi Anda berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus makanan: ' . $e->getMessage());
        }
    }
}

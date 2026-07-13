<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ProfilPasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PenggunaController extends Controller
{
    // 1. Menampilkan daftar pengguna (pasien)
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $penggunas = User::where('role', 'pasien')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)->withQueryString();
            
        return view('admin.pengguna.index', compact('penggunas', 'search'));
    }

    // 2. Menampilkan form tambah pengguna baru
    public function create()
    {
        return view('admin.pengguna.create');
    }

    // 3. Menyimpan data pengguna baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            // Validasi Profil
            'metode_input' => 'nullable|in:manual,otomatis',
            'jenis_kelamin' => 'nullable|required_if:metode_input,otomatis|in:L,P',
            'umur' => 'nullable|required_if:metode_input,otomatis|numeric|min:10',
            'berat_badan' => 'nullable|required_if:metode_input,otomatis|numeric|min:20',
            'tinggi_badan' => 'nullable|required_if:metode_input,otomatis|numeric|min:100',
            'tingkat_aktivitas' => 'nullable|required_if:metode_input,otomatis|in:rendah,sedang,tinggi',
            'fase_asam_urat' => 'nullable|required_if:metode_input,otomatis|in:akut,normal',
            'kebutuhan_kalori' => 'nullable|required_if:metode_input,manual|numeric|min:0',
            'kebutuhan_protein' => 'nullable|required_if:metode_input,manual|numeric|min:0',
            'kebutuhan_lemak' => 'nullable|required_if:metode_input,manual|numeric|min:0',
            'kebutuhan_karbohidrat' => 'nullable|required_if:metode_input,manual|numeric|min:0',
            'toleransi_purin' => 'nullable|required_if:metode_input,manual|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'pasien', // Otomatis diset sebagai pasien
            ]);

            // Jika admin mengisi form profil
            if ($request->has('metode_input') && $request->metode_input) {
                $this->saveProfile($request, $user->id);
            }
            
            DB::commit();
            return redirect()->route('admin.pengguna.index')->with('success', 'Akun pengguna berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // 4. Menampilkan form edit pengguna
    public function edit($id)
    {
        $pengguna = User::with('profilPasien')->findOrFail($id);
        return view('admin.pengguna.edit', compact('pengguna'));
    }

    // 5. Memperbarui data pengguna
    public function update(Request $request, $id)
    {
        $pengguna = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $pengguna->id,
            'password' => 'nullable|string|min:8|confirmed', // Password opsional saat diedit
            // Validasi Profil
            'metode_input' => 'nullable|in:manual,otomatis',
            'jenis_kelamin' => 'nullable|required_if:metode_input,otomatis|in:L,P',
            'umur' => 'nullable|required_if:metode_input,otomatis|numeric|min:10',
            'berat_badan' => 'nullable|required_if:metode_input,otomatis|numeric|min:20',
            'tinggi_badan' => 'nullable|required_if:metode_input,otomatis|numeric|min:100',
            'tingkat_aktivitas' => 'nullable|required_if:metode_input,otomatis|in:rendah,sedang,tinggi',
            'fase_asam_urat' => 'nullable|required_if:metode_input,otomatis|in:akut,normal',
            'kebutuhan_kalori' => 'nullable|required_if:metode_input,manual|numeric|min:0',
            'kebutuhan_protein' => 'nullable|required_if:metode_input,manual|numeric|min:0',
            'kebutuhan_lemak' => 'nullable|required_if:metode_input,manual|numeric|min:0',
            'kebutuhan_karbohidrat' => 'nullable|required_if:metode_input,manual|numeric|min:0',
            'toleransi_purin' => 'nullable|required_if:metode_input,manual|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $pengguna->name = $request->name;
            $pengguna->email = $request->email;
            
            // Update password hanya jika diisi
            if ($request->filled('password')) {
                $pengguna->password = Hash::make($request->password);
            }

            $pengguna->save();

            // Jika admin mengisi form profil
            if ($request->has('metode_input') && $request->metode_input) {
                $this->saveProfile($request, $pengguna->id);
            }

            DB::commit();
            return redirect()->route('admin.pengguna.index')->with('success', 'Data pengguna berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // 6. Menghapus data pengguna
    public function destroy($id)
    {
        $pengguna = User::findOrFail($id);
        $pengguna->delete();

        return redirect()->route('admin.pengguna.index')
                         ->with('success', 'Akun pengguna berhasil dihapus.');
    }

    // Fungsi helper untuk menyimpan/update profil
    private function saveProfile(Request $request, $userId)
    {
        $data = $request->only('metode_input', 'catatan_tambahan');
        $data['user_id'] = $userId;

        if ($request->metode_input == 'otomatis') {
            // Hitung BMR
            $bmr = 0;
            if ($request->jenis_kelamin == 'L') {
                $bmr = (10 * $request->berat_badan) + (6.25 * $request->tinggi_badan) - (5 * $request->umur) + 5;
            } else {
                $bmr = (10 * $request->berat_badan) + (6.25 * $request->tinggi_badan) - (5 * $request->umur) - 161;
            }

            // Pengali Aktivitas
            $multiplier = 1.2;
            if ($request->tingkat_aktivitas == 'sedang') $multiplier = 1.55;
            if ($request->tingkat_aktivitas == 'tinggi') $multiplier = 1.725;

            // Kebutuhan Kalori
            $kebutuhan_kalori = round($bmr * $multiplier);

            // Makronutrien
            $kebutuhan_protein = round($request->berat_badan * 1);
            $kebutuhan_lemak = round(($kebutuhan_kalori * 0.15) / 9);
            
            $kalori_protein = $kebutuhan_protein * 4;
            $kalori_lemak = $kebutuhan_lemak * 9;
            $kebutuhan_karbohidrat = round(($kebutuhan_kalori - $kalori_protein - $kalori_lemak) / 4);

            $toleransi_purin = ($request->fase_asam_urat == 'akut') ? 100 : 150;

            $data = array_merge($data, [
                'jenis_kelamin' => $request->jenis_kelamin,
                'umur' => $request->umur,
                'berat_badan' => $request->berat_badan,
                'tinggi_badan' => $request->tinggi_badan,
                'tingkat_aktivitas' => $request->tingkat_aktivitas,
                'fase_asam_urat' => $request->fase_asam_urat,
                'kebutuhan_kalori' => $kebutuhan_kalori,
                'kebutuhan_protein' => $kebutuhan_protein,
                'kebutuhan_lemak' => $kebutuhan_lemak,
                'kebutuhan_karbohidrat' => $kebutuhan_karbohidrat,
                'toleransi_purin' => $toleransi_purin,
            ]);
        } else {
            // Manual
            $data = array_merge($data, [
                'jenis_kelamin' => null, 'umur' => null, 'berat_badan' => null,
                'tinggi_badan' => null, 'tingkat_aktivitas' => null, 'fase_asam_urat' => null,
                'kebutuhan_kalori' => $request->kebutuhan_kalori,
                'kebutuhan_protein' => $request->kebutuhan_protein,
                'kebutuhan_lemak' => $request->kebutuhan_lemak,
                'kebutuhan_karbohidrat' => $request->kebutuhan_karbohidrat,
                'toleransi_purin' => $request->toleransi_purin,
            ]);
        }

        ProfilPasien::updateOrCreate(
            ['user_id' => $userId],
            $data
        );
    }
}
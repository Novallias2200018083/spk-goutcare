<?php
namespace App\Http\Controllers\Pasien;
use App\Http\Controllers\Controller;
use App\Models\ProfilPasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilPasienController extends Controller
{
    public function show()
    {
        $profil = Auth::user()->profilPasien;
        return view('pasien.profil.show', compact('profil'));
    }

    public function create()
    {
        return view('pasien.profil.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kebutuhan_kalori' => 'nullable|numeric|min:0',
            'kebutuhan_protein' => 'nullable|numeric|min:0',
            'kebutuhan_lemak' => 'nullable|numeric|min:0',
            'toleransi_purin' => 'nullable|numeric|min:0',
            'catatan_tambahan' => 'nullable|string',
        ]);

        Auth::user()->profilPasien()->create($request->all());

        return redirect()->route('pasien.profil.show')->with('success', 'Profil Anda berhasil disimpan.');
    }

    public function edit()
    {
        $profil = Auth::user()->profilPasien;
        if (!$profil) {
            return redirect()->route('pasien.profil.create')->with('info', 'Anda belum mengisi profil. Silakan isi terlebih dahulu.');
        }
        return view('pasien.profil.edit', compact('profil'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'kebutuhan_kalori' => 'nullable|numeric|min:0',
            'kebutuhan_protein' => 'nullable|numeric|min:0',
            'kebutuhan_lemak' => 'nullable|numeric|min:0',
            'toleransi_purin' => 'nullable|numeric|min:0',
            'catatan_tambahan' => 'nullable|string',
        ]);

        Auth::user()->profilPasien->update($request->all());

        return redirect()->route('pasien.profil.show')->with('success', 'Profil Anda berhasil diperbarui.');
    }
}
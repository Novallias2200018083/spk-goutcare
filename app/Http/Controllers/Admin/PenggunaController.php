<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    // 1. Menampilkan daftar pengguna (pasien)
    public function index()
    {
        $penggunas = User::where('role', 'pasien')->latest()->get();
        return view('admin.pengguna.index', compact('penggunas'));
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
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pasien', // Otomatis diset sebagai pasien
        ]);

        return redirect()->route('admin.pengguna.index')
                         ->with('success', 'Akun pengguna berhasil ditambahkan.');
    }

    // 4. Menampilkan form edit pengguna
    public function edit($id)
    {
        $pengguna = User::findOrFail($id);
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
        ]);

        $pengguna->name = $request->name;
        $pengguna->email = $request->email;
        
        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $pengguna->password = Hash::make($request->password);
        }

        $pengguna->save();

        return redirect()->route('admin.pengguna.index')
                         ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    // 6. Menghapus data pengguna
    public function destroy($id)
    {
        $pengguna = User::findOrFail($id);
        $pengguna->delete();

        return redirect()->route('admin.pengguna.index')
                         ->with('success', 'Akun pengguna berhasil dihapus.');
    }
}
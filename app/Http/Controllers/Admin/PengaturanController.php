<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaturan;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function index()
    {
        // Menampilkan semua pengaturan di satu halaman form
        $pengaturans = Pengaturan::all();
        return view('admin.pengaturan.index', compact('pengaturans'));
    }

    public function update(Request $request)
    {
        // Validasi array inputan
        $request->validate([
            'pengaturan' => 'required|array',
            'pengaturan.*.nilai' => 'required|numeric', 
        ]);

        // Looping untuk update masing-masing nilai pengaturan
        foreach ($request->pengaturan as $id => $data) {
            $pengaturan = Pengaturan::findOrFail($id);
            $pengaturan->update([
                'nilai' => $data['nilai']
            ]);
        }

        return redirect()->route('admin.pengaturan.index')->with('success', 'Pengaturan sistem berhasil diperbarui.');
    }
}
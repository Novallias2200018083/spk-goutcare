<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SkalaKriteria;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class SkalaKriteriaController extends Controller
{
    public function index()
    {
        // Mengambil data skala dan memuat relasi kriteria agar nama kriterianya bisa ditampilkan
        $skalas = SkalaKriteria::with('kriteria')->orderBy('kriteria_id')->orderBy('nilai_skala', 'desc')->get();
        return view('admin.skala_kriteria.index', compact('skalas'));
    }

    public function create()
    {
        $kriterias = Kriteria::all();
        return view('admin.skala_kriteria.create', compact('kriterias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kriteria_id' => 'required|exists:kriterias,id',
            'batas_bawah' => 'required|numeric',
            'batas_atas'  => 'required|numeric|gte:batas_bawah', // batas atas harus >= batas bawah
            'nilai_skala' => 'required|integer|min:1|max:5',
            'keterangan'  => 'nullable|string|max:255',
        ]);

        SkalaKriteria::create($request->all());

        return redirect()->route('admin.skala.index')->with('success', 'Skala kriteria berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $skala = SkalaKriteria::findOrFail($id);
        $kriterias = Kriteria::all();
        return view('admin.skala_kriteria.edit', compact('skala', 'kriterias'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kriteria_id' => 'required|exists:kriterias,id',
            'batas_bawah' => 'required|numeric',
            'batas_atas'  => 'required|numeric|gte:batas_bawah',
            'nilai_skala' => 'required|integer|min:1|max:5',
            'keterangan'  => 'nullable|string|max:255',
        ]);

        $skala = SkalaKriteria::findOrFail($id);
        $skala->update($request->all());

        return redirect()->route('admin.skala.index')->with('success', 'Skala kriteria berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $skala = SkalaKriteria::findOrFail($id);
        $skala->delete();

        return redirect()->route('admin.skala.index')->with('success', 'Skala kriteria berhasil dihapus.');
    }
}
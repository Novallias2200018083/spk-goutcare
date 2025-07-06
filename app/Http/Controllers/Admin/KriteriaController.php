<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriterias = Kriteria::paginate(10);
        return view('admin.kriteria.index', compact('kriterias'));
    }

    public function create()
    {
        return view('admin.kriteria.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kriteria' => 'required|string|max:255|unique:kriterias',
            'bobot' => 'required|numeric|min:0|max:1',
            'tipe' => 'required|in:benefit,cost',
        ]);

        Kriteria::create($request->all());

        return redirect()->route('admin.kriteria.index')->with('success', 'Kriteria berhasil ditambahkan.');
    }

    public function edit(Kriteria $kriteria)
    {
        return view('admin.kriteria.edit', compact('kriteria'));
    }

    public function update(Request $request, Kriteria $kriteria)
    {
        $request->validate([
            'nama_kriteria' => 'required|string|max:255|unique:kriterias,nama_kriteria,' . $kriteria->id,
            'bobot' => 'required|numeric|min:0|max:1',
            'tipe' => 'required|in:benefit,cost',
        ]);

        $kriteria->update($request->all());

        return redirect()->route('admin.kriteria.index')->with('success', 'Kriteria berhasil diperbarui.');
    }

    public function destroy(Kriteria $kriteria)
    {
        $kriteria->delete();
        return redirect()->route('admin.kriteria.index')->with('success', 'Kriteria berhasil dihapus.');
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BobotGap;
use Illuminate\Http\Request;

class BobotGapController extends Controller
{
    public function index()
    {
        $bobotGaps = BobotGap::orderBy('selisih_gap', 'desc')->get();
        return view('admin.bobot_gap.index', compact('bobotGaps'));
    }

    public function create()
    {
        return view('admin.bobot_gap.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'selisih_gap' => 'required|numeric|unique:bobot_gaps,selisih_gap',
            'bobot_nilai' => 'required|numeric',
            'keterangan'  => 'nullable|string|max:255',
        ]);

        BobotGap::create($request->all());

        return redirect()->route('admin.bobot.index')->with('success', 'Bobot Gap berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $bobotGap = BobotGap::findOrFail($id);
        return view('admin.bobot_gap.edit', compact('bobotGap'));
    }

    public function update(Request $request, $id)
    {
        $bobotGap = BobotGap::findOrFail($id);

        $request->validate([
            'selisih_gap' => 'required|numeric|unique:bobot_gaps,selisih_gap,' . $bobotGap->id,
            'bobot_nilai' => 'required|numeric',
            'keterangan'  => 'nullable|string|max:255',
        ]);

        $bobotGap->update($request->all());

        return redirect()->route('admin.bobot.index')->with('success', 'Bobot Gap berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $bobotGap = BobotGap::findOrFail($id);
        $bobotGap->delete();

        return redirect()->route('admin.bobot.index')->with('success', 'Bobot Gap berhasil dihapus.');
    }
}
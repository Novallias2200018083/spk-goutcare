<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Makanan;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class MakananSistemController extends Controller
{
    public function index(Request $request)
    {
        $query = Makanan::where('is_user_input', false)->with('nilaiKriterias');

        // Search functionality
        if ($request->has('search')) {
            $query->where('nama_makanan', 'like', '%' . $request->search . '%');
        }

        $makanans = $query->paginate(12);
        $kriterias = Kriteria::all();

        return view('pasien.makanan.index', compact('makanans', 'kriterias'));
    }
}

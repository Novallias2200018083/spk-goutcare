<?php
namespace App\Http\Controllers\Pasien;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pasien.dashboard');
    }
}
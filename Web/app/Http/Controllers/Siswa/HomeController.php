<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fasilitas;

class HomeController extends Controller
{
    public function index()
    {
        $fasilitas = Fasilitas::all();

        return view('home.siswa', compact('fasilitas'));
    }
}
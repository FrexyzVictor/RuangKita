<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fasilitas;
use App\Models\JadwalTersedia;

class HomeController extends Controller
{
    public function index()
    {
        $fasilitas = Fasilitas::all();

        return view('home.siswa', compact('fasilitas'));
    }
    public function fasilitas()
    {
        $fasilitas = Fasilitas::latest()->get();

        return view('siswa.fasilitas', compact('fasilitas'));
    }
    
public function booking()
{
    $fasilitas = Fasilitas::all();

    return view('siswa.booking', compact('fasilitas'));
}
public function jadwal()
{
    $jadwal = JadwalTersedia::with('fasilitas')->get();

    return view('siswa.jadwal', compact('jadwal'));
}



public function createBooking($id)
{
    return view('siswa.create-booking', compact('id'));
}

}


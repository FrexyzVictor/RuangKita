<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;

class BookingController extends Controller
{
    public function index()
    {
        $fasilitas = Fasilitas::all();

        return view('siswa.booking', compact('fasilitas'));
    }

    public function create($id)
    {
        $fasilitas = Fasilitas::findOrFail($id);

        return view('siswa.booking-create', compact('fasilitas'));
    }
}
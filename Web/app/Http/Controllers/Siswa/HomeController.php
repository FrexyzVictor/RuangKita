<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    $fasilitas = DB::table('fasilitas')
        ->where('id', $id)
        ->first();

    return view('siswa.create-booking', compact('id'));
}

public function storeBooking(Request $request)
{
    DB::table('bookings')->insert([

        'id_user' => auth()->id(),

        'id_fasilitas' => $request->id_fasilitas,

        'organisasi' => $request->organisasi,

        'penanggung_jawab' => $request->penanggung_jawab,

        'tujuan' => $request->tujuan,

        'tanggal' => $request->tanggal,

        'jam_mulai' => $request->jam_mulai,

        'jam_selesai' => $request->jam_selesai,

        'status' => 'pending',

        'created_at' => now(),

        'updated_at' => now(),

    ]);

    return redirect()
        ->route('fasilitas')
        ->with('success', 'Booking berhasil diajukan');
}


public function contact()
{
    return view('siswa.contact');
}

}
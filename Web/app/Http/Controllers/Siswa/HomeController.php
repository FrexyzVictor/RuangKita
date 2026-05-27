<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Fasilitas;
use App\Models\KategoriFasilitas;
use App\Models\Booking;
use App\Models\JadwalTersedia;

class HomeController extends Controller
{
    
    
    public function fasilitas(Request $request)
{
    $query = Fasilitas::query();

    // SEARCH
    if ($request->keyword) {

        $query->where('nama_fasilitas', 'like', '%' . $request->keyword . '%');

    }

    // CATEGORY
    if ($request->category) {

        if ($request->category == 'Lapangan') {
            $query->where('id_kategori', 1);
        }

        if ($request->category == 'Ruangan') {
            $query->where('id_kategori', 2);
        }

        if ($request->category == 'Studio') {
            $query->where('id_kategori', 3);
        }

    }

    // KAPASITAS
    if ($request->kapasitas) {

        $query->where('kapasitas', '>=', $request->kapasitas);

    }

    $fasilitas = $query->latest()->get();

    return view('siswa.fasilitas', compact('fasilitas'));
}

    public function index(Request $request)
{
    $query = Fasilitas::query();

    // SEARCH
    if ($request->keyword) {
        $query->where('nama_fasilitas', 'like', '%' . $request->keyword . '%');
    }

    // FILTER KATEGORI
    if ($request->category) {

        if ($request->category == 'Lapangan') {
            $query->where('id_kategori', 1);
        }

        if ($request->category == 'Ruangan') {
            $query->where('id_kategori', 2);
        }

        if ($request->category == 'Studio') {
            $query->where('id_kategori', 3);
        }
    }

   $fasilitas = $query->latest()->take(5)->get();

    return view('home.siswa', compact('fasilitas'));
}


public function bookingSaya()
{
    $bookings = Booking::where('id_user', auth()->id())
        ->with('fasilitas')
        ->latest()
        ->get();

    return view('siswa.booking-saya', compact('bookings'));
}

public function showBooking($id)
{
    $booking = Booking::with('fasilitas')
        ->where('id_booking', $id)
        ->where('id_user', auth()->user()->id_user)
        ->firstOrFail();

    return view('siswa.booking-show', compact('booking'));
}

public function cancelBooking($id)
{
    $booking = Booking::where('id_booking', $id)
        ->where('id_user', auth()->user()->id_user)
        ->firstOrFail();

    if ($booking->status == 'pending') {
        $booking->delete();
    }

    return redirect()->route('booking.saya')
        ->with('success', 'Booking dibatalkan');
}

public function jadwal()
{
    $jadwal = JadwalTersedia::with('fasilitas')->get();

    return view('siswa.jadwal', compact('jadwal'));
}


    public function createBooking($id)
    {
        $fasilitas = DB::table('fasilitas')
            ->where('id_fasilitas', $id)
            ->first();

        return view('siswa.create-booking', compact('fasilitas'));
    }

public function storeBooking(Request $request)
{
    $bookingId = DB::table('bookings')->insertGetId([

        'id_user' => auth()->id(),

        'id_fasilitas' => $request->id_fasilitas,

        'organisasi' => $request->organisasi,

        'penanggung_jawab' => $request->penanggung_jawab,

        'tujuan' => $request->tujuan,

        'tanggal_booking' => now(),

        'tanggal' => $request->tanggal,

        'jam_mulai' => $request->jam_mulai,

        'jam_selesai' => $request->jam_selesai,

        'status' => 'pending',

        'created_at' => now(),

        'updated_at' => now(),
    ]);

    // TAMBAH INI
    DB::table('booking_details')->insert([
        'id_booking' => $bookingId,
        'id_fasilitas' => $request->id_fasilitas,
        'qty' => 1,
        'harga_satuan' => 0,
        'subtotal' => 0,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->back()->with('success', 'Booking berhasil dikirim!');
}


public function contact()
{
    return view('siswa.contact');
}

}
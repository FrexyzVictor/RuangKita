<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Fasilitas;
use App\Models\Booking;
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
    public function home(Request $request)
{
    $query = Fasilitas::query();

    // 🔍 keyword search (Shopee-style utama)
    if ($request->keyword) {
        $query->where('nama', 'like', '%' . $request->keyword . '%');
    }

    // 🏷️ kategori filter
    if ($request->category) {
        $query->where('kategori', $request->category);
    }

    // 📅 filter tanggal (kalau kamu punya field booking/date)
    if ($request->date) {
        $query->whereDate('created_at', $request->date);
    }

    $fasilitas = $query->latest()->get();

    return view('siswa.home', compact('fasilitas'));
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
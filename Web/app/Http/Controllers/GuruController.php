<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Fasilitas;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        return view('guru.dashboard');
    }

    // Status booking
    public function status()
    {
        $bookings = Booking::where(
            'id_user',
            auth()->user()->id_user
        )->latest()->get();

        return view(
            'guru.status',
            compact('bookings')
        );
    }

    // Halaman booking
    public function booking()
    {
        // ambil fasilitas tersedia
        $fasilitas = Fasilitas::where(
            'status',
            'tersedia'
        )->get();

        // riwayat booking guru
        $bookings = Booking::where(
            'id_user',
            auth()->user()->id_user
        )->latest()->get();

        return view(
            'guru.booking',
            compact('fasilitas', 'bookings')
        );
    }

    // Simpan booking
    public function storeBooking(Request $request)
    {
        $request->validate([

            'id_fasilitas'    => 'required',

            'tanggal_mulai'   => 'required|date',

            'tanggal_selesai' => 'required|date|after:tanggal_mulai',

            'catatan'         => 'nullable|string',
        ]);

        Booking::create([

            'id_user'          => auth()->user()->id_user,

            'id_fasilitas'     => $request->id_fasilitas,

            'tanggal_booking'  => now(),

            'tanggal_mulai'    => $request->tanggal_mulai,

            'tanggal_selesai'  => $request->tanggal_selesai,

            // guru gratis
            'total_harga'      => 0,

            // otomatis lunas
            'status'           => 'lunas',

            'catatan'          => $request->catatan,
        ]);

        return redirect()
            ->route('guru.booking')
            ->with('success', 'Booking berhasil dibuat.');
    }

    // Halaman fasilitas guru
    public function fasilitas()
    {
        // ambil fasilitas tersedia
        $fasilitas = Fasilitas::where(
            'status',
            'tersedia'
        )->latest()->get();

        return view(
            'guru.fasilitas',
            compact('fasilitas')
        );
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = DB::table('bookings')->get();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show($id)
    {
        $booking = DB::table('bookings')
            ->where('id_booking', $id)
            ->first();

        return view('admin.bookings.show', compact('booking'));
    }

    public function approve($id)
    {
        DB::table('bookings')
            ->where('id_booking', $id)
            ->update([
                'status' => 'approved',
                'updated_at' => now()
            ]);

        return back()->with('success', 'Booking approved');
    }

    public function cancel($id)
    {
        DB::table('bookings')
            ->where('id_booking', $id)
            ->update([
                'status' => 'cancelled',
                'updated_at' => now()
            ]);

        return back()->with('success', 'Booking cancelled');
    }

    public function destroy($id)
    {
        DB::table('bookings')
            ->where('id_booking', $id)
            ->delete();

        return back()->with('success', 'Booking deleted');
    }
}
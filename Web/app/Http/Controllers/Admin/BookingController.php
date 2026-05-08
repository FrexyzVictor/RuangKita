<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        return view('admin.bookings.index');
    }

    public function show($id)
    {
        return view('admin.bookings.show', compact('id'));
    }

    public function approve($id)
    {
        return back()->with('success', 'Booking approved');
    }

    public function cancel($id)
    {
        return back()->with('success', 'Booking cancelled');
    }

    public function destroy($id)
    {
        return back()->with('success', 'Booking deleted');
    }
}
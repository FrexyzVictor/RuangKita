<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
{
    $bookings = collect();

    return view('Admin.Dashboard', compact('bookings'));
}
} //aa
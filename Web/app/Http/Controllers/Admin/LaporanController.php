<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class LaporanController extends Controller
{
    public function index()
    {
        return view('admin.laporan.index');
    }

    public function export()
    {
        return response()->download(storage_path('app/laporan.pdf'));
    }
}
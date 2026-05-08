<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class EvaluasiController extends Controller
{
    public function index()
    {
        return view('admin.evaluasi.index');
    }

    public function show($id)
    {
        return view('admin.evaluasi.show', compact('id'));
    }

    public function destroy($id)
    {
        return back();
    }
}
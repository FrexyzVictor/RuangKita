<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        return view('admin.jadwal.index');
    }

    public function create()
    {
        return view('admin.jadwal.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.jadwal.index');
    }

    public function edit($id)
    {
        return view('admin.jadwal.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('admin.jadwal.index');
    }

    public function destroy($id)
    {
        return back();
    }

    public function toggle($id)
    {
        return back();
    }
}
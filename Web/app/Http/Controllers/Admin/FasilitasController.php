<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FasilitasController extends Controller
{
    public function index()
    {
        return view('admin.fasilitas.index');
    }

    public function create()
    {
        return view('admin.fasilitas.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.fasilitas.index');
    }

    public function show($id)
    {
        return view('admin.fasilitas.show', compact('id'));
    }

    public function edit($id)
    {
        return view('admin.fasilitas.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('admin.fasilitas.index');
    }

    public function destroy($id)
    {
        return back();
    }

    public function toggleStatus($id)
    {
        return back();
    }
}
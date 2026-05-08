<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        return view('admin.kategori.index');
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.kategori.index');
    }

    public function edit($id)
    {
        return view('admin.kategori.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('admin.kategori.index');
    }

    public function destroy($id)
    {
        return back();
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriFasilitas;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = KategoriFasilitas::withCount('fasilitas')
            ->orderBy('nama_kategori')
            ->get();

        return view('admin.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori_fasilitas,nama_kategori',
            'deskripsi'     => 'nullable|string|max:500',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Nama kategori sudah ada.',
        ]);

        KategoriFasilitas::create([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi'     => $request->deskripsi,
        ]);

        return redirect()
            ->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $kategori = KategoriFasilitas::findOrFail($id);

        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $kategori = KategoriFasilitas::findOrFail($id);

        $request->validate([
            'nama_kategori' => "required|string|max:100|unique:kategori_fasilitas,nama_kategori,{$kategori->id_kategori},id_kategori",
            'deskripsi'     => 'nullable|string|max:500',
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi'     => $request->deskripsi,
        ]);

        return redirect()
            ->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kategori = KategoriFasilitas::findOrFail($id);

        // Cek apakah masih punya fasilitas
        if ($kategori->fasilitas()->count() > 0) {
            return back()->with('error', 'Kategori masih memiliki fasilitas. Pindahkan atau hapus fasilitas terlebih dahulu.');
        }

        $kategori->delete();

        return back()->with('success', 'Kategori berhasil dihapus.');
    }
}
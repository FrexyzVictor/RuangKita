<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fasilitas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FasilitasController extends Controller
{
    public function index()
    {
        $fasilitas = DB::table('fasilitas')
            ->leftJoin(
                'kategori_fasilitas',
                'fasilitas.id_kategori',
                '=',
                'kategori_fasilitas.id_kategori'
            )
            ->select(
                'fasilitas.*',
                'kategori_fasilitas.nama_kategori'
            )
            ->get();

        return view('admin.fasilitas.index', compact('fasilitas'));
    }

    public function create()
    {
        $kategori = DB::table('kategori_fasilitas')->get();

        return view('admin.fasilitas.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required',
            'nama_fasilitas' => 'required',
            'harga' => 'required|numeric|min:1',
            'lokasi' => 'required',
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload gambar
        $gambar = null;

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar')
                ->store('fasilitas', 'public');
        }

        DB::table('fasilitas')->insert([
            'id_kategori' => $request->id_kategori,
            'nama_fasilitas' => $request->nama_fasilitas,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'lokasi' => $request->lokasi,
            'kapasitas' => $request->kapasitas,
            'status' => $request->status,
            'gambar' => $gambar,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas berhasil ditambahkan');
    }

    public function show($id)
    {
        $fasilitas = DB::table('fasilitas')
            ->leftJoin(
                'kategori_fasilitas',
                'fasilitas.id_kategori',
                '=',
                'kategori_fasilitas.id_kategori'
            )
            ->select(
                'fasilitas.*',
                'kategori_fasilitas.nama_kategori'
            )
            ->where('fasilitas.id_fasilitas', $id)
            ->first();

        return view('admin.fasilitas.show', compact('fasilitas'));
    }

    public function edit($id)
    {
        $fasilitas = DB::table('fasilitas')
            ->where('id_fasilitas', $id)
            ->first();

        $kategori = DB::table('kategori_fasilitas')->get();

        return view(
            'admin.fasilitas.edit',
            compact('fasilitas', 'kategori')
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_kategori' => 'required',
            'nama_fasilitas' => 'required',
            'harga' => 'required|numeric|min:1',
            'lokasi' => 'required',
            'kapasitas' => 'required|integer|min:1',
            'status' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $fasilitas = DB::table('fasilitas')
            ->where('id_fasilitas', $id)
            ->first();

        $data = [
            'id_kategori' => $request->id_kategori,
            'nama_fasilitas' => $request->nama_fasilitas,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'lokasi' => $request->lokasi,
            'kapasitas' => $request->kapasitas,
            'status' => $request->status,
            'updated_at' => now(),
        ];

        // Jika upload gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($fasilitas->gambar
                && Storage::disk('public')->exists($fasilitas->gambar)) {
                Storage::disk('public')
                    ->delete($fasilitas->gambar);
            }

            // Upload gambar baru
            $gambarBaru = $request->file('gambar')
                ->store('fasilitas', 'public');

            $data['gambar'] = $gambarBaru;
        }

        DB::table('fasilitas')
            ->where('id_fasilitas', $id)
            ->update($data);

        return redirect()
            ->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas berhasil diupdate');
    }

    public function destroy($id)
    {
        $fasilitas = DB::table('fasilitas')
            ->where('id_fasilitas', $id)
            ->first();

        // Hapus gambar dari storage
        if ($fasilitas->gambar
            && Storage::disk('public')->exists($fasilitas->gambar)) {
            Storage::disk('public')
                ->delete($fasilitas->gambar);
        }

        DB::table('fasilitas')
            ->where('id_fasilitas', $id)
            ->delete();

        return back()
            ->with('success', 'Fasilitas berhasil dihapus');
    }

    public function toggleStatus($id)
    {
        $fasilitas = DB::table('fasilitas')
            ->where('id_fasilitas', $id)
            ->first();

        if (!$fasilitas) {
            return back()
                ->with('error', 'Fasilitas tidak ditemukan');
        }

        $statusBaru = $fasilitas->status == 'tersedia'
            ? 'maintenance'
            : 'tersedia';

        DB::table('fasilitas')
            ->where('id_fasilitas', $id)
            ->update([
                'status' => $statusBaru,
                'updated_at' => now(),
            ]);

        return back()
            ->with('success', 'Status fasilitas berhasil diubah');
    }
}

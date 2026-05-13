<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FasilitasController extends Controller
{
    public function index()
    {
        // ambil semua data fasilitas + kategori
        $fasilitas = DB::table('fasilitas')
            ->leftJoin('kategori_fasilitas', 'fasilitas.id_kategori', '=', 'kategori_fasilitas.id_kategori')
            ->select(
                'fasilitas.*',
                'kategori_fasilitas.nama_kategori'
            )
            ->get();

        return view('admin.fasilitas-index', compact('fasilitas'));
    }

    public function create()
    {
        $kategori = DB::table('kategori_fasilitas')->get();

        return view('admin.fasilitas-create', compact('kategori'));
    }

    public function store(Request $request)
    {
        DB::table('fasilitas')->insert([
            'id_kategori'     => $request->id_kategori,
            'nama_fasilitas'  => $request->nama_fasilitas,
            'deskripsi'       => $request->deskripsi,
            'harga'           => $request->harga,
            'lokasi'          => $request->lokasi,
            'kapasitas'       => $request->kapasitas,
            'status'          => $request->status,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        return redirect()->route('admin.fasilitas.index');
    }

    public function show($id)
    {
        $fasilitas = DB::table('fasilitas')
            ->leftJoin('kategori_fasilitas', 'fasilitas.id_kategori', '=', 'kategori_fasilitas.id_kategori')
            ->select(
                'fasilitas.*',
                'kategori_fasilitas.nama_kategori'
            )
            ->where('id_fasilitas', $id)
            ->first();

        return view('admin.fasilitas-show', compact('fasilitas'));
    }

    public function edit($id)
    {
        $fasilitas = DB::table('fasilitas')
            ->where('id_fasilitas', $id)
            ->first();

        $kategori = DB::table('kategori_fasilitas')->get();

        return view('admin.fasilitas-edit', compact('fasilitas', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        DB::table('fasilitas')
            ->where('id_fasilitas', $id)
            ->update([
                'id_kategori'     => $request->id_kategori,
                'nama_fasilitas'  => $request->nama_fasilitas,
                'deskripsi'       => $request->deskripsi,
                'harga'           => $request->harga,
                'lokasi'          => $request->lokasi,
                'kapasitas'       => $request->kapasitas,
                'status'          => $request->status,
                'updated_at'      => now(),
            ]);

        return redirect()->route('admin.fasilitas.index');
    }

    public function destroy($id)
    {
        DB::table('fasilitas')
            ->where('id_fasilitas', $id)
            ->delete();

        return back();
    }

    public function toggleStatus($id)
    {
        $fasilitas = DB::table('fasilitas')
            ->where('id_fasilitas', $id)
            ->first();

        $statusBaru = $fasilitas->status == 'tersedia'
            ? 'maintenance'
            : 'tersedia';

        DB::table('fasilitas')
            ->where('id_fasilitas', $id)
            ->update([
                'status' => $statusBaru
            ]);

        return back();
    }
}
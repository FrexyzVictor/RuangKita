<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwals = DB::table('jadwal_tersedia')
            ->join('fasilitas', 'jadwal_tersedia.id_fasilitas', '=', 'fasilitas.id_fasilitas')
            ->select('jadwal_tersedia.*', 'fasilitas.nama_fasilitas')
            ->get();

        $totalJadwal = DB::table('jadwal_tersedia')->count();
        $tersedia = DB::table('jadwal_tersedia')->where('status', 'tersedia')->count();
        $dibooking = DB::table('jadwal_tersedia')->where('status', 'dibooking')->count();
        $hariIni = DB::table('jadwal_tersedia')->whereDate('tanggal', date('Y-m-d'))->count();

        $events = DB::table('jadwal_tersedia')
            ->join('fasilitas', 'jadwal_tersedia.id_fasilitas', '=', 'fasilitas.id_fasilitas')
            ->select('jadwal_tersedia.*', 'fasilitas.nama_fasilitas')
            ->get()
            ->map(function ($item) {
                return [
                    'title' => $item->nama_fasilitas,
                    'start' => $item->tanggal.'T'.$item->jam_mulai,
                    'end' => $item->tanggal.'T'.$item->jam_selesai,
                    'color' => $item->status == 'tersedia' ? '#10b981' : '#ef4444',
                ];
            });

        return view('admin.jadwal.index', compact(
            'jadwals',
            'totalJadwal',
            'tersedia',
            'dibooking',
            'hariIni',
            'events'
        ));
    }

    public function create()
    {
        $fasilitas = DB::table('fasilitas')
            ->where('status', 'tersedia')
            ->get();

        return view('admin.jadwal.create', compact('fasilitas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_fasilitas' => 'required',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'status' => 'required',
        ]);

        $fasilitas = DB::table('fasilitas')
            ->where('id_fasilitas', $request->id_fasilitas)
            ->first();

        if (!$fasilitas || $fasilitas->status != 'tersedia') {
            return back()->withInput()->withErrors(['fasilitas' => 'Fasilitas tidak tersedia']);
        }

        $bentrok = DB::table('jadwal_tersedia')
            ->where('id_fasilitas', $request->id_fasilitas)
            ->where('tanggal', $request->tanggal)
            ->where(function ($q) use ($request) {
                $q->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                  ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                  ->orWhere(function ($q2) use ($request) {
                      $q2->where('jam_mulai', '<=', $request->jam_mulai)
                         ->where('jam_selesai', '>=', $request->jam_selesai);
                  });
            })
            ->exists();

        if ($bentrok) {
            return back()->withInput()->withErrors(['jam' => 'Jadwal bentrok']);
        }

        DB::table('jadwal_tersedia')->insert([
            'id_fasilitas' => $request->id_fasilitas,
            'tanggal' => $request->tanggal,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'status' => $request->status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function show($id)
    {
        $jadwal = DB::table('jadwal_tersedia')
            ->join('fasilitas', 'jadwal_tersedia.id_fasilitas', '=', 'fasilitas.id_fasilitas')
            ->select('jadwal_tersedia.*', 'fasilitas.nama_fasilitas')
            ->where('jadwal_tersedia.id_jadwal', $id)
            ->first();

        return view('admin.jadwal.show', compact('jadwal'));
    }

    public function edit($id)
    {
        $jadwal = DB::table('jadwal_tersedia')
            ->where('id_jadwal', $id)
            ->first();

        $fasilitas = DB::table('fasilitas')
            ->where('status', 'tersedia')
            ->orWhere('id_fasilitas', $jadwal->id_fasilitas)
            ->get();

        return view('admin.jadwal.edit', compact('jadwal', 'fasilitas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_fasilitas' => 'required',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'status' => 'required',
        ]);

        $fasilitas = DB::table('fasilitas')
            ->where('id_fasilitas', $request->id_fasilitas)
            ->first();

        if (!$fasilitas || $fasilitas->status != 'tersedia') {
            return back()->withInput()->withErrors(['fasilitas' => 'Fasilitas tidak tersedia']);
        }

        $bentrok = DB::table('jadwal_tersedia')
            ->where('id_fasilitas', $request->id_fasilitas)
            ->where('tanggal', $request->tanggal)
            ->where('id_jadwal', '!=', $id)
            ->where(function ($q) use ($request) {
                $q->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                  ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                  ->orWhere(function ($q2) use ($request) {
                      $q2->where('jam_mulai', '<=', $request->jam_mulai)
                         ->where('jam_selesai', '>=', $request->jam_selesai);
                  });
            })
            ->exists();

        if ($bentrok) {
            return back()->withInput()->withErrors(['jam' => 'Jadwal bentrok']);
        }

        DB::table('jadwal_tersedia')
            ->where('id_jadwal', $id)
            ->update([
                'id_fasilitas' => $request->id_fasilitas,
                'tanggal' => $request->tanggal,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'status' => $request->status,
                'updated_at' => now(),
            ]);

        return redirect()->route('admin.jadwal.index')->with('success', 'Jadwal berhasil diupdate');
    }

    public function destroy($id)
    {
        DB::table('jadwal_tersedia')->where('id_jadwal', $id)->delete();

        return back()->with('success', 'Jadwal berhasil dihapus');
    }
}

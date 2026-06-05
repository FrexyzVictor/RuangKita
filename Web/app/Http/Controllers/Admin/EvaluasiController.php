<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class EvaluasiController extends Controller
{
    public function index()
    {
        $evaluasi = DB::table('evaluasi_bookings')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.evaluasi.index', compact('evaluasi'));
    }

    public function show($id)
    {
        $evaluasi = DB::table('evaluasi_bookings')
            ->where('id', $id)
            ->first();

        return view('admin.evaluasi.show', compact('evaluasi'));
    }

    public function destroy($id)
    {
        DB::table('evaluasi_bookings')->where('id', $id)->delete();

        return redirect()->route('admin.evaluasi.index')
            ->with('success', 'Data evaluasi berhasil dihapus');
    }
}

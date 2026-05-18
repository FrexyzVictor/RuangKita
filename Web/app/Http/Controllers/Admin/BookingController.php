<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Fasilitas;
use App\Models\User;
use App\Models\KategoriFasilitas;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Daftar semua booking dengan filter & pagination.
     */
public function index(Request $request)
{
    $query = Booking::with(['user', 'details.fasilitas'])
        ->latest('created_at');

    // Filter pencarian
    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->whereHas('user', fn($u) =>
                $u->where('nama', 'like', "%{$search}%")
            )
            ->orWhereHas('details.fasilitas', fn($f) =>
                $f->where('nama_fasilitas', 'like', "%{$search}%")
            );
        });
    }

    // Filter status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Filter tanggal
    if ($request->filled('tanggal')) {
        $query->whereDate('tanggal_booking', $request->tanggal);
    }

    $bookings = $query->paginate(15)->withQueryString();

    $kategoris = KategoriFasilitas::orderBy('nama_kategori')->get();

    $fasilitasList = Fasilitas::with('kategori')
        ->orderBy('status')
        ->orderBy('nama_fasilitas')
        ->get();

    $users = User::whereIn('role', ['siswa', 'guru'])
        ->orderBy('nama')
        ->get();

    return view(
        'admin.bookings.index',
        compact(
            'bookings',
            'kategoris',
            'fasilitasList',
            'users'
        )
    );
}
    /**
     * Form buat booking baru (dengan search ruangan).
     */
    public function create()
    {
        $fasilitasList = Fasilitas::with('kategori')
            ->orderBy('status') // tersedia dulu
            ->orderBy('nama_fasilitas')
            ->get();

        $users     = User::whereIn('role', ['siswa', 'guru'])
                         ->orderBy('nama')
                         ->get();

        $kategoris = KategoriFasilitas::orderBy('nama_kategori')->get();

        return view('admin.bookings.create', compact('fasilitasList', 'users', 'kategoris'));
    }

    /**
     * Simpan booking baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_user'         => 'required|exists:users,id_user',
            'id_fasilitas'    => 'required|exists:fasilitas,id_fasilitas',
            'tanggal_booking' => 'required|date',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'catatan'         => 'nullable|string|max:1000',
        ]);

        // Hitung total harga
        $fasilitas = Fasilitas::findOrFail($validated['id_fasilitas']);
        $mulai     = \Carbon\Carbon::parse($validated['tanggal_mulai']);
        $selesai   = \Carbon\Carbon::parse($validated['tanggal_selesai']);
        $jam       = $mulai->diffInMinutes($selesai) / 60;
        $total     = $fasilitas->harga * $jam;

        // Buat booking
        $booking = Booking::create([
            'id_user'         => $validated['id_user'],
            'tanggal_booking' => $validated['tanggal_booking'],
            'tanggal_mulai'   => $validated['tanggal_mulai'],
            'tanggal_selesai' => $validated['tanggal_selesai'],
            'total_harga'     => $total,
            'status'          => 'pending',
            'catatan'         => $validated['catatan'] ?? null,
        ]);

        // Buat booking detail
        $booking->details()->create([
            'id_fasilitas'  => $fasilitas->id_fasilitas,
            'qty'           => 1,
            'harga_satuan'  => $fasilitas->harga,
            'subtotal'      => $total,
        ]);

        return redirect()
            ->route('admin.bookings.show', $booking->id_booking)
            ->with('success', 'Booking berhasil dibuat!');
    }

    /**
     * Detail booking.
     */
    public function show($id)
    {
        $booking = Booking::with(['user', 'details.fasilitas'])->findOrFail($id);

        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Setujui booking (status → dibayar).
     */
    public function approve($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->status !== 'pending') {
            return back()->with('error', 'Hanya booking berstatus pending yang bisa disetujui.');
        }

        $booking->update(['status' => 'dibayar']);

        return back()->with('success', "Booking #{$id} berhasil disetujui.");
    }

    /**
     * Batalkan booking (status → dibatalkan).
     */
    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);

        if (in_array($booking->status, ['selesai', 'dibatalkan'])) {
            return back()->with('error', 'Booking ini tidak dapat dibatalkan.');
        }

        $booking->update(['status' => 'dibatalkan']);

        return back()->with('success', "Booking #{$id} berhasil dibatalkan.");
    }

    /**
     * Hapus booking.
     */
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->details()->delete();
        $booking->delete();

        return redirect()
            ->route('admin.bookings.index')
            ->with('success', "Booking #{$id} berhasil dihapus.");
    }
}
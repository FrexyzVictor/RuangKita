<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Fasilitas;
use App\Models\User;
use App\Models\KategoriFasilitas;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingController extends Controller
{
    /* ═══════════════════════════════════════════════════════════
     * INDEX — daftar booking + filter + pagination
     * ═══════════════════════════════════════════════════════════ */
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'details.fasilitas', 'pembayaran'])
                        ->latest('created_at');

        // Filter pencarian (nama user / nama fasilitas)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn($u) =>
                    $u->where('nama', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
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

        // Filter role user
        if ($request->filled('role')) {
            $query->whereHas('user', fn($u) => $u->where('role', $request->role));
        }

        $bookings = $query->paginate(15)->withQueryString();

        // Stats untuk header cards
        $stats = [
            'pending'      => Booking::where('status', 'pending')->count(),
            'belum_lunas'  => Booking::whereIn('status', ['dp_dibayar', 'belum_lunas'])->count(),
            'lunas'        => Booking::where('status', 'lunas')->count(),
            'hari_ini'     => Booking::whereDate('tanggal_booking', today())->count(),
        ];

        $kategoris    = KategoriFasilitas::orderBy('nama_kategori')->get();
        $fasilitasList = Fasilitas::with('kategori')->orderBy('nama_fasilitas')->get();
        $users         = User::whereIn('role', ['siswa', 'guru', 'tamu'])->orderBy('nama')->get();

        return view('admin.bookings.index', compact(
            'bookings', 'kategoris', 'fasilitasList', 'users', 'stats'
        ));
    }

    /* ═══════════════════════════════════════════════════════════
     * CREATE — form buat booking baru
     * ═══════════════════════════════════════════════════════════ */
    public function create()
    {
        $fasilitasList = Fasilitas::with('kategori')
                                  ->orderBy('status')
                                  ->orderBy('nama_fasilitas')
                                  ->get();

        $users     = User::whereIn('role', ['siswa', 'guru', 'tamu'])
                         ->orderBy('nama')
                         ->get();

        $kategoris = KategoriFasilitas::orderBy('nama_kategori')->get();

        return view('admin.bookings.create', compact('fasilitasList', 'users', 'kategoris'));
    }

    /* ═══════════════════════════════════════════════════════════
     * STORE — simpan booking baru
     * ═══════════════════════════════════════════════════════════ */
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

        $fasilitas = Fasilitas::findOrFail($validated['id_fasilitas']);
        $user      = User::findOrFail($validated['id_user']);

        // Hitung durasi & harga
        $mulai   = Carbon::parse($validated['tanggal_mulai']);
        $selesai = Carbon::parse($validated['tanggal_selesai']);
        $jam     = $mulai->diffInMinutes($selesai) / 60;

        // Tamu bayar, siswa & guru gratis
        $hargaSatuan = in_array($user->role, ['siswa', 'guru']) ? 0 : $fasilitas->harga;
        $total       = $hargaSatuan * $jam;

        // Jika gratis → langsung lunas; tamu → pending (nunggu konfirmasi)
        $statusAwal = in_array($user->role, ['siswa', 'guru']) ? 'lunas' : 'pending';

        DB::transaction(function () use ($validated, $fasilitas, $user, $total, $hargaSatuan, $statusAwal, &$booking) {
            $booking = Booking::create([
                'id_user'          => $validated['id_user'],
                'tanggal_booking'  => $validated['tanggal_booking'],
                'tanggal_mulai'    => $validated['tanggal_mulai'],
                'tanggal_selesai'  => $validated['tanggal_selesai'],
                'total_harga'      => $total,
                'status'           => $statusAwal,
                'sisa_pembayaran'  => $user->role === 'tamu' ? $total : 0,
                'catatan'          => $validated['catatan'] ?? null,
            ]);

            $booking->details()->create([
                'id_fasilitas' => $fasilitas->id_fasilitas,
                'qty'          => 1,
                'harga_satuan' => $hargaSatuan,
                'subtotal'     => $total,
            ]);
        });

        return redirect()
            ->route('admin.bookings.show', $booking->id_booking)
            ->with('success', 'Booking berhasil dibuat!');
    }

    /* ═══════════════════════════════════════════════════════════
     * SHOW — detail booking
     * ═══════════════════════════════════════════════════════════ */
    public function show($id)
    {
        $booking = Booking::with([
            'user',
            'details.fasilitas',
            'pembayaran.pencatat',
            'confirmedBy',
        ])->findOrFail($id);

        return view('admin.bookings.show', compact('booking'));
    }

        /* ═══════════════════════════════════════════════════════════
     * EDIT — form edit booking
     * ═══════════════════════════════════════════════════════════ */
    public function edit($id)
    {
        $booking = Booking::with([
            'user',
            'details.fasilitas'
        ])->findOrFail($id);

        $fasilitasList = Fasilitas::with('kategori')
            ->orderBy('nama_fasilitas')
            ->get();

        $users = User::whereIn('role', ['siswa', 'guru', 'tamu'])
            ->orderBy('nama')
            ->get();

        return view('admin.bookings.edit', compact(
            'booking',
            'fasilitasList',
            'users'
        ));
    }

    /* ═══════════════════════════════════════════════════════════
     * UPDATE — simpan perubahan booking
     * ═══════════════════════════════════════════════════════════ */
    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $validated = $request->validate([
            'tanggal_booking' => 'required|date',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'catatan'         => 'nullable|string|max:1000',
        ]);

        $booking->update([
            'tanggal_booking' => $validated['tanggal_booking'],
            'tanggal_mulai'   => $validated['tanggal_mulai'],
            'tanggal_selesai' => $validated['tanggal_selesai'],
            'catatan'         => $validated['catatan'] ?? null,
        ]);

        return redirect()
            ->route('admin.bookings.show', $booking->id_booking)
            ->with('success', 'Booking berhasil diperbarui.');
    }

    /* ═══════════════════════════════════════════════════════════
     * APPROVE — konfirmasi booking (pending → dikonfirmasi/lunas)
     * ═══════════════════════════════════════════════════════════ */
    public function approve(Request $request, $id)
    {
        $booking = Booking::with('user')->findOrFail($id);

        if ($booking->status !== 'pending') {
            return back()->with('error', 'Hanya booking berstatus pending yang bisa dikonfirmasi.');
        }

        $catatan = $request->input('catatan_admin');

        // Jika user gratis (siswa/guru) → langsung lunas
        // Jika tamu → dikonfirmasi (masih perlu bayar DP)
        $statusBaru = $booking->isFree() ? 'lunas' : 'dikonfirmasi';

        $booking->update([
            'status'       => $statusBaru,
            'confirmed_by' => auth()->id(),
            'confirmed_at' => now(),
            'catatan_admin' => $catatan,
        ]);

        $msg = $booking->isFree()
            ? "Booking #{$id} dikonfirmasi & otomatis lunas (pengguna gratis)."
            : "Booking #{$id} berhasil dikonfirmasi. Menunggu pembayaran dari tamu.";

        return back()->with('success', $msg);
    }

    /* ═══════════════════════════════════════════════════════════
     * CATAT DP — admin catat pembayaran DP dari tamu
     * ═══════════════════════════════════════════════════════════ */
    public function catatDP(Request $request, $id)
    {
        $booking = Booking::with('user')->findOrFail($id);

        if (! $booking->isTamu()) {
            return back()->with('error', 'Fitur DP hanya untuk tamu.');
        }

        if (! in_array($booking->status, ['dikonfirmasi', 'belum_lunas'])) {
            return back()->with('error', 'Status booking tidak memungkinkan pencatatan DP.');
        }

        $validated = $request->validate([
            'jumlah_dp'  => 'required|numeric|min:1',
            'metode'     => 'required|in:tunai,transfer,lainnya',
            'keterangan' => 'nullable|string|max:500',
            'bukti'      => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $buktiPath = null;
        if ($request->hasFile('bukti')) {
            $buktiPath = $request->file('bukti')->store('bukti-pembayaran', 'public');
        }

        DB::transaction(function () use ($booking, $validated, $buktiPath) {
            Pembayaran::create([
                'id_booking'   => $booking->id_booking,
                'jenis'        => 'dp',
                'jumlah'       => $validated['jumlah_dp'],
                'metode'       => $validated['metode'],
                'bukti_transfer' => $buktiPath,
                'dicatat_oleh' => auth()->id(),
                'keterangan'   => $validated['keterangan'] ?? null,
            ]);

            $totalDibayar = $booking->totalDibayar();
            $sisa         = max(0, $booking->total_harga - $totalDibayar);

            // Tentukan status baru
            if ($sisa <= 0) {
                $statusBaru = 'lunas';
            } else {
                $statusBaru = 'dp_dibayar';
            }

            $booking->update([
                'dp_amount'       => $totalDibayar,
                'sisa_pembayaran' => $sisa,
                'status'          => $statusBaru,
            ]);
        });

        return back()->with('success', 'DP berhasil dicatat.');
    }

    /* ═══════════════════════════════════════════════════════════
     * CATAT PELUNASAN — admin catat pelunasan dari tamu
     * ═══════════════════════════════════════════════════════════ */
    public function catatPelunasan(Request $request, $id)
    {
        $booking = Booking::with('user')->findOrFail($id);

        if (! $booking->isTamu()) {
            return back()->with('error', 'Fitur pelunasan hanya untuk tamu.');
        }

        if (! in_array($booking->status, ['dp_dibayar', 'belum_lunas', 'dikonfirmasi'])) {
            return back()->with('error', 'Status booking tidak bisa dilunasi.');
        }

        $validated = $request->validate([
            'jumlah_lunas' => 'required|numeric|min:1',
            'metode'       => 'required|in:tunai,transfer,lainnya',
            'keterangan'   => 'nullable|string|max:500',
            'bukti'        => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $buktiPath = null;
        if ($request->hasFile('bukti')) {
            $buktiPath = $request->file('bukti')->store('bukti-pembayaran', 'public');
        }

        DB::transaction(function () use ($booking, $validated, $buktiPath) {
            Pembayaran::create([
                'id_booking'     => $booking->id_booking,
                'jenis'          => 'pelunasan',
                'jumlah'         => $validated['jumlah_lunas'],
                'metode'         => $validated['metode'],
                'bukti_transfer' => $buktiPath,
                'dicatat_oleh'   => auth()->id(),
                'keterangan'     => $validated['keterangan'] ?? null,
            ]);

            $totalDibayar = $booking->totalDibayar();
            $sisa         = max(0, $booking->total_harga - $totalDibayar);

            $statusBaru = $sisa <= 0 ? 'lunas' : 'belum_lunas';

            $booking->update([
                'dp_amount'       => $totalDibayar,
                'sisa_pembayaran' => $sisa,
                'status'          => $statusBaru,
            ]);
        });

        return back()->with('success', 'Pembayaran pelunasan berhasil dicatat.');
    }

    /* ═══════════════════════════════════════════════════════════
     * SELESAI — tandai booking selesai
     * ═══════════════════════════════════════════════════════════ */
    public function selesai($id)
    {
        $booking = Booking::findOrFail($id);

        if (! in_array($booking->status, ['lunas', 'dikonfirmasi'])) {
            return back()->with('error', 'Booking harus berstatus lunas atau dikonfirmasi untuk ditandai selesai.');
        }

        $booking->update(['status' => 'selesai']);

        return back()->with('success', "Booking #{$id} ditandai selesai.");
    }

    /* ═══════════════════════════════════════════════════════════
     * CANCEL — batalkan booking
     * ═══════════════════════════════════════════════════════════ */
    public function cancel(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        if (in_array($booking->status, ['selesai', 'dibatalkan'])) {
            return back()->with('error', 'Booking ini tidak dapat dibatalkan.');
        }

        $booking->update([
            'status'        => 'dibatalkan',
            'catatan_admin' => $request->input('catatan_admin'),
        ]);

        return back()->with('success', "Booking #{$id} berhasil dibatalkan.");
    }

    /* ═══════════════════════════════════════════════════════════
     * DESTROY — hapus permanen
     * ═══════════════════════════════════════════════════════════ */
    public function destroy($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->pembayaran()->delete();
        $booking->details()->delete();
        $booking->delete();

        return redirect()
            ->route('admin.bookings.index')
            ->with('success', "Booking #{$id} berhasil dihapus.");
    }
} // aa
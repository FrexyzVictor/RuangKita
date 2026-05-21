<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /* ─── INDEX ───────────────────────────────────────────────── */
    public function index(Request $request)
    {
        $query = User::query();

        // Search: nama, email, no_hp
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama',   'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($role = $request->get('role')) {
            $query->where('role', $role);
        }

        /**
         * URUTAN TAMPILAN:
         * 1. Admin selalu paling atas (FIELD role = 'admin' → nilai 0, lainnya 1)
         * 2. Dalam role yang sama, urutkan dari yang terbaru (created_at DESC)
         *
         * Menggunakan FIELD() / CASE agar portabel di MySQL & SQLite:
         */
        $query->orderByRaw("
            CASE
                WHEN role = 'admin' THEN 0
                WHEN role = 'guru'  THEN 1
                WHEN role = 'siswa' THEN 2
                ELSE 3
            END ASC
        ")->orderBy('created_at', 'desc');

        $users = $query->paginate(15)->withQueryString();

        // Stats per role
        $stats = [
            'total'      => User::count(),
            'admin'      => User::where('role', 'admin')->count(),
            'guru'       => User::where('role', 'guru')->count(),
            'siswa'      => User::where('role', 'siswa')->count(),
            'pengunjung' => User::where('role', 'pengunjung')->count(),
            'guest'      => User::where('role', 'guest')->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    /* ─── SHOW ────────────────────────────────────────────────── */
    public function show($id)
    {
        $user = User::with('bookings.details.fasilitas')->findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    /* ─── CREATE ──────────────────────────────────────────────── */
    public function create()
    {
        return view('admin.users.create');
    }

    /* ─── STORE ───────────────────────────────────────────────── */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'role'     => ['required', Rule::in(['admin','guru','siswa','pengunjung','guest'])],
            'no_hp'    => ['nullable', 'string', 'max:20'],
            'alamat'   => ['nullable', 'string', 'max:500'],
        ], [
            'nama.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah terdaftar.',
            'password.required'  => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min'       => 'Password minimal 8 karakter.',
            'role.required'      => 'Role wajib dipilih.',
            'role.in'            => 'Role tidak valid.',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', "Akun pengguna {$validated['nama']} berhasil dibuat.");
    }

    /* ─── EDIT ────────────────────────────────────────────────── */
    public function edit($id)
    {
        $user = User::with('bookings')->findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    /* ─── UPDATE ──────────────────────────────────────────────── */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'nama'   => ['required', 'string', 'max:255'],
            'email'  => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id_user, 'id_user')],
            'role'   => ['required', Rule::in(['admin','guru','siswa','pengunjung','guest'])],
            'no_hp'  => ['nullable', 'string', 'max:20'],
            'alamat' => ['nullable', 'string', 'max:500'],
        ];

        // Password hanya divalidasi jika diisi
        if ($request->filled('password')) {
            $rules['password'] = ['confirmed', Password::min(8)];
        }

        $validated = $request->validate($rules, [
            'nama.required'      => 'Nama wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah digunakan akun lain.',
            'role.required'      => 'Role wajib dipilih.',
            'role.in'            => 'Role tidak valid.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min'       => 'Password minimal 8 karakter.',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()
            ->route('admin.users.show', $user->id_user)
            ->with('success', "Data pengguna {$user->nama} berhasil diperbarui.");
    }

    /* ─── DESTROY ─────────────────────────────────────────────── */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Cegah admin menghapus akunnya sendiri
        if ($user->id_user === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $nama = $user->nama;
        $user->delete();

        /*
         * CATATAN: Nomor urut di tabel bukan id_user dari DB, melainkan
         * nomor baris ($loop->iteration) yang dihitung ulang setiap kali
         * halaman dimuat. Sehingga setelah hapus, nomor otomatis rapi
         * kembali dari 1 tanpa perlu reset AUTO_INCREMENT.
         */

        return redirect()
            ->route('admin.users.index')
            ->with('success', "Akun pengguna {$nama} berhasil dihapus.");
    }
}
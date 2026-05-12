<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Redirect dinamis setelah register berdasarkan role.
     * HARUS method, bukan property $redirectTo = '...'
     */
    protected function redirectTo()
    {
        return match (auth()->user()->role) {
            'admin' => '/admin/dashboard',
            'guru'  => '/guru/dashboard',
            'siswa' => '/home-siswa',
            default => '/tamu/dashboard',
        };
    }

    /**
     * Validasi — field harus sama persis dengan name di form blade.
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nama'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role'     => ['required', 'string', 'in:admin,guru,siswa,tamu'],
            'no_hp'    => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'nama.required'      => 'Nama lengkap wajib diisi.',
            'email.unique'       => 'Email sudah terdaftar.',
            'role.required'      => 'Silakan pilih role.',
            'role.in'            => 'Role tidak valid.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);
    }

    /**
     * Simpan user — key array harus cocok dengan $fillable di Model User.
     */
    protected function create(array $data)
    {
        return User::create([
            'nama'     => $data['nama'],        // ✅ bukan 'name'
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => $data['role'],
            'no_hp'    => $data['no_hp'] ?? null,
        ]);
    }
}
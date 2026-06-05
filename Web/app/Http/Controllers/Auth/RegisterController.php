<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    use RegistersUsers;

    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    | Handles user registration with role-based redirect, enhanced validation,
    | rate limiting, and structured error messages in Bahasa Indonesia.
    */

    public function __construct()
    {
        $this->middleware('guest');
    }

    // ─────────────────────────────────────────
    // Show Registration Form
    // ─────────────────────────────────────────

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // ─────────────────────────────────────────
    // Handle Registration Request
    // ─────────────────────────────────────────

    public function register(Request $request)
    {
        // ── Rate Limiting: 5 attempts per minute per IP ──
        $key = 'register:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()
                ->withInput()
                ->withErrors([
                    'email' => "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik.",
                ]);
        }

        RateLimiter::hit($key, 60);

        // ── Validate ──
        $this->validator($request->all())->validate();

        // ── Create User ──
        $user = $this->create($request->all());

        // ── Fire Registered Event (triggers email verification if enabled) ──
        event(new Registered($user));

        // ── Auto Login ──
        Auth::login($user);

        // ── Clear rate limiter on success ──
        RateLimiter::clear($key);

        // ── Redirect ──
        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    // ─────────────────────────────────────────
    // Redirect After Register (role-based)
    // ─────────────────────────────────────────

    protected function redirectTo()
    {
        $role = strtolower(auth()->user()->role ?? 'pengunjung');

        return match ($role) {
            'admin'      => '/admin/dashboard',
            'guru'       => '/guru/dashboard',
            'siswa'      => '/home-siswa',
            'pengunjung' => '/pengunjung/dashboard',
            default      => '/login',
        };
    }

    // ─────────────────────────────────────────
    // Validator — comprehensive rules
    // ─────────────────────────────────────────

    protected function validator(array $data): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($data, [
            'nama' => [
                'required',
                'string',
                'min:2',
                'max:255',
                'regex:/^[\pL\s\-\.]+$/u',   // only letters, spaces, hyphens, dots
            ],
            'email' => [
                'required',
                'string',
                'email:rfc,dns',
                'max:255',
                'unique:users,email',
            ],
            'role' => [
                'required',
                'string',
                'in:admin,guru,siswa,pengunjung',
            ],
            'no_hp' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^(\+62|62|0)[0-9]{8,13}$/',   // Indonesian phone format
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers(),
            ],
            'terms' => [
                'accepted',
            ],
        ], [
            // ── Field: nama ──
            'nama.required'      => 'Nama lengkap wajib diisi.',
            'nama.min'           => 'Nama minimal 2 karakter.',
            'nama.max'           => 'Nama terlalu panjang (maks. 255 karakter).',
            'nama.regex'         => 'Nama hanya boleh mengandung huruf, spasi, dan tanda hubung.',

            // ── Field: email ──
            'email.required'     => 'Alamat email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email ini sudah terdaftar. Gunakan email lain atau masuk.',
            'email.max'          => 'Email terlalu panjang.',

            // ── Field: role ──
            'role.required'      => 'Silakan pilih role Anda.',
            'role.in'            => 'Role yang dipilih tidak valid.',

            // ── Field: no_hp ──
            'no_hp.regex'        => 'Format nomor HP tidak valid. Contoh: 081234567890',
            'no_hp.max'          => 'Nomor HP terlalu panjang.',

            // ── Field: password ──
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.letters'   => 'Password harus mengandung huruf.',
            'password.mixed'     => 'Password harus mengandung huruf besar dan kecil.',
            'password.numbers'   => 'Password harus mengandung minimal satu angka.',

            // ── Field: terms ──
            'terms.accepted'     => 'Anda harus menyetujui syarat dan ketentuan.',
        ]);
    }

    // ─────────────────────────────────────────
    // Create User
    // ─────────────────────────────────────────

    protected function create(array $data): User
    {
        return User::create([
            'nama'     => trim($data['nama']),
            'email'    => strtolower(trim($data['email'])),
            'password' => Hash::make($data['password']),
            'role'     => strtolower($data['role']),
            'no_hp'    => $data['no_hp'] ?? null,
        ]);
    }

    // ─────────────────────────────────────────
    // After Registered Hook (optional)
    // ─────────────────────────────────────────

    protected function registered(Request $request, $user)
    {
        // Hook for additional logic after registration
        // e.g. send welcome notification, log event, etc.
        // Return null to continue to redirectPath()
        return null;
    }
}
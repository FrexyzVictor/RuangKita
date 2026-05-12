<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect setelah login berdasarkan role.
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
     * Field login yang dipakai — default Laravel 'email', sudah sesuai.
     */
    public function username()
    {
        return 'email';
    }

    /**
     * Pesan error login gagal dalam Bahasa Indonesia.
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw \Illuminate\Validation\ValidationException::withMessages([
            'email' => ['Email atau password salah.'],
        ]);
    }
}
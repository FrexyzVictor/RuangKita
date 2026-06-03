<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {

            if (Auth::guard($guard)->check()) {

                $role = strtolower(auth()->user()->role);

                return match ($role) {

                    'admin' => redirect('/admin/dashboard'),

                    'guru' => redirect('/guru/dashboard'),

                    'siswa' => redirect('/home-siswa'),

                    'pengunjung' => redirect('/pengunjung/dashboard'),

                    default => redirect('/login'),
                };
            }
        }

        return $next($request);
    }
}
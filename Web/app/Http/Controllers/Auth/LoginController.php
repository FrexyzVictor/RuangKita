<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected function redirectTo()
    {
        $role = auth()->user()->role;

        if($role == 'admin'){

            return '/admin/dashboard';

        }elseif($role == 'guru'){

            return '/guru/dashboard';

        }elseif($role == 'siswa'){

            return '/siswa/dashboard';

        }else{

            return '/tamu/dashboard';

        }
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
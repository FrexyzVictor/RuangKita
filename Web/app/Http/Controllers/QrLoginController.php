<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class QrLoginController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('qr_code', $request->qr_code)->first();

        if (!$user) {

            return response()->json([
                'success' => false
            ]);

        }

        Auth::login($user);

        return response()->json([
            'success' => true,
            'redirect' => url('/dashboard')
        ]);
    }
}
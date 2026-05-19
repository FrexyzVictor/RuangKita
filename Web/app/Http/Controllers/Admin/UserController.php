<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);

        $stats = [
            'total' => User::count(),
        ];

        return view('admin.users.index', compact(
            'users',
            'stats'
        ));
    }

    public function show($id)
    {
        return view('admin.users.show', compact('id'));
    }

    public function edit($id)
    {
        return view('admin.users.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        return back();
    }

    public function destroy($id)
    {
        return back();
    }
}
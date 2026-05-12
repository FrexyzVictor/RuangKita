<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'nama' => 'RuangKita',
            'email' => 'ruangkitasmkn64gmail.com',
            'password' => 'adminruangkita',
            'role' => 'admin',
            'no_hp' => '085220007279',
            'alamat' => 'none',
            'email_verified_at' => now(),
            'created_at' => now(),
            "updated_at" => now(),
        ]);
    }
}

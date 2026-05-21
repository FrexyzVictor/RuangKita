<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'nama' => 'Admin RuangKita',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 'admin',
            'no_hp' => '085220007279',
            'alamat' => 'none',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'nama' => 'Guru RuangKita',
            'email' => 'guru@gmail.com',
            'password' => Hash::make('Guru'),
            'role' => 'Guru',
            'no_hp' => '085220007279',
            'alamat' => 'none',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('users')->insert([
            'nama' => 'Siswa RuangKita',
            'email' => 'siswa@gmail.com',
            'password' => Hash::make('siswa'),
            'role' => 'Siswa',
            'no_hp' => '085220007279',
            'alamat' => 'none',
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

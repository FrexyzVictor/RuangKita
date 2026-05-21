<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([

            [
                'nama' => 'RuangKita',
                'email' => 'ruangkitasmkn64@gmail.com',
                'password' => Hash::make('adminruangkita'),
                'role' => 'admin',
                'anggota' => null,
                'no_hp' => '085220007279',
                'alamat' => 'none',
                'email_verified_at' => now(),
                'phone_verified_at' => now(),
                'qr_code' => 'ADMIN-RUANGKITA',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nama' => 'Guru RuangKita',
                'email' => 'guru@ruangkita.com',
                'password' => Hash::make('guru'),
                'role' => 'user',
                'anggota' => 'MPK',
                'no_hp' => '085220007279',
                'alamat' => 'none',
                'email_verified_at' => now(),
                'phone_verified_at' => now(),
                'qr_code' => 'GURU-RUANGKITA',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nama' => 'Siswa RuangKita',
                'email' => 'siswa@ruangkita.com',
                'password' => Hash::make('siswa'),
                'role' => 'user',
                'anggota' => 'OSIS',
                'no_hp' => '085220007279',
                'alamat' => 'none',
                'email_verified_at' => now(),
                'phone_verified_at' => now(),
                'qr_code' => 'SISWA-RUANGKITA',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nama' => 'Pengunjung RuangKita',
                'email' => 'pengunjung@ruangkita.com',
                'password' => Hash::make('pengunjung'),
                'role' => 'user',
                'anggota' => 'PMR',
                'no_hp' => '085220007279',
                'alamat' => 'none',
                'email_verified_at' => now(),
                'phone_verified_at' => now(),
                'qr_code' => 'PENGUNJUNG-RUANGKITA',
                'created_at' => now(),
                'updated_at' => now(),
            ]

        ]);
    }
}
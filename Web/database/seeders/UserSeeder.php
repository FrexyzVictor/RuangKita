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
<<<<<<< HEAD
=======

>>>>>>> e0f7c11e5622a9026bc2546c61da836cdde692c7
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
                'nama' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin'),
                'role' => 'admin',
                'anggota' => null,
                'no_hp' => '085220007279',
                'alamat' => 'none',
                'email_verified_at' => now(),
                'phone_verified_at' => now(),
                'qr_code' => 'ADMIN',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nama' => 'Guru RuangKita',
                'email' => 'guru@ruangkita.com',
                'password' => Hash::make('Guru'),
                'role' => 'user',
                'anggota' => null,
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

<<<<<<< HEAD
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
            ],
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
=======
            // [
            //     'nama' => 'Pengunjung RuangKita',
            //     'email' => 'pengunjung@ruangkita.com',
            //     'password' => Hash::make('pengunjung'),
            //     'role' => 'user',
            //     'anggota' => 'PMR',
            //     'no_hp' => '085220007279',
            //     'alamat' => 'none',
            //     'email_verified_at' => now(),
            //     'phone_verified_at' => now(),
            //     'qr_code' => 'PENGUNJUNG-RUANGKITA',
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ]

>>>>>>> e0f7c11e5622a9026bc2546c61da836cdde692c7
        ]);
    }
}

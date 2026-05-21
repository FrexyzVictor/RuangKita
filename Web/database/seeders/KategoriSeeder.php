<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kategori_fasilitas')->insert([
            [
                'nama_kategori' => 'Ruang Kelas',
                'deskripsi' => 'Fasilitas ruang kelas untuk kegiatan belajar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Laboratorium(Bengkel)',
                'deskripsi' => 'Fasilitas laboratorium sekolah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Aula',
                'deskripsi' => 'Aula untuk seminar dan acara sekolah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Lapangan',
                'deskripsi' => 'Lapangan olahraga dan kegiatan outdoor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
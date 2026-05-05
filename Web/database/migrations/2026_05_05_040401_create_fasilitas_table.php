<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fasilitas', function (Blueprint $table) {
            $table->id('id_fasilitas');

            $table->unsignedBigInteger('id_kategori');

            $table->string('nama_fasilitas');
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 12, 2);
            $table->string('lokasi');
            $table->integer('kapasitas')->nullable();

            $table->enum('status', [
                'tersedia',
                'maintenance',
                'tidak_tersedia'
            ])->default('tersedia');

            $table->timestamps();

            $table->foreign('id_kategori')
                ->references('id_kategori')
                ->on('kategori_fasilitas')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fasilitas');
    }
};
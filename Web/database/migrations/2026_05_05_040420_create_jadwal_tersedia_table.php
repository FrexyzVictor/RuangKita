<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_tersedia', function (Blueprint $table) {
            $table->id('id_jadwal');

            $table->unsignedBigInteger('id_fasilitas');

            $table->date('tanggal');

            $table->time('jam_mulai');
            $table->time('jam_selesai');

            $table->enum('status', [
                'tersedia',
                'dibooking'
            ])->default('tersedia');

            $table->timestamps();

            $table->foreign('id_fasilitas')
                ->references('id_fasilitas')
                ->on('fasilitas')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_tersedia');
    }
};
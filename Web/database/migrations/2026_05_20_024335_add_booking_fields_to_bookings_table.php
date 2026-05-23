<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {

            $table->string('organisasi')->nullable();

            $table->string('penanggung_jawab');

            $table->text('tujuan');

            $table->date('tanggal');

            $table->time('jam_mulai');

            $table->time('jam_selesai');

        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {

            $table->dropColumn([
                'organisasi',
                'penanggung_jawab',
                'tujuan',
                'tanggal',
                'jam_mulai',
                'jam_selesai'
            ]);

        });
    }
};
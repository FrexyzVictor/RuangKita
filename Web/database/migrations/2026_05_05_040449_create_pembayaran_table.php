<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluasi_booking', function (Blueprint $table) {

            $table->id('id_evaluasi');

            $table->unsignedBigInteger('id_booking');

            $table->integer('rating');

            $table->text('komentar')->nullable();

            $table->timestamps();

            $table->foreign('id_booking')
                ->references('id_booking')
                ->on('bookings')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluasi_booking');
    }
};
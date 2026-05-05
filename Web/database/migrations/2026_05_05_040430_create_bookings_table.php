<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {

            $table->id('id_booking');

            $table->unsignedBigInteger('id_user');

            $table->date('tanggal_booking');

            $table->dateTime('tanggal_mulai');
            $table->dateTime('tanggal_selesai');

            $table->decimal('total_harga', 12, 2)->default(0);

            $table->enum('status', [
                'pending',
                'dibayar',
                'selesai',
                'dibatalkan'
            ])->default('pending');

            $table->text('catatan')->nullable();

            $table->timestamps();

            $table->foreign('id_user')
                ->references('id_user')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
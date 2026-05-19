<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_details', function (Blueprint $table) {

            $table->id('id_detail');

            $table->unsignedBigInteger('id_booking');
            $table->unsignedBigInteger('id_fasilitas');

            $table->integer('qty')->default(1);
            $table->decimal('harga_satuan', 12, 2);
            $table->decimal('subtotal', 12, 2);

            $table->timestamps();

            $table->foreign('id_booking')
                  ->references('id_booking')->on('bookings')
                  ->onDelete('cascade');

            $table->foreign('id_fasilitas')
                  ->references('id_fasilitas')->on('fasilitas')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_details');
    }
};
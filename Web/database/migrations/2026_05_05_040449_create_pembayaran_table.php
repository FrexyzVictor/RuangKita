<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tabel riwayat pembayaran (DP + pelunasan) — khusus tamu.
     * Siswa & guru tidak punya record di sini karena GRATIS.
     */
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {

            $table->id('id_pembayaran');

            $table->unsignedBigInteger('id_booking');

            /**
             * jenis: 'dp' | 'pelunasan'
             */
            $table->enum('jenis', ['dp', 'pelunasan']);

            $table->decimal('jumlah', 12, 2);

            /**
             * metode: transfer / tunai / lainnya
             * Pembayaran offline saja (sesuai kebutuhan: lunas di tempat / transfer manual)
             */
            $table->enum('metode', ['tunai', 'transfer', 'lainnya'])->default('tunai');

            /** Bukti transfer (nullable, opsional upload) */
            $table->string('bukti_transfer')->nullable();

            /** Dicatat oleh admin */
            $table->unsignedBigInteger('dicatat_oleh')->nullable();

            $table->text('keterangan')->nullable();

            $table->timestamps();

            $table->foreign('id_booking')
                  ->references('id_booking')->on('bookings')
                  ->onDelete('cascade');

            $table->foreign('dicatat_oleh')
                  ->references('id_user')->on('users')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
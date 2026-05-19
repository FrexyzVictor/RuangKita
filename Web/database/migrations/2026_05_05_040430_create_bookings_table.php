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

            /**
             * STATUS ALUR BOOKING
             * ─────────────────────────────────────────────────────────
             * pending      → baru dibuat, menunggu konfirmasi admin
             * dikonfirmasi → admin sudah menyetujui (online confirmed)
             * dp_dibayar   → tamu sudah bayar DP, menunggu pelunasan
             * lunas        → tamu sudah bayar penuh / siswa&guru otomatis
             * selesai      → pemakaian selesai
             * dibatalkan   → dibatalkan admin/user
             * ─────────────────────────────────────────────────────────
             */
            $table->enum('status', [
                'pending',
                'dikonfirmasi',
                'dp_dibayar',
                'lunas',
                'belum_lunas',   // tamu: sudah konfirmasi tapi belum bayar penuh
                'selesai',
                'dibatalkan',
            ])->default('pending');

            /**
             * PEMBAYARAN (khusus tamu)
             * null  = tidak perlu bayar (siswa / guru)
             * nilai = nominal DP yang sudah dibayar
             */
            $table->decimal('dp_amount', 12, 2)->nullable();
            $table->decimal('sisa_pembayaran', 12, 2)->nullable();

            /** Siapa yang konfirmasi & kapan */
            $table->unsignedBigInteger('confirmed_by')->nullable();
            $table->timestamp('confirmed_at')->nullable();

            /** Catatan tambahan */
            $table->text('catatan')->nullable();
            $table->text('catatan_admin')->nullable();   // catatan dari admin saat approve/cancel

            $table->timestamps();

            // FK
            $table->foreign('id_user')
                  ->references('id_user')->on('users')
                  ->onDelete('cascade');

            $table->foreign('confirmed_by')
                  ->references('id_user')->on('users')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
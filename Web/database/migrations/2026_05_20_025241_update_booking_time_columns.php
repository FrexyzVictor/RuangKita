<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
{
    Schema::table('bookings', function (Blueprint $table) {

        // hapus kolom lama
        $table->dropColumn([
            'tanggal_mulai',
            'tanggal_selesai'
        ]);

    });
}

public function down(): void
{
    Schema::table('bookings', function (Blueprint $table) {

        // balikin lagi kalau rollback
        $table->dateTime('tanggal_mulai')->nullable();

        $table->dateTime('tanggal_selesai')->nullable();
    });
}
};
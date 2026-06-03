<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalTersedia extends Model
{
    protected $table = 'jadwal_tersedia';

    protected $primaryKey = 'id_jadwal';

    protected $fillable = [
        'id_fasilitas',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'status',
    ];

    public function fasilitas()
    {
        return $this->belongsTo(
            Fasilitas::class,
            'id_fasilitas',
            'id_fasilitas'
        );
    }
}

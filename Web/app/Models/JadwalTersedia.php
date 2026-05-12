<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JadwalTersedia extends Model
{
    use HasFactory;

    protected $table = 'jadwal_tersedia';

    protected $primaryKey = 'id_jadwal';

    protected $fillable = [
        'id_fasilitas',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'status'
    ];

    public function fasilitas()
    {
        return $this->belongsTo(Fasilitas::class, 'id_fasilitas');
    }
}
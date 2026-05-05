<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fasilitas extends Model
{
    use HasFactory;

    protected $table = 'fasilitas';

    protected $primaryKey = 'id_fasilitas';

    protected $fillable = [
        'id_kategori',
        'nama_fasilitas',
        'deskripsi',
        'harga',
        'lokasi',
        'kapasitas',
        'status'
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriFasilitas::class, 'id_kategori');
    }

    public function jadwal()
    {
        return $this->hasMany(JadwalTersedia::class, 'id_fasilitas');
    }

    public function bookingDetails()
    {
        return $this->hasMany(BookingDetail::class, 'id_fasilitas');
    }
}
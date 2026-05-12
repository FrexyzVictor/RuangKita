<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BookingDetail extends Model
{
    use HasFactory;

    protected $table = 'booking_details';

    protected $primaryKey = 'id_detail';

    protected $fillable = [
        'id_booking',
        'id_fasilitas',
        'qty',
        'harga_satuan',
        'subtotal'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'id_booking');
    }

    public function fasilitas()
    {
        return $this->belongsTo(Fasilitas::class, 'id_fasilitas');
    }
}
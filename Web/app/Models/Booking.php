<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings';

    protected $primaryKey = 'id_booking';

    protected $fillable = [
        'id_user',
        'tanggal_booking',
        'tanggal_mulai',
        'tanggal_selesai',
        'total_harga',
        'status',
        'catatan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function bookingDetails()
    {
        return $this->hasMany(BookingDetail::class, 'id_booking');
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'id_booking');
    }

    public function evaluasi()
    {
        return $this->hasMany(EvaluasiBooking::class, 'id_booking');
    }
}
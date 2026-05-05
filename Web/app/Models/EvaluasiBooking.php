<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EvaluasiBooking extends Model
{
    use HasFactory;

    protected $table = 'evaluasi_booking';

    protected $primaryKey = 'id_evaluasi';

    protected $fillable = [
        'id_booking',
        'rating',
        'komentar'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'id_booking');
    }
}
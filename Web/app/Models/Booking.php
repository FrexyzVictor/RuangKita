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
        'catatan',
    ];

    protected $casts = [
        'tanggal_booking'  => 'date',
        'tanggal_mulai'    => 'datetime',
        'tanggal_selesai'  => 'datetime',
        'total_harga'      => 'decimal:2',
    ];

    /* ─── RELATIONSHIPS ─── */

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function details()
    {
        return $this->hasMany(BookingDetail::class, 'id_booking');
    }

    public function evaluasi()
    {
        return $this->hasOne(EvaluasiBooking::class, 'id_booking');
    }

    /* ─── SCOPES ─── */

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai');
    }

    /* ─── ACCESSORS ─── */

    public function getDurasiAttribute()
    {
        if (!$this->tanggal_mulai || !$this->tanggal_selesai) return null;
        $minutes = $this->tanggal_mulai->diffInMinutes($this->tanggal_selesai);
        $h = intdiv($minutes, 60);
        $m = $minutes % 60;
        return ($h > 0 ? "{$h} jam " : '') . ($m > 0 ? "{$m} menit" : '');
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending'    => 'Pending',
            'dibayar'    => 'Sudah Dibayar',
            'selesai'    => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
            default      => ucfirst($this->status),
        };
    }

    public function getStatusClassAttribute()
    {
        return match($this->status) {
            'pending'    => 'status-warning',
            'dibayar'    => 'status-info',
            'selesai'    => 'status-success',
            'dibatalkan' => 'status-danger',
            default      => 'status-default',
        };
    }
}
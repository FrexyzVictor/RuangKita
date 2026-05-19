<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    protected $primaryKey = 'id_booking';

    protected $fillable = [
        'id_user',
        'tanggal_booking',
        'tanggal_mulai',
        'tanggal_selesai',
        'total_harga',
        'status',
        'dp_amount',
        'sisa_pembayaran',
        'confirmed_by',
        'confirmed_at',
        'catatan',
        'catatan_admin',
    ];

    protected $casts = [
        'tanggal_booking' => 'date',
        'tanggal_mulai'   => 'datetime',
        'tanggal_selesai' => 'datetime',
        'confirmed_at'    => 'datetime',
        'total_harga'     => 'decimal:2',
        'dp_amount'       => 'decimal:2',
        'sisa_pembayaran' => 'decimal:2',
    ];

    /* ─── Relasi ──────────────────────────────────────────────── */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function confirmedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmed_by', 'id_user');
    }

    public function details(): HasMany
    {
        return $this->hasMany(BookingDetail::class, 'id_booking', 'id_booking');
    }

    public function pembayaran(): HasMany
    {
        return $this->hasMany(Pembayaran::class, 'id_booking', 'id_booking');
    }

    /* ─── Helpers ─────────────────────────────────────────────── */

    /**
     * Apakah user pemesan adalah tamu? (wajib bayar)
     */
    public function isTamu(): bool
    {
        return $this->user?->role === 'tamu';
    }

    /**
     * Apakah gratis? (siswa & guru)
     */
    public function isFree(): bool
    {
        return in_array($this->user?->role, ['siswa', 'guru']);
    }

    /**
     * Total yang sudah dibayar dari tabel pembayaran
     */
    public function totalDibayar(): float
    {
        return (float) $this->pembayaran()->sum('jumlah');
    }

    /**
     * Sisa yang belum dibayar
     */
    public function sisaBayar(): float
    {
        return max(0, (float) $this->total_harga - $this->totalDibayar());
    }

    /**
     * Persentase lunas (untuk progress bar)
     */
    public function persenLunas(): int
    {
        if ($this->total_harga <= 0) return 100;
        return (int) min(100, ($this->totalDibayar() / $this->total_harga) * 100);
    }

    /**
     * Label status untuk ditampilkan
     */
    public function statusLabel(): string
    {
        return match($this->status) {
            'pending'       => 'Menunggu Konfirmasi',
            'dikonfirmasi'  => 'Dikonfirmasi',
            'dp_dibayar'    => 'DP Dibayar',
            'belum_lunas'   => 'Belum Lunas',
            'lunas'         => 'Lunas',
            'selesai'       => 'Selesai',
            'dibatalkan'    => 'Dibatalkan',
            default         => ucfirst($this->status),
        };
    }

    /**
     * CSS class untuk badge status
     */
    public function statusBadgeClass(): string
    {
        return match($this->status) {
            'pending'       => 'badge-warning',
            'dikonfirmasi'  => 'badge-info',
            'dp_dibayar'    => 'badge-dp',
            'belum_lunas'   => 'badge-danger',
            'lunas'         => 'badge-success',
            'selesai'       => 'badge-selesai',
            'dibatalkan'    => 'badge-canceled',
            default         => 'badge-default',
        };
    }

    /* ─── Scopes ──────────────────────────────────────────────── */

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeBelumLunas($query)
    {
        return $query->whereIn('status', ['dp_dibayar', 'belum_lunas']);
    }

    public function scopeAktif($query)
    {
        return $query->whereNotIn('status', ['selesai', 'dibatalkan']);
    }
}
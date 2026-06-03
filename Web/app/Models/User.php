<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /*
    |--------------------------------------------------------------------------
    | Model Configuration
    |--------------------------------------------------------------------------
    */

    protected $table      = 'users';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
        'no_hp',
        'alamat',
        'avatar',
        'email_verified_at',
        'phone_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | ROLE CONSTANTS
    |--------------------------------------------------------------------------
    */

    const ROLE_ADMIN      = 'admin';
    const ROLE_GURU       = 'guru';
    const ROLE_SISWA      = 'siswa';
    const ROLE_PENGUNJUNG = 'pengunjung';

    const ROLES = [
        self::ROLE_ADMIN,
        self::ROLE_GURU,
        self::ROLE_SISWA,
        self::ROLE_PENGUNJUNG,
    ];

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /**
     * Display name — capitalize each word.
     */
    public function getDisplayNamaAttribute(): string
    {
        return Str::title($this->nama);
    }

    /**
     * Role label in Bahasa Indonesia.
     */
    public function getRoleLabelAttribute(): string
    {
        return match (strtolower($this->role)) {
            self::ROLE_ADMIN      => 'Administrator',
            self::ROLE_GURU       => 'Guru',
            self::ROLE_SISWA      => 'Siswa',
            self::ROLE_PENGUNJUNG => 'Pengunjung',
            default               => ucfirst($this->role),
        };
    }

    /**
     * Initials (e.g. "Budi Santoso" → "BS")
     */
    public function getInitialsAttribute(): string
    {
        $words = explode(' ', trim($this->nama));
        $init  = '';
        foreach (array_slice($words, 0, 2) as $word) {
            $init .= strtoupper(mb_substr($word, 0, 1));
        }
        return $init ?: 'U';
    }

    /**
     * Avatar URL — gravatar fallback if no custom avatar.
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        $hash = md5(strtolower(trim($this->email)));
        return "https://www.gravatar.com/avatar/{$hash}?d=identicon&s=200";
    }

    /*
    |--------------------------------------------------------------------------
    | ROLE HELPERS
    |--------------------------------------------------------------------------
    */

    public function isAdmin(): bool
    {
        return strtolower($this->role) === self::ROLE_ADMIN;
    }

    public function isGuru(): bool
    {
        return strtolower($this->role) === self::ROLE_GURU;
    }

    public function isSiswa(): bool
    {
        return strtolower($this->role) === self::ROLE_SISWA;
    }

    public function isPengunjung(): bool
    {
        return strtolower($this->role) === self::ROLE_PENGUNJUNG;
    }

    public function hasRole(string $role): bool
    {
        return strtolower($this->role) === strtolower($role);
    }

    /**
     * Dashboard route based on role.
     */
    public function dashboardRoute(): string
    {
        return match (strtolower($this->role)) {
            self::ROLE_ADMIN      => '/admin/dashboard',
            self::ROLE_GURU       => '/guru/dashboard',
            self::ROLE_SISWA      => '/home-siswa',
            self::ROLE_PENGUNJUNG => '/pengunjung/dashboard',
            default               => '/login',
        };
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function bookings()
    {
        return $this->hasMany(\App\Models\Booking::class, 'id_user', 'id_user');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeByRole($query, string $role)
    {
        return $query->where('role', strtolower($role));
    }

    public function scopeVerified($query)
    {
        return $query->whereNotNull('email_verified_at');
    }

    public function scopeActive($query)
    {
        return $query->whereNotNull('email_verified_at');
    }
}
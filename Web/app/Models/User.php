<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';

    protected $primaryKey = 'id_user';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
        'no_hp',
        'alamat',
        'email_verified_at',
        'phone_verified_at'
    ];

    protected $hidden = [
        'password'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'id_user');
    }
}
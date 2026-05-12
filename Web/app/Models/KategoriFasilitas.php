<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KategoriFasilitas extends Model
{
    use HasFactory;

    protected $table = 'kategori_fasilitas';

    protected $primaryKey = 'id_kategori';

    protected $fillable = [
        'nama_kategori',
        'deskripsi'
    ];

    public function fasilitas()
    {
        return $this->hasMany(Fasilitas::class, 'id_kategori');
    }
}
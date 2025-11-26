<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;
    protected $table = 'kendaraan';
    protected $fillable = [
        'merek',
        'nama_kendaraan',
        'id_kategori',
        'status',
        'foto',
        'deskripsi',
    ];

    public function kategori(){
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function harga(){
        return $this->hasMany(Harga::class, 'id_kendaraan');
    }
    public function rental(){
        return $this->hasMany(Rental::class, 'id_kendaraan');
    }
}

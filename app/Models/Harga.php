<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Harga extends Model
{
    use HasFactory;
    protected $table = 'harga';
    protected $fillable = ['id_kendaraan', 'harga_sewa_per_hari', 'tanggal_berlaku'];
    public function kendaraan(){
        return $this->belongsTo(Kendaraan::class, 'id_kendaraan');
    }
}

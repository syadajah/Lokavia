<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;
    protected $table = 'pembayaran';
    protected $fillable = ['id_rental', 'metode_bayar', 'jumlah_bayar', 'tanggal_bayar'];
    public function rental(){
        return $this->belongsTo(Rental::class, 'id_rental');
    }
}

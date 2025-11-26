<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPembayaran extends Model
{
    use HasFactory;
    protected $table = 'detailpembayaran';
    protected $fillable = ['id_rental', 'denda', 'tanggal_pengembalian_aktual'];
    public function rental(){
        return $this->belongsTo(Rental::class, 'id_rental');
    }
}

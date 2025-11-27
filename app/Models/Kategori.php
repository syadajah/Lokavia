<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';

    protected $fillable = ['nama_kategori', 'jenis'];

    public function kendaraan()
    {
        return $this->hasMany(Kendaraan::class, 'id_kategori');
    }

    // Helper: ambil semua kategori unik
    public static function getUniqueKategori()
    {
        return self::select('nama_kategori')->distinct()->orderBy('nama_kategori')->pluck('nama_kategori');
    }

    // Helper: ambil jenis berdasarkan nama kategori
    public static function getJenisByKategori($namaKategori)
    {
        return self::where('nama_kategori', $namaKategori)->pluck('jenis', 'id');
    }
}

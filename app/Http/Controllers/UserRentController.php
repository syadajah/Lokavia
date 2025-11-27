<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Kategori;
use Illuminate\Http\Request;

class UserRentController extends Controller
{
    public function index()
    {
        // Ambil semua kendaraan dengan relasi kategori dan harga terbaru
        $kendaraan = Kendaraan::with([
            'kategori',
            'harga' => function ($query) {
                $query->where('tanggal_berlaku', '<=', now())->orderBy('tanggal_berlaku', 'desc')->limit(1);
            },
        ])->get();

        // Tambahkan harga terbaru ke setiap kendaraan
        $kendaraan->each(function ($item) {
            $item->harga_terbaru = $item->harga->first();
        });

        // Ambil kategori unik untuk filter
        $kategoriList = Kategori::getUniqueKategori();

        return view('user.dashboard', compact('kendaraan', 'kategoriList'));
    }
}

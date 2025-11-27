<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\User;
use App\Models\Harga;
use App\Models\Kategori;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik Utama
        $totalKendaraan = Kendaraan::count();
        $kendaraanTersedia = Kendaraan::where('status', 'tersedia')->count();
        $kendaraanDisewa = Kendaraan::where('status', 'tidak_tersedia')->count();
        $totalUser = User::where('role', 'user')->count(); // Asumsi ada kolom role
        $totalKategori = Kategori::distinct('nama_kategori')->count();

        // Data untuk Chart/Grafik
        $kendaraanPerKategori = Kendaraan::select('id_kategori')->selectRaw('count(*) as total')->with('kategori')->groupBy('id_kategori')->get();

        // Kendaraan Terbaru
        $kendaraanTerbaru = Kendaraan::with('kategori')->orderBy('created_at', 'desc')->take(5)->get();

        // Harga Rata-rata
        $rataRataHarga = Harga::avg('harga_sewa_per_hari') ?? 0;

        return view('admin.dashboard', compact('totalKendaraan', 'kendaraanTersedia', 'kendaraanDisewa', 'totalUser', 'totalKategori', 'kendaraanPerKategori', 'kendaraanTerbaru', 'rataRataHarga'));
    }
}

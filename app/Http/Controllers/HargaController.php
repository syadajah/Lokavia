<?php

namespace App\Http\Controllers;

use App\Models\Harga;
use App\Models\Kendaraan;
use Illuminate\Http\Request;

class HargaController extends Controller
{
    public function index()
    {
        $harga = Harga::with('kendaraan')->orderBy('created_at', 'desc')->get();
        $kendaraan = Kendaraan::where('status', 'tersedia')->get();

        return view('admin.kendaraan.createHarga', compact('harga', 'kendaraan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kendaraan' => 'required|exists:kendaraan,id',
            'harga_sewa_per_hari' => 'required|numeric|min:0',
            'tanggal_berlaku' => 'required|date',
        ]);

        Harga::create([
            'id_kendaraan' => $request->id_kendaraan,
            'harga_sewa_per_hari' => $request->harga_sewa_per_hari,
            'tanggal_berlaku' => $request->tanggal_berlaku,
        ]);

        return redirect()->route('admin.harga.index')->with('success', 'Harga berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_kendaraan' => 'required|exists:kendaraan,id',
            'harga_sewa_per_hari' => 'required|numeric|min:0',
            'tanggal_berlaku' => 'required|date',
        ]);

        $harga = Harga::findOrFail($id);

        $harga->update([
            'id_kendaraan' => $request->id_kendaraan,
            'harga_sewa_per_hari' => $request->harga_sewa_per_hari,
            'tanggal_berlaku' => $request->tanggal_berlaku,
        ]);

        return redirect()->route('admin.harga.index')->with('success', 'Harga berhasil diupdate');
    }

    public function destroy($id)
    {
        $harga = Harga::findOrFail($id);
        $harga->delete();

        return redirect()->route('admin.harga.index')->with('success', 'Harga berhasil dihapus');
    }
}

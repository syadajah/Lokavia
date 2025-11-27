<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KendaraanController extends Controller
{
    public function index()
    {
        $kendaraan = Kendaraan::with('kategori')->get();

        // Ambil kategori unik (tanpa duplikat nama_kategori)
        $kategoriList = Kategori::getUniqueKategori();

        return view('admin.kendaraan.createKendaraan', compact('kendaraan', 'kategoriList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'merek' => 'required|string|max:255',
            'nama_kendaraan' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id',
            'status' => 'required|in:tersedia,tidak_tersedia',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('kendaraan', 'public');
        }

        Kendaraan::create($validated);

        return redirect()->route('admin.kendaraan.index')->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $kendaraan = Kendaraan::findOrFail($id);

        $validated = $request->validate([
            'merek' => 'required|string|max:255',
            'nama_kendaraan' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id',
            'status' => 'required|in:tersedia,tidak_tersedia',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        if ($request->hasFile('foto')) {
            if ($kendaraan->foto && Storage::disk('public')->exists($kendaraan->foto)) {
                Storage::disk('public')->delete($kendaraan->foto);
            }

            $validated['foto'] = $request->file('foto')->store('kendaraan', 'public');
        }

        $kendaraan->update($validated);

        return redirect()->route('admin.kendaraan.index')->with('success', 'Kendaraan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kendaraan = Kendaraan::findOrFail($id);

        if ($kendaraan->foto && Storage::disk('public')->exists($kendaraan->foto)) {
            Storage::disk('public')->delete($kendaraan->foto);
        }

        $kendaraan->delete();

        return redirect()->route('admin.kendaraan.index')->with('success', 'Kendaraan berhasil dihapus.');
    }
}

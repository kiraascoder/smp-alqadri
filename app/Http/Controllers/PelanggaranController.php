<?php

namespace App\Http\Controllers;

use App\Models\Pelanggaran;
use Illuminate\Http\Request;

class PelanggaranController extends Controller
{
    public function pelanggaran()
    {
        $pelanggarans = Pelanggaran::all();
        return view('siswa.pelanggaran', compact('pelanggarans'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'skor' => 'required|integer|min:0',
        ]);

        Pelanggaran::create($request->all());

        return redirect()->route('siswa.pelanggaran')->with('success', 'Pelanggaran berhasil ditambahkan.');
    }

    public function destroy(Pelanggaran $pelanggaran)
    {
        $pelanggaran->delete();

        return redirect()->route('siswa.pelanggaran')->with('success', 'Pelanggaran berhasil dihapus.');
    }
}

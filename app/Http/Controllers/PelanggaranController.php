<?php

namespace App\Http\Controllers;

use App\Models\Pelanggaran;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PelanggaranController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'kategori' => ['required', Rule::in(['ringan', 'sedang', 'berat'])],
            'deskripsi' => ['required', 'string', 'max:2000'],
            'skor' => ['required', 'integer', 'min:1'],
        ]);

        Pelanggaran::create($data);
        return back()->with('success', 'Jenis pelanggaran berhasil ditambahkan.');
    }

    public function update(Request $request, Pelanggaran $pelanggaran)
    {
        $data = $request->validate([
            'kategori' => ['required', Rule::in(['ringan', 'sedang', 'berat'])],
            'deskripsi' => ['required', 'string', 'max:2000'],
            'skor' => ['required', 'integer', 'min:1'],
        ]);

        $pelanggaran->update($data);
        return back()->with('success', 'Jenis pelanggaran berhasil diperbarui.');
    }

    public function destroy(Pelanggaran $pelanggaran)
    {
        if ($pelanggaran->riwayat()->exists()) {
            return back()->with('error', 'Jenis pelanggaran sudah digunakan dan tidak dapat dihapus.');
        }

        $pelanggaran->delete();
        return back()->with('success', 'Jenis pelanggaran berhasil dihapus.');
    }
}

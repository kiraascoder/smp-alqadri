<?php

namespace App\Http\Controllers;

use App\Models\Pelanggaran;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PelanggaranController extends Controller
{
    public function pelanggaran()
    {
        $pelanggarans = Pelanggaran::query()
            ->orderByRaw("FIELD(kategori, 'Ringan', 'Sedang', 'Sangat Berat')")
            ->orderBy('skor')
            ->orderBy('deskripsi')
            ->paginate(15);

        return view('siswa.pelanggaran', compact('pelanggarans'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        Pelanggaran::create($data);

        return back()->with('success', 'Jenis pelanggaran berhasil ditambahkan.');
    }

    public function update(Request $request, Pelanggaran $pelanggaran)
    {
        $pelanggaran->update($this->validateData($request));

        return back()->with('success', 'Jenis pelanggaran berhasil diperbarui.');
    }

    public function destroy($pelanggaran)
    {
        $pelanggaran = Pelanggaran::findOrFail($pelanggaran);

        if ($pelanggaran->riwayat()->exists()) {
            return back()->with('error', 'Jenis pelanggaran tidak dapat dihapus karena sudah memiliki riwayat siswa.');
        }

        $pelanggaran->delete();

        return back()->with('success', 'Jenis pelanggaran berhasil dihapus.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'kategori' => ['required', Rule::in(['Ringan', 'Sedang', 'Sangat Berat'])],
            'deskripsi' => ['required', 'string', 'max:2000'],
            'skor' => ['required', 'integer', 'min:1', 'max:1000'],
        ], [
            'kategori.in' => 'Kategori harus Ringan, Sedang, atau Sangat Berat.',
        ]);
    }
}

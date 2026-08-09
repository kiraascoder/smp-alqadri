<?php

namespace App\Http\Controllers;

use App\Models\Kebajikan;
use App\Models\RiwayatKebajikan;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class KebajikanController extends Controller
{
    public function adminIndex()
    {
        $kebajikans = Kebajikan::query()
            ->orderBy('skor')
            ->orderBy('deskripsi')
            ->paginate(15);

        return view('admin.kebajikan', compact('kebajikans'));
    }

    public function adminStore(Request $request)
    {
        $data = $request->validate([
            'deskripsi' => ['required', 'string', 'max:1000', 'unique:kebajikans,deskripsi'],
            'skor' => ['required', 'integer', 'min:1', 'max:1000'],
        ]);

        Kebajikan::create($data);

        return back()->with('success', 'Jenis kebajikan berhasil ditambahkan.');
    }

    public function adminUpdate(Request $request, Kebajikan $kebajikan)
    {
        $data = $request->validate([
            'deskripsi' => [
                'required',
                'string',
                'max:1000',
                Rule::unique('kebajikans', 'deskripsi')->ignore($kebajikan->id),
            ],
            'skor' => ['required', 'integer', 'min:1', 'max:1000'],
        ]);

        $kebajikan->update($data);

        return back()->with('success', 'Jenis kebajikan berhasil diperbarui.');
    }

    public function adminDestroy(Kebajikan $kebajikan)
    {
        if ($kebajikan->riwayat()->exists()) {
            return back()->with('error', 'Jenis kebajikan sudah digunakan pada riwayat siswa dan tidak dapat dihapus.');
        }

        $kebajikan->delete();

        return back()->with('success', 'Jenis kebajikan berhasil dihapus.');
    }

    public function guruIndex()
    {
        $siswas = Siswa::with(['user', 'kelas'])
            ->orderBy('id')
            ->get();

        $kebajikans = Kebajikan::query()
            ->orderBy('skor')
            ->orderBy('deskripsi')
            ->get();

        $riwayat = RiwayatKebajikan::with(['siswa.user', 'siswa.kelas', 'kebajikan'])
            ->where('created_by', Auth::id())
            ->latest('tanggal')
            ->latest('id')
            ->paginate(15);

        return view('guru.kebajikan', compact('siswas', 'kebajikans', 'riwayat'));
    }

    public function guruStore(Request $request)
    {
        $data = $request->validate([
            'siswa_id' => ['required', 'exists:siswa,id'],
            'kebajikan_id' => ['required', 'exists:kebajikans,id'],
            'tanggal' => ['required', 'date'],
            'keterangan' => ['nullable', 'string', 'max:1000'],
        ]);

        $kebajikan = Kebajikan::findOrFail($data['kebajikan_id']);

        DB::transaction(function () use ($data, $kebajikan) {
            RiwayatKebajikan::create([
                'siswa_id' => $data['siswa_id'],
                'kebajikan_id' => $kebajikan->id,
                'created_by' => Auth::id(),
                'tanggal' => $data['tanggal'],
                'skor' => $kebajikan->skor,
                'keterangan' => $data['keterangan'] ?? null,
            ]);
        });

        return back()->with('success', "Poin kebajikan +{$kebajikan->skor} berhasil diberikan.");
    }

    public function guruDestroy(RiwayatKebajikan $riwayat)
    {
        abort_unless((int) $riwayat->created_by === (int) Auth::id(), 403);

        $riwayat->delete();

        return back()->with('success', 'Riwayat poin kebajikan berhasil dihapus.');
    }
}

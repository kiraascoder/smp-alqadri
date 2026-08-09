<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Pelanggaran;
use App\Models\RiwayatPelanggaran;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class GuruController extends Controller
{
    public function index()
    {
        return view('guru.dashboard');
    }

    public function siswa()
    {
        $siswas = Siswa::with(['user', 'kelas'])
            ->orderBy('id')
            ->get();

        return view('guru.siswa', compact('siswas'));
    }

    public function profil()
    {
        $guru = Guru::with('user')
            ->where('user_id', Auth::id())
            ->first();

        return view('guru.profil', compact('guru'));
    }

    public function edit(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ]);

        $avatarPath = $user->avatar;

        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'no_hp' => $data['no_hp'] ?? null,
            'avatar' => $avatarPath,
        ]);

        return redirect()
            ->route('guru.profil')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $data = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak sesuai.',
        ]);

        $user = $request->user();

        if (! Hash::check($data['current_password'], $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Password saat ini tidak sesuai.',
            ]);
        }

        if (Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages([
                'password' => 'Password baru tidak boleh sama dengan password saat ini.',
            ]);
        }

        // Model User memakai cast "hashed", sehingga password akan di-hash otomatis.
        $user->update(['password' => $data['password']]);

        return redirect()
            ->route('guru.profil')
            ->with('success_password', 'Password berhasil diubah.');
    }

    public function detailSkorsing($id)
    {
        $skorsing = RiwayatPelanggaran::with([
            'siswa.user',
            'siswa.kelas',
            'pelanggaran',
        ])
            ->where('created_by', Auth::id())
            ->findOrFail($id);

        return response()->json([
            'id' => $skorsing->id,
            'siswa' => [
                'name' => $skorsing->siswa?->nama_tampil ?? '-',
                'nisn' => $skorsing->siswa?->nisn ?? '-',
                'score_bk' => $skorsing->siswa?->score_bk ?? 0,
                'kelas' => $skorsing->siswa?->kelas?->nama_kelas ?? '-',
            ],
            'pelanggaran' => [
                'deskripsi' => $skorsing->pelanggaran?->deskripsi ?? '-',
                'skor' => $skorsing->skor ?? $skorsing->pelanggaran?->skor ?? 0,
            ],
            'tanggal' => optional($skorsing->tanggal)->format('Y-m-d'),
            'keterangan' => $skorsing->keterangan,
        ]);
    }

    public function skorsing()
    {
        $siswas = Siswa::with(['user', 'kelas'])
            ->orderBy('id')
            ->get();

        $pelanggarans = Pelanggaran::query()
            ->orderByRaw("FIELD(kategori, 'Ringan', 'Sedang', 'Sangat Berat')")
            ->orderBy('skor')
            ->orderBy('deskripsi')
            ->get();

        $riwayat = RiwayatPelanggaran::with(['siswa.user', 'siswa.kelas', 'pelanggaran'])
            ->where('created_by', Auth::id())
            ->latest('tanggal')
            ->latest('id')
            ->paginate(15);

        return view('guru.skorsing', compact('siswas', 'riwayat', 'pelanggarans'));
    }

    public function pelanggaran()
    {
        $pelanggarans = Pelanggaran::query()
            ->orderByRaw("FIELD(kategori, 'Ringan', 'Sedang', 'Sangat Berat')")
            ->orderBy('skor')
            ->orderBy('deskripsi')
            ->paginate(15);

        return view('guru.pelanggaran', compact('pelanggarans'));
    }

    public function tambahSkorsing(Request $request)
    {
        $data = $request->validate([
            'siswa_id' => ['required', 'exists:siswa,id'],
            'pelanggaran_id' => ['required', 'exists:pelanggarans,id'],
            'tanggal' => ['required', 'date'],
            'keterangan' => ['nullable', 'string', 'max:1000'],
        ]);

        $siswa = Siswa::with('user')->findOrFail($data['siswa_id']);
        $pelanggaran = Pelanggaran::findOrFail($data['pelanggaran_id']);

        DB::transaction(function () use ($data, $siswa, $pelanggaran) {
            RiwayatPelanggaran::create([
                'siswa_id' => $siswa->id,
                'pelanggaran_id' => $pelanggaran->id,
                'created_by' => Auth::id(),
                'tanggal' => $data['tanggal'],
                'skor' => $pelanggaran->skor,
                'keterangan' => $data['keterangan'] ?? null,
            ]);

            $siswa->score_bk = ($siswa->score_bk ?? 0) + (int) $pelanggaran->skor;
            $siswa->save();
        });

        return redirect()
            ->route('guru.skorsing')
            ->with('success', "Pelanggaran {$siswa->nama_tampil} berhasil dicatat ({$pelanggaran->skor} poin).");
    }

    public function destroySkorsing($id)
    {
        $riwayat = RiwayatPelanggaran::with(['siswa', 'pelanggaran'])
            ->where('created_by', Auth::id())
            ->findOrFail($id);

        DB::transaction(function () use ($riwayat) {
            $skor = (int) ($riwayat->skor ?? $riwayat->pelanggaran?->skor ?? 0);
            $siswa = $riwayat->siswa;

            if ($siswa) {
                $siswa->score_bk = max(0, (int) ($siswa->score_bk ?? 0) - $skor);
                $siswa->save();
            }

            $riwayat->delete();
        });

        return redirect()
            ->route('guru.skorsing')
            ->with('success', 'Riwayat pelanggaran berhasil dihapus.');
    }
}

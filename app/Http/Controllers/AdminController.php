<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\OrangTua;
use App\Models\Pelanggaran;
use App\Models\RiwayatPelanggaran;
use App\Models\Siswa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        $guruCount = Guru::count();
        $siswaCount = Siswa::count();
        $orangTuaCount = OrangTua::count();
        $skorsingBulanIniCount = RiwayatPelanggaran::whereDate('tanggal', '>=', Carbon::now()->startOfMonth())->count();
        $riwayat = RiwayatPelanggaran::with(['siswa.kelas', 'pelanggaran', 'creator'])
            ->latest('tanggal')
            ->take(8)
            ->get();

        return view('admin.dashboard', compact(
            'guruCount',
            'siswaCount',
            'orangTuaCount',
            'skorsingBulanIniCount',
            'riwayat'
        ));
    }

    public function guru()
    {
        $gurus = Guru::with('user')->latest()->paginate(10);
        return view('admin.guru', compact('gurus'));
    }

    public function storeGuru(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'jenis_kelamin' => ['nullable', Rule::in(['Laki-Laki', 'Perempuan'])],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'no_hp' => $data['no_hp'] ?? null,
                'jenis_kelamin' => $data['jenis_kelamin'] ?? null,
                'password' => Hash::make($data['password']),
                'role' => User::ROLE_GURU,
            ]);

            Guru::create(['user_id' => $user->id]);
        });

        return back()->with('success', 'Guru berhasil ditambahkan.');
    }

    public function editGuru(Request $request, int $id)
    {
        $guru = Guru::with('user')->findOrFail($id);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($guru->user_id)],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'jenis_kelamin' => ['nullable', Rule::in(['Laki-Laki', 'Perempuan'])],
        ]);

        $guru->user->update($data);

        return back()->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroyGuru(int $id)
    {
        $guru = Guru::with('user')->findOrFail($id);
        $guru->user->delete();

        return back()->with('success', 'Guru berhasil dihapus.');
    }

    public function kelas()
    {
        $kelasList = Kelas::withCount('siswa')->orderBy('nama_kelas')->paginate(15);
        return view('admin.kelas', compact('kelasList'));
    }

    public function storeKelas(Request $request)
    {
        $data = $request->validate([
            'nama_kelas' => ['required', 'string', 'max:100', 'unique:kelas,nama_kelas'],
        ]);

        Kelas::create($data);
        return back()->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function updateKelas(Request $request, Kelas $kelas)
    {
        $data = $request->validate([
            'nama_kelas' => ['required', 'string', 'max:100', Rule::unique('kelas', 'nama_kelas')->ignore($kelas->id)],
        ]);

        $kelas->update($data);
        return back()->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroyKelas(Kelas $kelas)
    {
        if ($kelas->siswa()->exists()) {
            return back()->with('error', 'Kelas masih digunakan oleh siswa dan tidak dapat dihapus.');
        }

        $kelas->delete();
        return back()->with('success', 'Kelas berhasil dihapus.');
    }

    public function siswa()
    {
        $siswas = Siswa::with(['kelas', 'orangTua.user'])->latest()->paginate(10);
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $orangTuaList = OrangTua::with('user')->get()->sortBy(fn ($ortu) => $ortu->user?->name);

        return view('admin.siswa', compact('siswas', 'kelasList', 'orangTuaList'));
    }

    public function storeSiswa(Request $request)
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kelas_id' => ['required', 'exists:kelas,id'],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'orang_tua_id' => ['nullable', 'exists:orang_tua,id'],
        ]);

        Siswa::create($data + ['score_bk' => 0]);

        return back()->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function updateSiswa(Request $request, int $id)
    {
        $siswa = Siswa::findOrFail($id);

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kelas_id' => ['required', 'exists:kelas,id'],
            'tanggal_lahir' => ['required', 'date', 'before:today'],
            'orang_tua_id' => ['nullable', 'exists:orang_tua,id'],
        ]);

        $siswa->update($data);

        return back()->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroySiswa(int $id)
    {
        Siswa::findOrFail($id)->delete();
        return back()->with('success', 'Siswa berhasil dihapus.');
    }

    public function orangTua()
    {
        $ortu = OrangTua::with(['user', 'siswa.kelas'])->latest()->paginate(10);
        $siswaList = Siswa::with('kelas')->whereNull('orang_tua_id')->orderBy('nama')->get();

        return view('admin.orang-tua', compact('ortu', 'siswaList'));
    }

    public function registerOrtu(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'jenis_kelamin' => ['nullable', Rule::in(['Laki-Laki', 'Perempuan'])],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'anak' => ['nullable', 'array'],
            'anak.*' => ['integer', Rule::exists('siswa', 'id')->whereNull('orang_tua_id')],
        ]);

        DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'no_hp' => $data['no_hp'] ?? null,
                'jenis_kelamin' => $data['jenis_kelamin'] ?? null,
                'password' => Hash::make($data['password']),
                'role' => User::ROLE_ORANG_TUA,
            ]);

            $ortu = OrangTua::create(['user_id' => $user->id]);

            if (! empty($data['anak'])) {
                Siswa::whereIn('id', $data['anak'])->update(['orang_tua_id' => $ortu->id]);
            }
        });

        return back()->with('success', 'Akun orang tua berhasil dibuat.');
    }

    public function destroyOrangTua(int $id)
    {
        $ortu = OrangTua::with('user')->findOrFail($id);
        $ortu->user->delete();

        return back()->with('success', 'Orang tua berhasil dihapus. Relasi anak dilepas otomatis.');
    }

    public function pelanggaran()
    {
        $pelanggarans = Pelanggaran::latest()->paginate(10);
        return view('admin.pelanggaran', compact('pelanggarans'));
    }

    public function skorsing()
    {
        $siswas = Siswa::with('kelas')->orderBy('nama')->get();
        $pelanggarans = Pelanggaran::orderBy('kategori')->orderBy('deskripsi')->get();
        $riwayat = RiwayatPelanggaran::with(['siswa.kelas', 'pelanggaran', 'creator'])
            ->latest('tanggal')
            ->paginate(15);

        return view('admin.skorsing', compact('siswas', 'pelanggarans', 'riwayat'));
    }

    public function tambahSkorsing(Request $request)
    {
        $data = $request->validate([
            'siswa_id' => ['required', 'exists:siswa,id'],
            'pelanggaran_id' => ['required', 'exists:pelanggarans,id'],
            'tanggal' => ['required', 'date'],
            'keterangan' => ['nullable', 'string', 'max:2000'],
        ]);

        DB::transaction(function () use ($data) {
            $siswa = Siswa::lockForUpdate()->findOrFail($data['siswa_id']);
            $pelanggaran = Pelanggaran::findOrFail($data['pelanggaran_id']);

            RiwayatPelanggaran::create($data + [
                'created_by' => auth()->id(),
                'skor' => $pelanggaran->skor,
            ]);
            $siswa->increment('score_bk', $pelanggaran->skor);
        });

        return back()->with('success', 'Skorsing berhasil ditambahkan.');
    }

    public function destroySkorsing(int $id)
    {
        DB::transaction(function () use ($id) {
            $riwayat = RiwayatPelanggaran::with('pelanggaran')->lockForUpdate()->findOrFail($id);
            $siswa = Siswa::lockForUpdate()->findOrFail($riwayat->siswa_id);
            $siswa->score_bk = max(0, $siswa->score_bk - $riwayat->skor);
            $siswa->save();
            $riwayat->delete();
        });

        return back()->with('success', 'Skorsing berhasil dihapus dan skor siswa disesuaikan.');
    }

    public function detailSkorsing(int $id)
    {
        $skorsing = RiwayatPelanggaran::with(['siswa.kelas', 'pelanggaran', 'creator'])->findOrFail($id);

        return response()->json([
            'id' => $skorsing->id,
            'siswa' => [
                'nama' => $skorsing->siswa?->nama,
                'kelas' => $skorsing->siswa?->kelas?->nama_kelas,
                'score_bk' => $skorsing->siswa?->score_bk,
            ],
            'pelanggaran' => [
                'kategori' => $skorsing->pelanggaran?->kategori,
                'deskripsi' => $skorsing->pelanggaran?->deskripsi,
                'skor' => $skorsing->skor,
            ],
            'tanggal' => optional($skorsing->tanggal)->format('Y-m-d'),
            'keterangan' => $skorsing->keterangan,
            'dibuat_oleh' => $skorsing->creator?->name ?? 'User dihapus',
        ]);
    }

    public function rekapSkorsing(Request $request)
    {
        $query = RiwayatPelanggaran::with(['siswa.kelas', 'pelanggaran', 'creator']);

        $query->when($request->filled('tanggal_mulai'), fn ($q) => $q->whereDate('tanggal', '>=', $request->tanggal_mulai));
        $query->when($request->filled('tanggal_selesai'), fn ($q) => $q->whereDate('tanggal', '<=', $request->tanggal_selesai));
        $query->when($request->filled('pembuat_id'), fn ($q) => $q->where('created_by', $request->pembuat_id));
        $query->when($request->filled('siswa_id'), fn ($q) => $q->where('siswa_id', $request->siswa_id));
        $query->when($request->filled('pelanggaran_id'), fn ($q) => $q->where('pelanggaran_id', $request->pelanggaran_id));
        $query->when($request->filled('kelas_id'), function ($q) use ($request) {
            $q->whereHas('siswa', fn ($s) => $s->where('kelas_id', $request->kelas_id));
        });

        $rekap = $query->latest('tanggal')->paginate(25)->withQueryString();
        $pembuatList = User::whereIn('role', [User::ROLE_ADMIN, User::ROLE_GURU])->orderBy('name')->get();
        $siswaList = Siswa::orderBy('nama')->get();
        $kelasList = Kelas::orderBy('nama_kelas')->get();
        $pelanggaranList = Pelanggaran::orderBy('deskripsi')->get();

        return view('admin.rekap-skorsing', compact(
            'rekap', 'pembuatList', 'siswaList', 'kelasList', 'pelanggaranList'
        ));
    }
}

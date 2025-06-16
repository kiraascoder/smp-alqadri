<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Pelanggaran;
use App\Models\RiwayatPelanggaran;
use App\Models\Siswa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        $guruCount = Guru::count();
        $siswaCount = Siswa::count();
        $pelanggaranCount = RiwayatPelanggaran::where('created_at', '>=', Carbon::now()->subMonth())->count();
        $guruBkCount = User::where('role', 'guru_bk')->count();
        $pelanggaranTerbaru = RiwayatPelanggaran::latest()->take(5)->get();
        $siswas = Siswa::with(['user', 'kelas'])->get();
        $riwayat = RiwayatPelanggaran::with(['siswa', 'pelanggaran'])
            ->orderBy('tanggal', 'desc')
            ->paginate(10);
        $pelanggarans = Pelanggaran::all();
        return view('admin.dashboard', compact('guruCount', 'siswaCount', 'pelanggaranCount', 'guruBkCount', 'riwayat'));
    }


    public function guru()
    {
        $gurus = Guru::with('user')
            ->whereHas('user', function ($query) {
                $query->where('role', 'guru');
            })
            ->paginate(10);

        return view('admin.guru', compact('gurus'));
    }

    public function storeGuru(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'no_hp' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'Nama Wajib Diisi',
            'email.required' => 'Silahkan Masukkan Email Anda',
            'email.email' => 'Format email yang Anda masukkan tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Silahkan Masukkan Password Anda',
            'password.min' => 'Password minimal terdiri dari 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'role' => 'guru',
        ]);

        Guru::create([
            'user_id' => $user->id,
        ]);

        return redirect()->route('admin.guru')->with('success', 'Guru berhasil ditambahkan.');
    }
    public function storeGuruBk(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'no_hp' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'Nama Wajib Diisi',
            'email.required' => 'Silahkan Masukkan Email Anda',
            'email.email' => 'Format email yang Anda masukkan tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Silahkan Masukkan Password Anda',
            'password.min' => 'Password minimal terdiri dari 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'role' => 'guru_bk',
        ]);


        Guru::create([
            'user_id' => $user->id,
        ]);

        return redirect()->route('admin.bk')->with('success', 'Guru berhasil ditambahkan.');
    }

    public function editGuru(Request $request, $id)
    {
        $guru = Guru::find($id);

        if (!$guru) {
            return redirect()->back()->withErrors('User tidak ditemukan.');
        }

        $user = $guru->user;

        if (!$guru) {
            return redirect()->back()->withErrors('Data guru tidak ditemukan untuk user ini.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'no_hp' => 'nullable|string|max:20',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
        ]);


        return redirect()->route('admin.guru')->with('success', 'Profil berhasil diperbarui.');
    }

    public function editGurubk(Request $request, $id)
    {
        $guru = Guru::find($id);

        if (!$guru) {
            return redirect()->back()->withErrors('User tidak ditemukan.');
        }

        $user = $guru->user;

        if (!$guru) {
            return redirect()->back()->withErrors('Data guru tidak ditemukan untuk user ini.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'no_hp' => 'nullable|string|max:20',

        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
        ]);



        return redirect()->route('admin.bk')->with('success', 'Profil berhasil diperbarui.');
    }

    public function destroySkorsing($id)
    {
        try {
            $skorsing = RiwayatPelanggaran::with(['siswa.user', 'pelanggaran'])
                ->where('id', $id)
                ->first();

            if (!$skorsing) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data pelanggaran tidak ditemukan'
                ], 404);
            }

            $siswa = $skorsing->siswa;
            $siswaName = $siswa->user->name ?? 'Siswa';
            $pelanggaranDesc = $skorsing->pelanggaran->deskripsi ?? 'Pelanggaran';
            $poin = $skorsing->pelanggaran->skor ?? 0; // skor berasal dari relasi pelanggaran

            // Tambahkan kembali poin ke skor siswa
            if ($siswa && $siswa->score_bk !== null) {
                $siswa->score_bk -= $poin;
                $siswa->save();
            }

            $skorsing->delete();

            return response()->json([
                'success' => true,
                'message' => "Data pelanggaran {$pelanggaranDesc} untuk siswa {$siswaName} berhasil dihapus",
                'data' => [
                    'deleted_id' => $id,
                    'siswa_name' => $siswaName,
                    'pelanggaran' => $pelanggaranDesc,
                    'score_bk_now' => $siswa->score_bk
                ]
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error hapus skorsing: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data'
            ], 500);
        }
    }
    public function destroyGuruBk($id)
    {
        try {
            $guru = Guru::findOrFail($id);
            if ($guru->user) {
                $guru->user->delete();
            }
            $guru->delete();

            return redirect()->route('admin.bk')->with('success', 'Guru BK berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.bk')->with('error', 'Gagal menghapus guru BK.');
        }
    }
    public function destroyGuru($id)
    {
        try {
            $guru = Guru::findOrFail($id);
            if ($guru->user) {
                $guru->user->delete();
            }
            $guru->delete();

            return redirect()->route('admin.guru')->with('success', 'Guru berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.guru')->with('error', 'Gagal menghapus guru.');
        }
    }

    public function destroySiswa($id)
    {
        try {
            $siswa = Siswa::findOrFail($id);
            if ($siswa->user) {
                $siswa->user->delete();
            }
            $siswa->delete();

            return redirect()->route('admin.siswa')->with('success', 'Siswa berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.siswa')->with('error', 'Gagal menghapus siswa.');
        }
    }

    public function siswa()
    {
        $siswas = Siswa::with('user')
            ->whereHas('user', function ($query) {
                $query->where('role', 'siswa');
            })
            ->paginate(10);
        $kelasList = Kelas::all();
        return view('admin.siswa', compact('siswas', 'kelasList'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nisn' => 'required|unique:siswa,nisn',
            'password' => 'required|string|min:6|confirmed',
            'kelas_id' => 'required|exists:kelas,id',
        ], [
            'name.required' => 'Nama Wajib Diisi',
            'email.required' => 'Silahkan Masukkan Email Anda',
            'email.email' => 'Format email yang Anda masukkan tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Silahkan Masukkan Password Anda',
            'password.min' => 'Password minimal terdiri dari 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
            'kelas_id.required' => 'Kelas harus dipilih',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
        ]);


        Siswa::create([
            'user_id' => $user->id,
            'nisn' => $request->nisn,
            'nama' => $request->name,
            'kelas_id' => $request->kelas_id,
            'score_bk' => 0,
        ]);

        return redirect()->route('admin.siswa')->with('success', 'Siswa berhasil ditambahkan!');
    }

    public function bk()
    {
        $gurus = Guru::with('user')
            ->whereHas('user', function ($query) {
                $query->where('role', 'guru_bk');
            })
            ->paginate(10);
        return view('admin.bk', compact('gurus'));
    }

    public function konseling()
    {
        return view('admin.konseling');
    }

    public function pelanggaran()
    {
        $pelanggarans = Pelanggaran::paginate(10);
        return view('admin.pelanggaran', compact('pelanggarans'));
    }

    public function riwayat()
    {
        $siswas = Siswa::with(['user', 'kelas'])->get();
        $riwayat = RiwayatPelanggaran::with(['siswa', 'pelanggaran'])
            ->orderBy('tanggal', 'desc')
            ->paginate(10);
        $pelanggarans = Pelanggaran::all();
        return view('admin.riwayat', compact('siswas', 'riwayat', 'pelanggarans'));
    }


    public function detailRiwayat()
    {
        $siswas = Siswa::with(['user', 'kelas'])->get();
        $riwayat = RiwayatPelanggaran::with(['siswa', 'pelanggaran'])
            ->orderBy('tanggal', 'desc')
            ->paginate(10);
        $pelanggarans = Pelanggaran::all();
        return view('admin.detail-riwayat', compact('siswas', 'riwayat', 'pelanggarans'));
    }

    public function destroyRiwayat($id)
    {
        try {
            $riwayat = RiwayatPelanggaran::findOrFail($id);
            $riwayat->delete();
            return redirect()->route('admin.riwayat')->with('success', 'Riwayat berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.riwayat')->with('error', 'Gagal menghapus riwayat.');
        }
    }
}

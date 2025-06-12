<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Pelanggaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }


    public function guru()
    {
        $guru = Guru::with('user')
            ->whereHas('user', function ($query) {
                $query->where('role', 'guru');
            })
            ->get();
        return view('admin.guru', compact('guru'));
    }

    public function storeGuru(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nip' => 'required|unique:siswa,nisn',
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
            'nip.required' => 'NIP harus diisi',
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
            'nip' => $request->nip,
        ]);

        return redirect()->route('admin.guru')->with('success', 'Guru berhasil ditambahkan.');
    }
    public function storeGuruBk(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nip' => 'required|unique:siswa,nisn',
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
            'nip.required' => 'NIP harus diisi',
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
            'nip' => $request->nip,
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
            'nip' => ['required', 'string', 'max:20', Rule::unique('guru')->ignore($guru->id)],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
        ]);

        $guru->update([
            'nip' => $request->nip,
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
            'nip' => ['required', 'string', 'max:20', Rule::unique('guru')->ignore($guru->id)],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
        ]);

        $guru->update([
            'nip' => $request->nip,
        ]);

        return redirect()->route('admin.bk')->with('success', 'Profil berhasil diperbarui.');
    }

    public function destroyGuruBk($id)
    {
        $guru = Guru::find($id);
        $guru->user()->delete();
        $guru->delete();
        return redirect()->route('admin.bk')->with('success', 'Guru berhasil dihapus.');
    }
    public function destroyGuru($id)
    {
        $guru = Guru::find($id);
        $guru->user()->delete();
        $guru->delete();
        return redirect()->route('admin.guru')->with('success', 'Guru berhasil dihapus.');
    }

    public function siswa()
    {
        return view('admin.siswa');
    }

    public function bk()
    {
        $guru = Guru::with('user')
            ->whereHas('user', function ($query) {
                $query->where('role', 'guru_bk');
            })
            ->get();
        return view('admin.bk', compact('guru'));
    }

    public function laporan()
    {
        return view('admin.laporan');
    }

    public function konseling()
    {
        return view('admin.konseling');
    }

    public function pengaduan()
    {
        return view('admin.pengaduan');
    }

    public function pelanggaran()
    {
        $pelanggarans = Pelanggaran::paginate(10);
        return view('admin.pelanggaran', compact('pelanggarans'));
    }
    public function riwayat()
    {
        $pelanggarans = Pelanggaran::paginate(10);
        return view('admin.riwayat', compact('pelanggarans'));
    }
}

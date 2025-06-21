<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SesiController extends Controller
{
    public function LoginView()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect('/admin/dashboard');
            } elseif ($user->role === 'guru') {
                return redirect('/guru/profil');
            } elseif ($user->role === 'guru_bk') {
                return redirect('/bk/profil');
            } elseif ($user->role === 'siswa') {
                return redirect('/siswa/profil-siswa');
            } else {
                return redirect('/');
            }
        }

        return view('auth.login');
    }

    public function registerView()
    {
        $kelas = Kelas::all();
        return view('auth.register', compact('kelas'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'Silahkan Masukkan Email Anda',
            'email.email' => 'Format email yang Anda masukkan tidak valid',
            'password.required' => 'Silahkan Masukkan Password Anda',
            'password.min' => 'Password minimal terdiri dari 6 karakter',
        ]);

        $infologin = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($infologin, $request->has('remember'))) {
            $user = Auth::user();

            if ($user->role == "admin") {
                return redirect('/admin/dashboard');
            } elseif ($user->role == "guru") {
                return redirect('/guru/profil');
            } elseif ($user->role == "guru_bk") {
                return redirect('/bk/profil');
            } elseif ($user->role == 'siswa') {
                return redirect('/siswa/profil-siswa');
            }
        }
        return redirect('/login')->withErrors(['login' => 'Login Gagal, Email atau Password tidak sesuai!'])->withInput();
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'nisn' => 'required|unique:siswa,nisn',
            'password' => 'required|string|min:6|confirmed',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'kelas_id' => 'required|exists:kelas,id',
        ], [
            'name.required' => 'Nama Wajib Diisi',
            'email.required' => 'Silahkan Masukkan Email Anda',
            'email.email' => 'Format email yang Anda masukkan tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Silahkan Masukkan Password Anda',
            'password.min' => 'Password minimal terdiri dari 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
            'jenis_kelamin.required' => 'Jenis kelamin harus dipilih',
            'kelas_id.required' => 'Kelas harus dipilih',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'jenis_kelamin' => $request->jenis_kelamin,
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

        return redirect('/login')->with('success', 'Registrasi berhasil! Silahkan Login Ke Akun Anda.');
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}

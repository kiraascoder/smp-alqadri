<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Siswa;

class SiswaController extends Controller
{
    public function index()
    {
        return view('siswa.dashboard');
    }
    public function profil()
    {
        $siswa = Siswa::with(['user', 'kelas'])->where('user_id', Auth::id())->first();
        $kelasList = Kelas::all();
        return view('siswa.profil', compact('siswa', 'kelasList'));
    }


    public function edit(Request $request)
    {
        $user = auth()->user();
        $siswa = $user->siswa;

        $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'no_hp' => 'nullable|string|max:20',
            'nisn' => ['required', 'string', 'max:20', Rule::unique('siswa')->ignore($siswa->id)],
            'kelas_id' => ['required', 'exists:kelas,id'],
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        } else {
            $avatarPath = $user->avatar; // keep existing
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'avatar' => $avatarPath,
        ]);

        $siswa->update([
            'nisn' => $request->nisn,
            'kelas_id' => $request->kelas_id,
        ]);

        return redirect()->route('siswa.profil')->with('success', 'Profil berhasil diperbarui.');
    }
}

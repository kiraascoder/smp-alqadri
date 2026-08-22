<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SesiController extends Controller
{
    public function LoginView()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        return view('auth.login');
    }

    public function login(Request $request)
{
    // Jika sudah login, langsung arahkan sesuai role
    if (Auth::check()) {
        return $this->redirectByRole(Auth::user());
    }


    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required', 'string', 'min:6'],
    ]);


    if (! Auth::attempt($credentials, $request->boolean('remember'))) {

        return back()
            ->withErrors([
                'login' => 'Email atau password tidak sesuai.'
            ])
            ->onlyInput('email');

    }


    $request->session()->regenerate();


    return $this->redirectByRole(Auth::user());
}
private function redirectByRole($user)
{
    return match ($user->role) {

        'admin' => redirect()->route('admin.dashboard'),

        'guru' => redirect()->route('guru.dashboard'),

        'orang_tua' => redirect()->route('ortu.dashboard'),

        default => redirect()->route('login')

    };
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    private function redirectByRole(User $user)
    {
        return match ($user->role) {
            User::ROLE_ADMIN => redirect()->route('admin.dashboard'),
            User::ROLE_GURU => redirect()->route('guru.dashboard'),
            User::ROLE_ORANG_TUA => redirect()->route('ortu.dashboard'),
            default => $this->invalidRole(),
        };
    }

    private function invalidRole()
    {
        Auth::logout();

        return redirect()->route('login')->withErrors([
            'login' => 'Role akun tidak dikenali.',
        ]);
    }
}

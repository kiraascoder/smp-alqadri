<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        $data = $request->validate([
            'login' => [
                'required',
                'string',
                'max:255',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
            ],
        ]);

        $login = trim($data['login']);
        $password = $data['password'];
        $remember = $request->boolean('remember');

        /*
        |--------------------------------------------------------------------------
        | LOGIN EMAIL
        |--------------------------------------------------------------------------
        |
        | Digunakan oleh Admin dan Guru.
        |
        */

        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            if (! Auth::attempt([
                'email' => $login,
                'password' => $password,
            ], $remember)) {
                return back()
                    ->withErrors([
                        'login' => 'Email atau password tidak sesuai.',
                    ])
                    ->withInput([
                        'login' => $login,
                    ]);
            }

            $request->session()->regenerate();

            return $this->redirectByRole(Auth::user());
        }

        /*
        |--------------------------------------------------------------------------
        | LOGIN ORANG TUA MENGGUNAKAN NOMOR HP
        |--------------------------------------------------------------------------
        */

        $phone = $this->normalizePhone($login);

        if (! $phone) {
            return back()
                ->withErrors([
                    'login' => 'Masukkan email yang valid atau nomor HP yang valid.',
                ])
                ->withInput([
                    'login' => $login,
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Cari khusus akun orang tua
        |--------------------------------------------------------------------------
        |
        | Nomor HP yang sama dengan akun Guru tidak akan menjadi masalah
        | karena pencarian dibatasi role = orang_tua.
        |
        */

        $user = User::query()
            ->where('role', User::ROLE_ORANG_TUA)
            ->where(function ($query) use ($phone) {
                $query
                    ->where('no_hp', $phone)
                    ->orWhere('no_hp', '0' . substr($phone, 2));
            })
            ->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            return back()
                ->withErrors([
                    'login' => 'Nomor HP atau password tidak sesuai.',
                ])
                ->withInput([
                    'login' => $login,
                ]);
        }

        Auth::login($user, $remember);

        $request->session()->regenerate();

        return $this->redirectByRole($user);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with(
                'success',
                'Anda berhasil keluar dari sistem.'
            );
    }

    private function redirectByRole(User $user)
    {
        return match ($user->role) {
            User::ROLE_ADMIN =>
            redirect()->route('admin.dashboard'),

            User::ROLE_GURU =>
            redirect()->route('guru.dashboard'),

            User::ROLE_ORANG_TUA =>
            redirect()->route('ortu.dashboard'),

            default =>
            $this->invalidRole(),
        };
    }

    private function invalidRole()
    {
        Auth::logout();

        return redirect()
            ->route('login')
            ->withErrors([
                'login' => 'Role akun tidak dikenali.',
            ]);
    }

    private function normalizePhone(?string $value): ?string
    {
        $phone = preg_replace(
            '/\D+/',
            '',
            (string) $value
        ) ?? '';

        if ($phone === '') {
            return null;
        }

        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        } elseif (str_starts_with($phone, '8')) {
            $phone = '62' . $phone;
        }

        if (! preg_match('/^628\d{8,12}$/', $phone)) {
            return null;
        }

        return $phone;
    }
}

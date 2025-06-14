<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                if ($user->role === 'admin') {
                    return redirect('/admin/dashboard');
                } elseif ($user->role === 'guru') {
                    return redirect()->route('guru.dashboard');
                } elseif ($user->role === 'guru_bk') {
                    return redirect()->route('bk.dashboard');
                } elseif ($user->role === 'siswa') {
                    return redirect()->route('siswa.profil');
                } else {
                    return redirect('/');
                }
            }
        }

        return $next($request);
    }
}

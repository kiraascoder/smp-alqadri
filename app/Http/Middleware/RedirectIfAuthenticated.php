<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        if (! Auth::check()) {
            return $next($request);
        }

        return match (Auth::user()->role) {
            User::ROLE_ADMIN => redirect()->route('admin.dashboard'),
            User::ROLE_GURU => redirect()->route('guru.dashboard'),
            User::ROLE_ORANG_TUA => redirect()->route('ortu.dashboard'),
            default => redirect('/'),
        };
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $check = Auth::check();
        if (!$check) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($user->is_banned) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->withErrors([
                    'email' => 'Your account has been suspended. Please contact support.'
                ]);
        }

        if ($user->role === 'admin') {
            return $next($request);
        }

        if ($user->role === 'customer') {
            return redirect()->route('dashboard');
        }

        abort(403);

    }
}

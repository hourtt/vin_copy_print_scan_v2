<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        if ($user->is_banned) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->withErrors([
                    'email' => 'Your account has been suspended. Please contact support.',
                ]);
        }

        if ($user->role === 'admin') {
            return redirect('/vin_admin_print_scan_dashboard');
        }

        if ($user->role === 'customer' || empty($user->role)) {
            return $next($request);
        }

        abort(403);
    }
}

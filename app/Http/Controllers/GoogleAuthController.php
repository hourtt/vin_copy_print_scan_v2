<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Throwable;
use Laravel\Socialite\Facades\Socialite;
use App\Models\UserGoogleAuth; 
use Illuminate\Support\Facades\Auth;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $user = Socialite::driver('google')->user();
        } catch (Throwable $e) {
            return redirect()->route('login')->with('error', 'Google authentication failed. Please try again.');
        }

        $existingUser = UserGoogleAuth::where('email', $user->email)->first();

        if ($existingUser) {
            $existingUser->update([
                'google_token' => $user->token,
            ]);
            Auth::guard('google')->login($existingUser, true); 
        } else {
            $newUser = UserGoogleAuth::create([
                'name'         => $user->getName(),
                'email'        => $user->email,
                'google_id'    => $user->getId(), 
                'avatar'       => $user->getAvatar(),
                'google_token' => $user->token,
            ]);
            
            Auth::guard('google')->login($newUser, true);
        }

        return redirect()->route('dashboard');
    }

    public function logout()
    {
        Auth::guard('google')->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('login');
    }
}
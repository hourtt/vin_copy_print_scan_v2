<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ConnectedAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    /**
     * Redirect the user to the provider authentication page.
     */
    public function redirect(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from the provider.
     */
    public function callback(string $provider)
    {
        try {
            /** @var \Laravel\Socialite\Two\User $socialUser */
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'error' => 'Unable to authenticate with ' . ucfirst($provider) . '. Please try again.'
            ]);
        }

        // 1. If user is already authenticated, link the account
        if (Auth::check()) {
            /** @var User $user */
            $user = Auth::user();

            // FIXED: Query ConnectedAccount globally to check across all users
            /** @var ConnectedAccount|null $existingConnection */
            $existingConnection = ConnectedAccount::where('provider_name', $provider)
                ->where('provider_id', $socialUser->getId())
                ->first();

            if ($existingConnection && $existingConnection->user_id !== $user->id) {
                return redirect()->route('profile.edit')->withErrors([
                    'error' => 'This ' . ucfirst($provider) . ' account is already linked to another user.'
                ]);
            }

            // Update or create the connection for the logged-in user
            $user->connectedAccounts()->updateOrCreate(
                [
                    'provider_name' => $provider,
                    'provider_id' => $socialUser->getId(),
                ],
                [
                    'provider_token' => $socialUser->token,
                    'provider_refresh_token' => $socialUser->refreshToken,
                ]
            );

            // Log activity
            $user->securityActivityLogs()->create([
                'action' => 'Connected ' . ucfirst($provider) . ' account',
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'created_at' => now(),
            ]);

            return redirect()->route('profile.edit')->with('status', 'account-connected');
        }

        // 2. User is guest: check if this social account is already linked
        $connectedAccount = ConnectedAccount::where('provider_name', $provider)
            ->where('provider_id', $socialUser->getId())
            ->first();

        if ($connectedAccount) {
            $user = $connectedAccount->user;
            Auth::login($user);

            $connectedAccount->update([
                'provider_token' => $socialUser->token,
                'provider_refresh_token' => $socialUser->refreshToken,
            ]);

            return redirect()->intended(route('dashboard', absolute: false));
        }

        // 3. Ensure the provider supplied an email address before attempting lookup or registration
        $email = $socialUser->getEmail();

        if (!$email) {
            return redirect()->route('login')->withErrors([
                'error' => 'Your ' . ucfirst($provider) . ' account does not provide a public email address. Please make your email address public in your ' . ucfirst($provider) . ' settings and try again.'
            ]);
        }

        // 4. See if a user with this email already exists
        $user = User::where('email', $email)->first();

        if ($user) {
            $user->connectedAccounts()->create([
                'provider_name' => $provider,
                'provider_id' => $socialUser->getId(),
                'provider_token' => $socialUser->token,
                'provider_refresh_token' => $socialUser->refreshToken,
            ]);

            Auth::login($user);
            return redirect()->intended(route('dashboard', absolute: false));
        }

        // 5. Register a new user (FIXED: Fallback to nickname if name is empty)
        $fullName = $socialUser->getName() ?? $socialUser->getNickname() ?? 'User';
        $nameParts = explode(' ', trim($fullName));
        $firstName = $nameParts[0];
        $lastName = count($nameParts) > 1 ? implode(' ', array_slice($nameParts, 1)) : '';

        $user = User::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password' => null,
            'email_verified_at' => now(),
        ]);

        $user->connectedAccounts()->create([
            'provider_name' => $provider,
            'provider_id' => $socialUser->getId(),
            'provider_token' => $socialUser->token,
            'provider_refresh_token' => $socialUser->refreshToken,
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    /**
     * Disconnect a provider from the authenticated user.
     */
    public function disconnect(string $provider)
    {
        $user = Auth::user();

        $connectedAccount = $user->connectedAccounts()->where('provider_name', $provider)->first();

        if ($connectedAccount) {
            // Prevent unlinking if it's the only login method
            if (is_null($user->password) && $user->connectedAccounts()->count() === 1) {
                return redirect()->route('profile.edit')->withErrors([
                    'error' => 'You must set a password in your account settings before disconnecting your only connected account.'
                ]);
            }

            $connectedAccount->delete();

            $user->securityActivityLogs()->create([
                'action' => 'Disconnected ' . ucfirst($provider) . ' account',
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'created_at' => now(),
            ]);
        }

        return redirect()->route('profile.edit')->with('status', 'account-disconnected');
    }
}
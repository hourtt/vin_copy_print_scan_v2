<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class GoogleUserProfileController extends Controller
{
    /**
     * Display the Google user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = Auth::guard('google')->user();

        return view('google-profile.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the Google user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::guard('google')->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        $user->fill([
            'name' => $validated['name'],
        ]);

        if ($request->hasFile('avatar')) {
            // Delete old avatar if it's local
            if ($user->avatar && !str_starts_with($user->avatar, 'http')) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->avatar);
            }

            // Store new avatar
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        return Redirect::route('google-profile.edit')->with('status', 'profile-updated');
    }
}

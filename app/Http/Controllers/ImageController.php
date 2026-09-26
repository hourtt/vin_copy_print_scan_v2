<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessProfileImageJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function upload(Request $request) {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
        ]);

        $user = Auth::user();
        $tempPath = $request->file('image')->store('temp/profiles', 'local');

        // Process profile image asynchronously via queue
        ProcessProfileImageJob::dispatch($user->id, $tempPath);

        return redirect()->back()->with('success', 'Profile image uploaded and is being processed!');
    }

    public function destroy()
    {
        $user = Auth::user();

        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
            $user->update(['profile_image' => null]);
            return redirect()->back()->with('success', 'Profile image deleted successfully!');
        }

        return redirect()->back()->with('error', 'No profile image to delete.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        $recentInquiryCount = $user->inquiries()->count();

        $defaultAddress = $user->addresses()->where('is_default', true)->first() 
                        ?? $user->addresses()->latest()->first();

        return view('profile.edit', [
            'user' => $user,
            'recentInquiryCount' => $recentInquiryCount,
            'defaultAddress' => $defaultAddress,
        ]);
    }

    /**
     * Update the user's profile information.
     *
     * This single PATCH /profile route handles both:
     *   - The old modal form (all fields at once).
     *   - The new inline editing forms (one field group at a time).
     *
     * A hidden <input name="inline_field"> in each inline form tells us
     * which editor was used, so we can show the right success feedback.
     */
    
    public function update(ProfileUpdateRequest $request)
    {
        $user = $request->user();

        if ($request->input('inline_field') === 'address') {
            $addressId = $request->input('address_id');
            $isDelete = $request->input('delete');

            if ($isDelete && $addressId) {
                $user->addresses()->where('id', $addressId)->delete();
                return response()->json(['success' => true, 'message' => 'Address deleted']);
            }

            $validatedAddress = $request->validate([
                'phone_number' => 'required|string|max:20',
                'address' => 'required|string|max:500',
                'city' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'zip_code' => 'required|string|max:20',
                'is_default' => 'nullable|boolean',
            ]);

            // Convert to boolean since it might come as 'on', 'true', 1, or boolean
            $isDefault = filter_var($request->input('is_default'), FILTER_VALIDATE_BOOLEAN);
            $validatedAddress['is_default'] = $isDefault;

            if ($addressId) {
                $address = $user->addresses()->findOrFail($addressId);
                $address->update($validatedAddress);
            } else {
                $address = $user->addresses()->create($validatedAddress);
                if ($user->addresses()->count() === 1) {
                    $address->update(['is_default' => true]);
                    $isDefault = true;
                }
            }

            if ($isDefault) {
                $user->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Address updated successfully!',
                'address' => $address,
            ]);
        }

        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully!',
                'user' => $user,
            ]);
        }

        // Flash which inline field (if any) was just saved.
        // The Blade template reads session('inline_field') to decide
        // whether to show the in-page toast vs. the modal success message.
        $inlineField = $request->input('inline_field'); // 'name' | 'email' | null

        return Redirect::route('profile.edit')
            ->with('status', 'profile-updated')
            ->with('inline_field', $inlineField);
    }

    public function updateField(Request $request, string $field)
    {
        $user = $request->user();

        // Determine validation rules based on which field group is being saved
        $rules = match ($field) {
            'name' => [
                'first_name' => ['required', 'string', 'max:255'],
                'last_name'  => ['required', 'string', 'max:255'],
            ],
            'email' => [
                'email' => [
                    'required',
                    'string',
                    'lowercase',
                    'email',
                    'max:255',
                    Rule::unique('users')->ignore($user->id),
                ],
            ],
            'address' => [
                'phone_number'   => ['nullable', 'string', 'max:20'],
                'address'        => ['required', 'string', 'max:500'],
                'city'           => ['required', 'string', 'max:255'],
                'state'          => ['nullable', 'string', 'max:255'],
                'zip_code'       => ['nullable', 'string', 'max:20'],
            ],
            default => abort(422, 'Unknown field group.'),
        };

        $validated = $request->validate($rules);

        $user->fill($validated);

        // Reset email verification if the address changed
        if ($field === 'email' && $user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully!',
                'user' => [
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                ],
            ]);
        }

        return Redirect::route('profile.edit')
            ->with('status', 'profile-updated')
            ->with('inline_field', $field);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

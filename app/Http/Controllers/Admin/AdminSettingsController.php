<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShopSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\UpdateShopSettingsRequest;
use App\Http\Requests\Admin\UpdateAdminProfileRequest;
use App\Http\Requests\Admin\UpdateAdminPasswordRequest;

class AdminSettingsController extends Controller
{
    public function index()
    {
        $admin        = Auth::user();
        $shopSettings = ShopSetting::pluck('value', 'key');

        return view('admin.settings.index', compact('admin', 'shopSettings'));
    }

    public function updateShop(UpdateShopSettingsRequest $request)
    {
        $data = $request->validated();

        // Handle logo upload
        if ($request->hasFile('shop_logo')) {
            $oldLogo = ShopSetting::get('shop_logo');
            if ($oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }
            $data['shop_logo'] = $request->file('shop_logo')->store('shop', 'public');
        }

        foreach ($data as $key => $value) {
            ShopSetting::set($key, $value, 'general');
        }

        return back()->with('success', 'Shop information updated.');
    }

    public function updateAdmin(UpdateAdminProfileRequest $request)
    {
        $admin = Auth::user();

        $data = $request->validated();

        $admin->update($data);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(UpdateAdminPasswordRequest $request)
    {
        $admin = Auth::user();

        $data = $request->validated();

        $admin->update(['password' => Hash::make($data['password'])]);

        return back()->with('success', 'Password changed successfully.');
    }
}

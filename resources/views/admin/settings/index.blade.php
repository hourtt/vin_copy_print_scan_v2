<x-admin-layout>
    <x-slot name="header">Settings</x-slot>

    <div class="space-y-6 max-w-5xl">

        @if (session('success'))
            <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm list-none">
                <ul class="list-none list-inside space-y-0.5">
                    @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        <div x-data="{ tab: 'shop' }">
            {{-- Tabs --}}
            <div class="border-b border-gray-200 mb-5">
                <nav class="-mb-px flex space-x-8">
                    <button @click="tab = 'shop'" :class="tab === 'shop' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'" class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                        Store Config
                    </button>
                    <button @click="tab = 'profile'" :class="tab === 'profile' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'" class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                        My Profile
                    </button>
                </nav>
            </div>

            {{-- Tab: Store Config --}}
            <div x-show="tab === 'shop'" x-cloak class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Store Configuration</h3>
                <form method="POST" action="{{ route('admin.settings.update-shop') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf @method('PATCH')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Store Name</label>
                            <input type="text" name="shop_name" value="{{ old('shop_name', $shopSettings['shop_name'] ?? 'Vin Copy Print Scan V2') }}" required
                                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Contact Email</label>
                            <input type="email" name="shop_email" value="{{ old('shop_email', $shopSettings['shop_email'] ?? '') }}"
                                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Contact Phone</label>
                            <input type="text" name="shop_phone" value="{{ old('shop_phone', $shopSettings['shop_phone'] ?? '') }}"
                                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Store Logo</label>
                            <div class="flex items-center gap-3">
                                @if(!empty($shopSettings['shop_logo']))
                                    <img src="{{ Storage::url($shopSettings['shop_logo']) }}" class="h-10 object-contain bg-gray-50 border border-gray-200 rounded" loading="lazy">
                                @endif
                                <input type="file" name="shop_logo" accept="image/*" class="text-sm">
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Physical Address</label>
                            <textarea name="shop_address" rows="2" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none">{{ old('shop_address', $shopSettings['shop_address'] ?? '') }}</textarea>
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">About Store (Footer description)</label>
                            <textarea name="shop_description" rows="3" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none">{{ old('shop_description', $shopSettings['shop_description'] ?? '') }}</textarea>
                        </div>
                    </div>
                    <div class="pt-3 flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">Save Store Config</button>
                    </div>
                </form>
            </div>

            {{-- Tab: My Profile --}}
            <div x-show="tab === 'profile'" x-cloak class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- Profile Info --}}
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Personal Details</h3>
                    <form method="POST" action="{{ route('admin.settings.update-admin') }}" class="space-y-4">
                        @csrf @method('PATCH')
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                <input type="text" name="first_name" value="{{ old('first_name', $admin->first_name) }}" required class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                <input type="text" name="last_name" value="{{ old('last_name', $admin->last_name) }}" required class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email', $admin->email) }}" required class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                            <input type="text" name="phone_number" value="{{ old('phone_number', $admin->phone_number) }}" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
                        </div>
                        <div class="pt-3 flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">Update Profile</button>
                        </div>
                    </form>
                </div>

                {{-- Change Password --}}
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm h-fit">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Change Password</h3>
                    <form method="POST" action="{{ route('admin.settings.update-password') }}" class="space-y-4">
                        @csrf @method('PATCH')
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                            <input type="password" name="current_password" required class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                            <input type="password" name="password" required class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                            <input type="password" name="password_confirmation" required class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm">
                        </div>
                        <div class="pt-3 flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-gray-800 text-white text-sm font-medium rounded-lg hover:bg-gray-900 transition-colors">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>

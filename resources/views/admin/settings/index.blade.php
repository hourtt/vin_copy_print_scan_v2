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
                    <button @click="tab = 'shipping'" :class="tab === 'shipping' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'" class="whitespace-nowrap border-b-2 py-4 px-1 text-sm font-medium">
                        Shipping Methods
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

            {{-- Tab: Shipping Methods --}}
            <div x-show="tab === 'shipping'" x-cloak class="space-y-4">
                <div class="flex justify-between items-center bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Shipping Methods</h3>
                        <p class="text-sm text-gray-500">Manage delivery options available at checkout.</p>
                    </div>
                    <a href="{{ route('admin.settings.shipping.create') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                        Add Shipping Method
                    </a>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold text-gray-500">Method</th>
                                <th class="px-4 py-3 text-left font-semibold text-gray-500">Est. Time</th>
                                <th class="px-4 py-3 text-right font-semibold text-gray-500">Fee ($)</th>
                                <th class="px-4 py-3 text-center font-semibold text-gray-500">Status</th>
                                <th class="px-4 py-3 text-right font-semibold text-gray-500">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($shippingMethods as $method)
                                <tr>
                                    <td class="px-4 py-3">
                                        <p class="font-medium text-gray-900">{{ $method->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $method->description }}</p>
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">{{ $method->estimated_days }} days</td>
                                    <td class="px-4 py-3 text-right font-medium">${{ number_format($method->fee, 2) }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <div x-data="{ active: {{ $method->is_active ? 'true' : 'false' }} }">
                                            <button @click="fetch('{{ route('admin.settings.shipping.toggle', $method) }}', { method: 'PATCH', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } }).then(r=>r.json()).then(d=>active=d.is_active)"
                                                    :class="active ? 'bg-green-500' : 'bg-gray-200'" class="relative inline-flex h-5 w-9 items-center rounded-full transition-colors cursor-pointer">
                                                <span :class="active ? 'translate-x-5' : 'translate-x-1'" class="inline-block h-3 w-3 transform rounded-full bg-white transition-transform"></span>
                                            </button>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('admin.settings.shipping.edit', $method) }}" class="text-xs font-medium text-gray-700 bg-white border border-gray-200 px-3 py-1.5 rounded-lg hover:bg-gray-50">Edit</a>
                                            <form method="POST" action="{{ route('admin.settings.shipping.destroy', $method) }}" x-data @submit.prevent="if(confirm('Delete {{ $method->name }}?')) $el.submit()">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-xs font-medium text-red-600 bg-white border border-red-200 px-3 py-1.5 rounded-lg hover:bg-red-50">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">No shipping methods configured.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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

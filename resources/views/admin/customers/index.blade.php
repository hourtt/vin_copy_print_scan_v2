<x-admin-layout>
    <x-slot name="header">Customers</x-slot>

    <div class="space-y-5">
        <div class="flex items-center justify-between">
            <p class="text-sm text-gray-500">Manage customer accounts and view their order history</p>
        </div>

        @if (session('success'))
            <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Filters --}}
        <form method="GET" action="{{ route('admin.customers.index') }}"
              class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <div class="relative lg:col-span-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search by name or email…"
                           class="w-full pl-3 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <select name="status" class="border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">All Statuses</option>
                    <option value="active" @selected(request('status') === 'active')>Active</option>
                    <option value="banned" @selected(request('status') === 'banned')>Banned</option>
                </select>
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                        Filter
                    </button>
                    @if (request()->hasAny(['search', 'status']))
                        <a href="{{ route('admin.customers.index') }}" class="px-3 py-2 text-sm text-gray-500 border border-gray-200 rounded-lg hover:bg-gray-50">✕</a>
                    @endif
                </div>
            </div>
        </form>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
            @if ($customers->isEmpty())
                <div class="flex flex-col items-center justify-center py-16 text-gray-400">
                    <p class="text-sm">No customers found.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Customer</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Phone</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">Inquiries</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                                <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($customers as $customer)
                                <tr class="hover:bg-gray-50 transition-colors {{ $customer->is_banned ? 'bg-red-50/30' : '' }}">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold shrink-0">
                                                {{ strtoupper(substr($customer->first_name, 0, 1) . substr($customer->last_name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $customer->first_name }} {{ $customer->last_name }}</p>
                                                <p class="text-xs text-gray-500">{{ $customer->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">{{ $customer->phone_number ?? '—' }}</td>
                                    <td class="px-4 py-3 text-center text-gray-900 font-medium">{{ $customer->inquiries_count ?? 0 }}</td>
                                    <td class="px-4 py-3 text-center">
                                        @if ($customer->is_banned)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">Banned</span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700">Active</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <a href="{{ route('admin.customers.show', $customer) }}"
                                           class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                            View Profile
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if ($customers->hasPages())
                    <div class="px-4 py-3 border-t border-gray-100">{{ $customers->links() }}</div>
                @endif
            @endif
        </div>
    </div>
</x-admin-layout>

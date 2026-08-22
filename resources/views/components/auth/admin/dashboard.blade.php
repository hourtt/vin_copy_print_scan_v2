<x-admin-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <!-- Dashboard Content -->
    <div class="space-y-6">

        <!-- Stats Row -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Stat Card 1: Total Inquiries -->
            <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Inquiries</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $totalInquiries ?? 0 }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-indigo-50 rounded-full flex items-center justify-center text-indigo-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    @if (($inquiryGrowth ?? 0) > 0)
                        <span class="text-green-600 bg-green-50 px-2 py-0.5 rounded font-medium flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            +{{ number_format($inquiryGrowth, 1) }}%
                        </span>
                    @elseif(($inquiryGrowth ?? 0) < 0)
                        <span class="text-red-600 bg-red-50 px-2 py-0.5 rounded font-medium flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6" />
                            </svg>
                            {{ number_format($inquiryGrowth, 1) }}%
                        </span>
                    @else
                        <span class="text-gray-500 font-medium flex items-center">0.0%</span>
                    @endif
                    <span class="text-gray-500 ml-2">from last month</span>
                </div>
            </div>

            <!-- Stat Card 2: Active Customers -->
            <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Active Customers</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $activeCustomers ?? 0 }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-blue-50 rounded-full flex items-center justify-center text-blue-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    @if (($customerGrowth ?? 0) > 0)
                        <span class="text-green-600 bg-green-50 px-2 py-0.5 rounded font-medium flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            +{{ number_format($customerGrowth, 1) }}%
                        </span>
                    @elseif(($customerGrowth ?? 0) < 0)
                        <span class="text-red-600 bg-red-50 px-2 py-0.5 rounded font-medium flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6" />
                            </svg>
                            {{ number_format($customerGrowth, 1) }}%
                        </span>
                    @else
                        <span class="text-gray-500 font-medium flex items-center">0.0%</span>
                    @endif
                    <span class="text-gray-500 ml-2">from last month</span>
                </div>
            </div>

            <!-- Stat Card 3: Total Products -->
            <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Products</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $totalProducts ?? 0 }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-purple-50 rounded-full flex items-center justify-center text-purple-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    @if (($productGrowth ?? 0) > 0)
                        <span class="text-green-600 bg-green-50 px-2 py-0.5 rounded font-medium flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            +{{ number_format($productGrowth, 1) }}%
                        </span>
                    @elseif(($productGrowth ?? 0) < 0)
                        <span class="text-red-600 bg-red-50 px-2 py-0.5 rounded font-medium flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6" />
                            </svg>
                            {{ number_format($productGrowth, 1) }}%
                        </span>
                    @else
                        <span class="text-gray-500 font-medium flex items-center">0.0%</span>
                    @endif
                    <span class="text-gray-500 ml-2">from last month</span>
                </div>
            </div>

            <!-- Stat Card 4: Total Categories -->
            <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Categories</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $totalCategories ?? 0 }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-amber-50 rounded-full flex items-center justify-center text-amber-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <span>Organized catalog categories</span>
                </div>
            </div>
        </div>

        <!-- Recent Inquiries Table -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mt-6">
            <div class="px-6 py-5 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Recent Inquiries</h3>
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.inquiries.index') }}"
                        class="px-3 py-1.5 border border-gray-200 text-gray-600 rounded-md text-sm font-medium hover:bg-gray-50 transition-colors">
                        View All Inquiries
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Customer</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Product</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Category</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Price</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date</th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider text-right">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($recentInquiries ?? [] as $inquiry)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-medium text-gray-900">{{ $inquiry->user_name_snapshot }}</div>
                                    <div class="text-xs text-gray-500">{{ $inquiry->user_email_snapshot }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-md bg-gray-100 flex items-center justify-center overflow-hidden shrink-0">
                                            @if ($inquiry->product?->image)
                                                <img src="{{ asset('storage/' . $inquiry->product?->image) }}"
                                                    alt="{{ $inquiry->product_name_snapshot }}"
                                                    class="h-full w-full object-cover" loading="lazy">
                                            @else
                                                <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            @endif
                                        </div>
                                        <span class="text-sm font-medium text-gray-900 line-clamp-1 max-w-[200px]">{{ $inquiry->product_name_snapshot }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $inquiry->product?->category?->name ?? "N/A" }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    ${{ number_format($inquiry->product_price_snapshot, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $inquiry->created_at->format('d M Y, H:i') }}</td>
                                <td class="px-6 py-4 text-right text-sm font-medium">
                                    @if ($inquiry->user_phone_snapshot)
                                        <a href="https://t.me/{{ ltrim($inquiry->user_phone_snapshot, '+') }}"
                                           target="_blank" rel="noopener noreferrer"
                                           class="inline-flex items-center gap-1 text-xs font-medium text-[#1D9E75] hover:underline">
                                            Reply
                                        </a>
                                    @else
                                        <a href="{{ route('admin.inquiries.index', ['search' => $inquiry->user_name_snapshot]) }}"
                                            class="text-indigo-600 hover:text-indigo-900 text-xs">View</a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500">
                                    No inquiries recorded yet
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-admin-layout>

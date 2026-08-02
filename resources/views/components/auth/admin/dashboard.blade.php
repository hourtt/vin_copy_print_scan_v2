<x-admin-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <!-- Dashboard Content -->
    <div class="space-y-6">

        <!-- Stats Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Stat Card 1 -->
            <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Revenue</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">${{ number_format($totalRevenue ?? 0, 2) }}
                        </h3>
                    </div>
                    <div class="w-12 h-12 bg-indigo-50 rounded-full flex items-center justify-center text-indigo-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    @if ($revenueGrowth > 0)
                        <span class="text-green-600 bg-green-50 px-2 py-0.5 rounded font-medium flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            +{{ number_format($revenueGrowth, 1) }}%
                        </span>
                    @elseif($revenueGrowth < 0)
                        <span class="text-red-600 bg-red-50 px-2 py-0.5 rounded font-medium flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6" />
                            </svg>
                            {{ number_format($revenueGrowth, 1) }}%
                        </span>
                    @else
                        <span class="text-gray-500 font-medium flex items-center">
                            0.0%
                        </span>
                    @endif
                    <span class="text-gray-500 ml-2">from last month</span>
                </div>
            </div>

            <!-- Stat Card 2 -->
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
                    @if ($customerGrowth > 0)
                        <span class="text-green-600 bg-green-50 px-2 py-0.5 rounded font-medium flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            +{{ number_format($customerGrowth, 1) }}%
                        </span>
                    @elseif($customerGrowth < 0)
                        <span class="text-red-600 bg-red-50 px-2 py-0.5 rounded font-medium flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6" />
                            </svg>
                            {{ number_format($customerGrowth, 1) }}%
                        </span>
                    @else
                        <span class="text-gray-500 font-medium flex items-center">
                            0.0%
                        </span>
                    @endif
                    <span class="text-gray-500 ml-2">from last month</span>
                </div>
            </div>

            <!-- Stat Card 3 -->
            <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Orders</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $totalOrders ?? 0 }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-purple-50 rounded-full flex items-center justify-center text-purple-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    @if ($orderGrowth > 0)
                        <span class="text-green-600 bg-green-50 px-2 py-0.5 rounded font-medium flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            +{{ number_format($orderGrowth, 1) }}%
                        </span>
                    @elseif($orderGrowth < 0)
                        <span class="text-red-600 bg-red-50 px-2 py-0.5 rounded font-medium flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6" />
                            </svg>
                            {{ number_format($orderGrowth, 1) }}%
                        </span>
                    @else
                        <span class="text-gray-500 font-medium flex items-center">
                            0.0%
                        </span>
                    @endif
                    <span class="text-gray-500 ml-2">from last month</span>
                </div>
            </div>

            <!-- Stat Card 4 -->
            <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Active Issues</p>
                        <h3 class="text-2xl font-bold text-gray-900 mt-1">{{ $activeIssues ?? 0 }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-red-50 rounded-full flex items-center justify-center text-red-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    @if ($issueGrowth > 0)
                        <span class="text-green-600 bg-green-50 px-2 py-0.5 rounded font-medium flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            +{{ number_format($issueGrowth, 1) }}%
                        </span>
                    @elseif($issueGrowth < 0)
                        <span class="text-red-600 bg-red-50 px-2 py-0.5 rounded font-medium flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6" />
                            </svg>
                            {{ number_format($issueGrowth, 1) }}%
                        </span>
                    @else
                        <span class="text-gray-500 font-medium flex items-center">
                            0.0%
                        </span>
                    @endif
                    <span class="text-gray-500 ml-2">since last hour</span>
                </div>
            </div>
        </div>

        <!-- Recent Orders Table -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mt-6">
            <div class="px-6 py-5 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Recent Orders</h3>
                <div class="flex items-center gap-2">
                    <button
                        class="px-3 py-1.5 border border-gray-200 text-gray-600 rounded-md text-sm font-medium hover:bg-gray-50 transition-colors flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        Filter
                    </button>
                    <button
                        class="px-3 py-1.5 border border-gray-200 text-gray-600 rounded-md text-sm font-medium hover:bg-gray-50 transition-colors">
                        See All
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr>
                            <th
                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Product</th>
                            <th
                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Category</th>
                            <th
                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ordered By</th>
                            <th
                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Price</th>
                            <th
                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th
                                class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-xs font-medium text-gray-500 uppercase tracking-wider text-right">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        {{-- ✅ Declared once above the loop, not re-created on every iteration --}}
                        @php
                            $statusStyles = [
                                'completed'        => 'bg-green-50 text-green-700 border-green-200',
                                'active'           => 'bg-green-50 text-green-700 border-green-200',
                                'processing'       => 'bg-blue-50 text-blue-700 border-blue-200',
                                'scheduled'        => 'bg-blue-50 text-blue-700 border-blue-200',
                                'pending'          => 'bg-orange-50 text-orange-700 border-orange-200',
                                'draft'            => 'bg-orange-50 text-orange-700 border-orange-200',
                                'cancelled'        => 'bg-red-50 text-red-700 border-red-200',
                            ];
                        @endphp
                        @forelse($recentOrders ?? [] as $order)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="h-10 w-10 rounded-md bg-gray-100 flex items-center justify-center overflow-hidden">
                                            @if ($order->product?->image)
                                                <img src="{{ asset('storage/' . $order->product->image) }}"
                                                    alt="{{ $order->product->name }}"
                                                    class="h-full w-full object-cover" loading="lazy">
                                            @else
                                                <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            @endif
                                        </div>
                                        <span
                                            class="text-sm font-medium text-gray-900">{{ $order->product->name ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->product->category->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->user->name ?? 'Guest' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    ${{ number_format($order->total_price, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusKey   = strtolower($order->status ?? '');
                                        $statusStyle = $statusStyles[$statusKey] ?? 'bg-gray-50 text-gray-700 border-gray-200';
                                    @endphp
                                    <span
                                        class="px-2.5 py-1 text-xs font-medium rounded-full border {{ $statusStyle }}">
                                        {{ ucfirst($order->status ?? 'Unknown') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.sales.show', $order->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900">Details</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-500">
                                    No order record yet
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if (($recentOrders ?? collect())->isNotEmpty())
                <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
                    <button
                        class="px-3 py-1.5 border border-gray-200 text-gray-600 rounded-md text-sm font-medium hover:bg-gray-50 transition-colors flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                        Previous
                    </button>
                    <div class="hidden sm:flex items-center gap-1">
                        <button
                            class="w-8 h-8 flex items-center justify-center rounded-md bg-indigo-50 text-indigo-600 text-sm font-medium">1</button>
                        <button
                            class="w-8 h-8 flex items-center justify-center rounded-md text-gray-600 hover:bg-gray-50 text-sm font-medium">2</button>
                        <button
                            class="w-8 h-8 flex items-center justify-center rounded-md text-gray-600 hover:bg-gray-50 text-sm font-medium">3</button>
                        <span class="text-gray-500 px-1">...</span>
                        <button
                            class="w-8 h-8 flex items-center justify-center rounded-md text-gray-600 hover:bg-gray-50 text-sm font-medium">8</button>
                    </div>
                    <button
                        class="px-3 py-1.5 border border-gray-200 text-gray-600 rounded-md text-sm font-medium hover:bg-gray-50 transition-colors flex items-center gap-1">
                        Next
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            @endif
        </div>

    </div>
</x-admin-layout>

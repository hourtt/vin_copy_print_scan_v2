@props([
    'recentOrderCount' => 0,
    'activeVoucherCount' => 0,
])

<div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8 overflow-hidden">
    <h3 class="px-6 py-4 border-b border-gray-200 text-lg font-semibold text-gray-900 bg-gray-50/50">
        Activity Overview</h3>

    {{-- Recent Orders --}}
    <div
        class="px-6 py-5 border-b border-gray-100 last:border-0 flex flex-col md:flex-row md:items-center gap-4">
        <div class="md:w-1/3 text-sm font-medium text-gray-700">Recent Orders</div>
        <div class="flex-1 text-sm text-gray-900 flex items-baseline">
            <span class="text-xl font-semibold text-gray-900">{{ $recentOrderCount }}</span>
            <span class="text-sm text-gray-500 ml-2">total orders placed</span>
        </div>
        <div class="md:text-right">
            <a href="{{ route('orders.index') }}"
                class="text-sm font-medium text-indigo-600 hover:text-indigo-700 transition-colors">View
                Orders</a>
        </div>
    </div>

    {{-- Saved & Vouchers --}}
    <div
        class="px-6 py-5 border-b border-gray-100 last:border-0 flex flex-col md:flex-row md:items-center gap-4">
        <div class="md:w-1/3 text-sm font-medium text-gray-700">Saved & Vouchers</div>
        <div class="flex-1 text-sm text-gray-900">
            <div class="flex items-center gap-6">
                <div>
                    <span class="text-lg font-semibold text-gray-900">0</span>
                    <span class="text-sm text-gray-500 ml-1">wishlist</span>
                </div>
                <div class="w-px h-5 bg-gray-200"></div>
                <div>
                    <span
                        class="text-lg font-semibold text-gray-900">{{ $activeVoucherCount }}</span>
                    <span class="text-sm text-gray-500 ml-1">active vouchers</span>
                </div>
            </div>
        </div>
        <div class="md:text-right">
            <button type="button"
                class="text-sm font-medium text-indigo-600 hover:text-indigo-700 transition-colors">View
                Details</button>
        </div>
    </div>
</div>

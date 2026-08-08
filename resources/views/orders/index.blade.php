<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>My Orders - {{ config('app.name', 'PrintCo') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fraunces:400,500,600,700,900i&family=dm-sans:300,400,500,600"
        rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
</head>

<body class="bg-gray-50 text-gray-900 font-sans antialiased">
    @include('layouts.navigation')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        {{-- Breadcrumb --}}
        <x-breadcrumb :items="$breadcrumbs" />

        {{-- Page Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold font-fraunces text-gray-900">My Orders</h1>
            <p class="mt-2 text-sm text-[#71717a]">
                Check the status of recent orders, manage returns, and discover similar products.
            </p>
        </div>

        {{-- Orders List --}}
        @forelse ($orders as $order)
            @php
                $statusConfig = match($order->status) {
                    'delivered'        => ['bg' => 'bg-green-50', 'text' => 'text-green-700', 'dot' => 'bg-green-500'],
                    'processing'       => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'dot' => 'bg-blue-500'],
                    'packed'           => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-700', 'dot' => 'bg-indigo-500'],
                    'out_for_delivery' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'dot' => 'bg-amber-500'],
                    'pending'          => ['bg' => 'bg-gray-50', 'text' => 'text-gray-600', 'dot' => 'bg-gray-400'],
                    'cancelled'        => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'dot' => 'bg-red-500'],
                    default            => ['bg' => 'bg-gray-50', 'text' => 'text-gray-600', 'dot' => 'bg-gray-400'],
                };
            @endphp
            <div class="bg-white rounded-xl border border-gray-100 shadow-sm mb-5 overflow-hidden">
                {{-- Order Header --}}
                <div class="px-5 sm:px-6 py-4 border-b border-gray-100 bg-gray-50/60">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        {{-- Left: Order ID + Date --}}
                        <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4">
                            <h2 class="text-base font-semibold text-gray-900">
                                Order #{{ $order->id }}
                            </h2>
                            <span class="text-sm text-[#71717a]">
                                Placed on {{ $order->local_order_date->format('F j, Y \a\t g:i A') }}
                            </span>
                        </div>

                        {{-- Right: Status badge + Total --}}
                        <div class="flex items-center gap-3">
                            <span
                                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $statusConfig['dot'] }}"></span>
                                {{ $order->status_label }}
                            </span>
                            <span class="text-sm font-semibold text-gray-900">
                                ${{ number_format($order->total, 2) }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Order Items --}}
                <div class="divide-y divide-gray-50">
                    @foreach ($order->items as $item)
                        <div class="px-5 sm:px-6 py-4 flex items-start gap-4">
                            {{-- Product Thumbnail --}}
                            <div
                                class="w-16 h-16 sm:w-20 sm:h-20 flex-shrink-0 rounded-lg bg-gray-100 border border-gray-100 overflow-hidden flex items-center justify-center">
                                @if ($item->product && $item->product->image)
                                    <img src="{{ asset('storage/' . $item->product?->image) }}"
                                        alt="{{ $item->product?->name ?? 'Product' }}"
                                        class="w-full h-full object-cover" loading="lazy">
                                @else
                                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                @endif
                            </div>

                            {{-- Product Details --}}
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">
                                    {{ $item->product?->name ?? 'Product Unavailable' }}
                                </p>
                                <p class="text-sm text-[#71717a] mt-0.5">
                                    Qty: {{ $item->quantity }}
                                    <span class="mx-1.5 text-gray-300">·</span>
                                    ${{ number_format($item->unit_price, 2) }} each
                                </p>
                            </div>

                            {{-- Item Subtotal --}}
                            <div class="text-right flex-shrink-0">
                                <p class="text-sm font-semibold text-gray-900">
                                    ${{ number_format($item->subtotal, 2) }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Order Footer --}}
                <div class="px-5 sm:px-6 py-3.5 border-t border-gray-100 bg-gray-50/40">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        {{-- Summary --}}
                        <div class="flex items-center gap-4 text-sm text-[#71717a]">
                            <span>
                                {{ $order->items->count() }} {{ Str::plural('item', $order->items->count()) }}
                            </span>
                            @if ($order->shippingMethod)
                                <span class="hidden sm:inline text-gray-300">·</span>
                                <span class="hidden sm:inline">{{ $order->shippingMethod->name }}</span>
                            @endif
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center gap-2">
                            <a href="{{ route('orders.show', $order->id) }}"
                                class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 hover:border-gray-300 transition-colors duration-150 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                View Details
                            </a>
                            @if ($order->status === 'out_for_delivery' || $order->status === 'packed')
                                <a href="{{ route('orders.show', $order->id) }}"
                                    class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-indigo-700 bg-indigo-50 border border-indigo-200 rounded-lg hover:bg-indigo-100 transition-colors duration-150">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                    </svg>
                                    Track Order
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            {{-- Empty State --}}
            <div class="bg-white p-12 rounded-xl shadow-sm text-center border border-gray-100">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-6">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <h2 class="text-xl font-medium text-gray-900 mb-2">No orders yet</h2>
                <p class="text-[#71717a] mb-8 max-w-sm mx-auto">
                    You haven't placed any orders yet. Start shopping to see your order history here.
                </p>
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-lg font-medium text-white hover:bg-indigo-700 shadow-sm transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Start Shopping
                </a>
            </div>
        @endforelse

        {{-- Pagination --}}
        @if ($orders->hasPages())
            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

    @include('layouts.footer')
</body>

</html>
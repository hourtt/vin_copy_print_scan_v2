<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Order #{{ $order->order_number ?? $order->id }} - {{ config('app.name', 'PrintCo') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fraunces:400,500,600,700,900i&family=dm-sans:300,400,500,600"
        rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
</head>

<body class="bg-gray-50 text-gray-900 font-sans antialiased">
    @include('layouts.navigation')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-12">
        {{-- Top Navigation & Header --}}
        <div class="mb-8">
            <a href="{{ route('orders.index') }}"
                class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors mb-6 group">
                <svg class="w-4 h-4 mr-1.5 transform group-hover:-translate-x-1 transition-transform" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to My Orders
            </a>

            @php
                $statusConfig = match ($order->status) {
                    'delivered'        => ['bg' => 'bg-green-50', 'text' => 'text-green-700', 'dot' => 'bg-green-500'],
                    'processing'       => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'dot' => 'bg-blue-500'],
                    'packed'           => ['bg' => 'bg-indigo-50', 'text' => 'text-indigo-700', 'dot' => 'bg-indigo-500'],
                    'out_for_delivery' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'dot' => 'bg-amber-500'],
                    'pending'          => ['bg' => 'bg-gray-50', 'text' => 'text-gray-600', 'dot' => 'bg-gray-400'],
                    'cancelled'        => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'dot' => 'bg-red-500'],
                    default            => ['bg' => 'bg-gray-50', 'text' => 'text-gray-600', 'dot' => 'bg-gray-400'],
                };
            @endphp

            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold font-fraunces text-gray-900">
                        Order #{{ $order->order_number ?? $order->id }}
                    </h1>
                    <p class="mt-2 text-sm text-[#71717a]">
                        Placed on {{ $order->local_order_date->format('F j, Y \a\t g:i A') }}
                    </p>
                </div>
                <div>
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-semibold {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }}">
                        <span class="w-2 h-2 rounded-full {{ $statusConfig['dot'] }}"></span>
                        {{ $order->status_label }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Layout Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Left Column: Order Items --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-5 sm:px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                        <h2 class="text-lg font-semibold text-gray-900">Items Ordered</h2>
                    </div>
                    
                    <div class="divide-y divide-gray-50">
                        @foreach ($order->items as $item)
                            <div class="px-5 sm:px-6 py-5 flex items-start sm:items-center gap-4 sm:gap-6">
                                {{-- Thumbnail --}}
                                <div class="w-20 h-20 sm:w-24 sm:h-24 flex-shrink-0 rounded-lg bg-gray-50 border border-gray-100 overflow-hidden flex items-center justify-center">
                                    @if ($item->product && $item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}"
                                            alt="{{ $item->product->name ?? 'Product Image' }}"
                                            class="w-full h-full object-cover" loading="lazy">
                                    @else
                                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    @endif
                                </div>
                                
                                {{-- Info --}}
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-base font-semibold text-gray-900 mb-1">
                                        {{ $item->product->name ?? 'Product Unavailable' }}
                                    </h3>
                                    <p class="text-sm text-[#71717a] mb-2">
                                        Qty: {{ $item->quantity }}
                                    </p>
                                    <div class="flex items-center justify-between mt-auto">
                                        <span class="text-sm text-[#71717a]">${{ number_format($item->unit_price, 2) }} each</span>
                                        <span class="text-base font-bold text-gray-900">${{ number_format($item->subtotal, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Action Footer (Desktop/Tablet placed below items, Mobile can be anywhere) --}}
                <div class="flex flex-col sm:flex-row gap-3">
                    <button class="flex-1 sm:flex-none inline-flex justify-center items-center px-5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 shadow-sm transition-colors">
                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Download Invoice
                    </button>
                    <button class="flex-1 sm:flex-none inline-flex justify-center items-center px-5 py-2.5 bg-indigo-50 border border-indigo-200 rounded-lg text-sm font-medium text-indigo-700 hover:bg-indigo-100 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reorder Items
                    </button>
                </div>
            </div>

            {{-- Right Column: Summary & Details --}}
            <div class="lg:col-span-1 space-y-6">
                
                {{-- Price Breakdown --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 sm:p-6">
                    <h3 class="text-base font-semibold text-gray-900 mb-4">Order Summary</h3>
                    
                    <div class="space-y-3 text-sm text-[#71717a]">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span class="text-gray-900">${{ number_format($order->subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Shipping</span>
                            <span class="text-gray-900">${{ number_format($order->shipping_fee, 2) }}</span>
                        </div>
                        {{-- <div class="flex justify-between">
                            <span>Estimated Tax</span>
                            <span class="text-gray-900">$0.00</span>
                        </div> --}}
                    </div>
                    
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <div class="flex justify-between items-center">
                            <span class="text-base font-semibold text-gray-900">Total</span>
                            <span class="text-lg font-bold text-gray-900">${{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                </div>

                {{-- Shipping Info --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 sm:p-6">
                    <h3 class="text-base font-semibold text-gray-900 mb-4">Shipping Information</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Delivery Address</h4>
                            <p class="text-sm text-gray-900 leading-relaxed">
                                @if($order->address)
                                    {{ $order->user->first_name ?? '' }} {{ $order->user->last_name ?? '' }}<br>
                                    {{ $order->address }}<br>
                                    {{ $order->city }}, {{ $order->state_province }} {{ $order->zip_code }}
                                @else
                                    {{ $order->shipping_address ?? 'No address provided.' }}
                                @endif
                            </p>
                        </div>
                        
                        @if($order->phone_number)
                        <div>
                            <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Contact Phone</h4>
                            <p class="text-sm text-gray-900">
                                {{ preg_replace('/(\d{3})(\d{3})(\d{4})/', '$1 $2 $3', $order->phone_number) }}
                            </p>
                        </div>
                        @endif

                        @if($order->shippingMethod)
                        <div>
                            <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Shipping Method</h4>
                            <p class="text-sm text-gray-900">
                                {{ $order->shippingMethod->name }}
                            </p>
                        </div>
                        @endif
                        
                        <div>
                            <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Payment Method</h4>
                            <div class="flex items-center gap-2 mt-1">
                                <svg class="w-6 h-4 text-gray-500" fill="none" viewBox="0 0 24 16">
                                    <rect width="24" height="16" rx="2" fill="#E4E4E7"/>
                                    <rect y="4" width="24" height="3" fill="#A1A1AA"/>
                                </svg>
                                <span class="text-sm text-gray-900">Paid via Stripe</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @include('layouts.footer')
</body>

</html>
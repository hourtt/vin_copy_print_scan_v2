<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your Cart - {{ config('app.name', 'PrintCo') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fraunces:400,500,600,700,900i&family=dm-sans:300,400,500,600"
        rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-900 font-sans antialiased">
    @include('layouts.navigation')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Breadcrumb Navigation -->
        <x-breadcrumb :items="$breadcrumbs" />

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <h1 class="text-3xl font-bold font-fraunces text-gray-900">Shopping Cart</h1>
            <a href="{{ route('dashboard') }}"
                class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Dashboard
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-6 shadow-sm">{{ session('success') }}</div>
        @endif

        @if ($cartItems->isEmpty())
            @include('cart.partials.empty-state')
        @else
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Left Column (Product List) -->
                <div class="lg:col-span-8">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                            <h2 class="text-lg font-medium text-gray-900">Items in your cart</h2>
                        </div>
                        <ul class="divide-y divide-gray-100">
                            @foreach ($cartItems as $item)
                                @include('cart.partials.item-row', ['item' => $item])
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Right Column (Sidebar Panels) -->
                <div class="lg:col-span-4 space-y-6">
                    @include('cart.partials.sidebar', ['subtotal' => $subtotal])
                </div>
            </div>
        @endif
    </div>
    @include('cart.partials.scripts')
</body>

</html>

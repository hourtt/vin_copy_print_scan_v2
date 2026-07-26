<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout | {{ config('app.name', 'Vin Copy Print Scan') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=DM_Sans:400,500,600,700,900i&family=dm-sans:300,400,500,600"
        rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/checkout-bundle.js'])
</head>

<body class="bg-zinc-50 text-[#27272a] font-['Kantumruy_Pro',sans-serif] min-h-screen flex flex-col"
    x-data="checkout({{ $subtotal }}, {{ $shippingMethods->toJson() }})">

    <!-- Header -->
    <header class="bg-white border-b border-[#e4e4e7] py-4">
        <div class="container mx-auto px-4 lg:px-8 flex justify-between items-center">
            <a href="{{ url('/') }}" class="flex items-center gap-3 no-underline">
                <img src="{{ asset('storage/images/logo-icon-only.webp') }}" alt="Logo" width="40"
                    class="rounded-lg" loading="lazy">
            </a>
            <div class="flex items-center gap-2 text-sm text-[#71717a] font-medium">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
                Secure Checkout
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-4 lg:px-8 py-8 lg:py-12">
        <div class="flex flex-col lg:flex-row gap-10">

            <div class="lg:w-7/12 flex flex-col">
                <x-breadcrumb.checkout-breadcrumb current="shipping" />

                <h1 class="font-['Kantumruy_Pro',sans-serif] text-3xl font-bold mb-6">Shipping Address</h1>

                @if ($errors->any())
                    <div class="bg-red-50 text-red-600 p-4 rounded-lg mb-6 text-sm">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="checkout-form" action="{{ route('checkout.store') }}" method="POST">
                    @csrf

                    <!-- Required for validation, updated via Alpine -->
                    <input type="hidden" name="shipping_method_id" :value="selectedMethodId">
                    <!-- Default payment method for now -->
                    <input type="hidden" name="payment_method" value="cod">

                    <x-checkout.address-form :user="auth()->user()" :addresses="$addresses" />

                    <h2 class="font-['Kantumruy_Pro',sans-serif] text-2xl font-bold mb-4">Shipping Method</h2>

                    <x-checkout.shipping-methods />

                    <button type="submit"
                        class="w-full bg-[#27272a] text-white py-4 rounded-xl font-bold text-lg hover:bg-black transition-colors shadow-lg">
                        Continue to Payment
                    </button>
                </form>
            </div>

            <!-- RIGHT COLUMN: Cart Summary -->
            <div class="lg:w-5/12">
                <x-checkout.cart-summary 
                    :cartItems="$cartItems" 
                    :subtotal="$subtotal" 
                    :shippingFee="$shippingFee" 
                    :total="$total" 
                />
            </div>

        </div>
    </main>

</body>

</html>

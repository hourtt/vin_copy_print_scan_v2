<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} | {{ config('app.name', 'PrintCo') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fraunces:400,500,600,700,900i&family=dm-sans:300,400,500,600"
        rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased overflow-x-hidden w-full relative bg-white">
    {{-- NAVIGATION --}}
    @include('layouts.navigation')

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        {{-- BACK BUTTON --}}
        <div class="mb-6">
            <a href="{{ url()->previous() }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-[#2563EB] transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
            {{-- IMAGE GALLERY --}}
            <div class="flex flex-col gap-4">
                <div class="aspect-[4/3] bg-[#fafafa] rounded-2xl overflow-hidden border border-[#e4e4e7] flex items-center justify-center relative">
                    @if ($product->image)
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <span class="text-gray-400">No image available</span>
                    @endif

                    {{-- Badges --}}
                    <div class="absolute top-4 left-4 flex flex-col gap-2">
                        @if ($product->is_on_sale)
                            <span class="text-xs font-bold uppercase tracking-wide px-2.5 py-1 rounded-lg bg-red-600 text-white">Sale</span>
                        @endif
                    </div>
                    
                    @php
                        $stock = $product->stock_status;
                    @endphp
                    <span class="absolute top-4 right-4 text-xs font-semibold capitalize tracking-wide px-2.5 py-1 rounded-lg {{ $stock['badgeBg'] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ $stock['label'] }}
                    </span>
                </div>
            </div>

            {{-- PRODUCT DETAILS --}}
            <div class="flex flex-col">
                <div class="mb-2">
                    <span class="text-sm font-bold uppercase tracking-wide text-[#3f3f46]">
                        {{ $product->brand?->name ?? ($product->category?->name ?? 'Product') }}
                    </span>
                </div>
                
                <h1 class="font-['Kantumruy_Pro',serif] text-2xl sm:text-3xl lg:text-4xl font-semibold text-[#27272a] leading-tight mb-4">
                    {{ $product->name }}
                </h1>

                <div class="flex items-end gap-3 mb-6">
                    <span class="text-3xl font-bold text-[#27272a]">${{ number_format($product->effective_price, 2) }}</span>
                    @if ($product->is_on_sale)
                        <span class="text-lg text-[#a1a1aa] line-through mb-1">${{ number_format($product->price, 2) }}</span>
                    @endif
                </div>

                <div class="prose prose-sm sm:prose-base text-gray-600 mb-8 max-w-none">
                    {!! nl2br(e($product->description)) !!}
                </div>

                {{-- SPECS / COMPATIBILITY --}}
                @if(($product->specifications && count($product->specifications) > 0) || $product->compatibleModels->count() > 0)
                    <div class="mb-8 p-5 bg-gray-50 rounded-2xl border border-gray-100">
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4">Specifications</h3>
                        <dl class="space-y-3 text-sm">
                            @if($product->specifications)
                                @foreach($product->specifications as $key => $val)
                                    <div class="grid grid-cols-3 gap-4">
                                        <dt class="font-medium text-gray-500 capitalize">{{ $key }}</dt>
                                        <dd class="col-span-2 text-gray-900">{{ is_array($val) ? implode(', ', $val) : $val }}</dd>
                                    </div>
                                @endforeach
                            @endif

                            @if($product->compatibleModels->count() > 0)
                                <div class="grid grid-cols-3 gap-4 mt-3 pt-3 border-t border-gray-200">
                                    <dt class="font-medium text-gray-500">Compatible With</dt>
                                    <dd class="col-span-2 text-gray-900">
                                        {{ $product->compatibleModels->pluck('name')->join(', ') }}
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                @endif

                {{-- ACTION --}}
                <div class="mt-auto pt-6 border-t border-gray-200">
                    <div class="w-full sm:w-auto">
                        <x-inquire-button :product="$product" :isAvailable="$stock['isAvailable']" class="w-full sm:w-auto py-3 text-base" />
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{-- FOOTER --}}
    @include('layouts.footer')

</body>

</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $printerModel->full_name ?: $printerModel->model_name }} Compatible Supplies — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fraunces:400,500,600,700,900i&family=dm-sans:300,400,500,600" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
</head>

<body class="antialiased bg-white text-[#27272a] overflow-x-hidden min-h-screen flex flex-col">
    @include('layouts.navigation')

    <div class="max-w-[1280px] w-full mx-auto px-6 pt-8">
        <x-breadcrumb :items="$items" />
    </div>

    <header class="pt-6 pb-10 px-6 max-w-[1280px] w-full mx-auto">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 pb-8 border-b border-[#e4e4e7]">
            <div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-[#2563EB] mb-3">
                    {{ $printerModel->brand?->name ?? 'Printer' }} Compatible Supplies
                </span>
                <h1 class="font-['Kantumruy_Pro',sans-serif] text-3xl sm:text-4xl font-semibold text-[#27272a]">
                    {{ $printerModel->full_name ?: $printerModel->model_name }}
                </h1>
                <p class="mt-2 text-sm sm:text-base text-[#71717a]">
                    Showing {{ $compatibleProducts->count() }} compatible {{ \Illuminate\Support\Str::plural('product', $compatibleProducts->count()) }} for this printer model.
                </p>
            </div>

            <a href="{{ route('compatibility.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium border border-[#e4e4e7] text-[#27272a] hover:bg-[#fafafa] transition-colors shrink-0">
                ← Choose Another Printer
            </a>
        </div>
    </header>

    <main class="max-w-[1280px] w-full mx-auto px-6 pb-20 flex-1">
        @if ($groupedProducts->isEmpty())
            <div class="text-center py-20 px-6 bg-[#fafafa] rounded-2xl border border-[#e4e4e7]">
                <p class="text-lg font-medium text-[#27272a]">No compatible supplies are linked to this printer yet.</p>
                <p class="text-sm text-[#71717a] mt-2">Browse our full catalog or contact us for availability.</p>
                <div class="mt-6 flex flex-wrap items-center justify-center gap-3">
                    <a href="{{ route('product-catalog.index') }}"
                       class="inline-flex items-center px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-[#2563EB] hover:brightness-95 transition-all">
                        Browse Catalog
                    </a>
                    <a href="{{ route('compatibility.index') }}"
                       class="inline-flex items-center px-5 py-2.5 rounded-xl text-sm font-semibold text-[#27272a] bg-white border border-[#e4e4e7] hover:bg-gray-50 transition-all">
                        Back to Printer Models
                    </a>
                </div>
            </div>
        @else
            <div class="space-y-12">
                @foreach ($groupedProducts as $categoryName => $products)
                    <section>
                        <div class="flex items-center gap-4 mb-6">
                            <h2 class="font-['Kantumruy_Pro',sans-serif] text-2xl font-semibold text-[#27272a] whitespace-nowrap">
                                {{ $categoryName }}
                            </h2>
                            <div class="flex-1 h-px bg-[#e4e4e7]"></div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 lg:gap-6">
                            @foreach ($products as $product)
                                <x-product-card :product="$product" />
                            @endforeach
                        </div>
                    </section>
                @endforeach
            </div>
        @endif
    </main>

    @include('layouts.footer')
</body>

</html>

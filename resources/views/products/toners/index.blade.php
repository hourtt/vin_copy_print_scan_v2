<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ធូន័រ​ (Toners) - {{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fraunces:400,500,600,700,900i&family=dm-sans:300,400,500,600"
        rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/category-filter.js'])
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
</head>

<body class="antialiased bg-white text-[#27272a] overflow-x-hidden">
    @include('layouts.navigation')

    <div class="max-w-[1320px] mx-auto px-6 pt-8">
        <x-breadcrumb :items="$items" />
    </div>

    {{-- Hero --}}
    <div class="pt-24 pb-12 px-8 text-center bg-transparent">
        <h1 class="font-sans text-5xl font-medium text-[#27272a] tracking-tight leading-tight">
            ធូន័រ (Toners)
        </h1>
        <p class="mt-4 text-[#71717a] text-lg max-w-[500px] mx-auto">
            Reliable, high-yield cartridges to keep your workspace flowing without interruption.
        </p>
    </div>

    {{-- Controls bar --}}
    <div
        class="sticky top-0 z-30 flex flex-wrap items-center justify-between gap-6 px-6 py-4 bg-white border border-[#e4e4e7] rounded-2xl shadow-sm max-w-[1320px] mx-auto mb-8">

        {{-- Search --}}
        <div class="relative flex-1 min-w-[250px]">
            <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-[18px] h-[18px] text-[#71717a] pointer-events-none"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z" />
            </svg>
            <input type="search" id="toner-search" placeholder="Search toner models..." aria-label="Search toners"
                class="w-full pl-11 pr-4 py-3 border border-[#e4e4e7] rounded-lg text-sm bg-white text-[#27272a] placeholder-[#71717a] focus:outline-none focus:border-[#3f3f46] focus:ring-2 focus:ring-[#3f3f46]/10 transition-all">
        </div>

        {{-- Brand Pills --}}
        <x-category-pills :brands="$brands" />

        {{-- Sort --}}
        <x-sort-dropdown id="sort-select" :options="[
            'default' => 'Sort: Default',
            'price-asc' => 'Price: Low → High',
            'price-desc' => 'Price: High → Low',
            'name-asc' => 'Name A → Z',
        ]" label="Sort toners" />

    </div>

    {{-- Main content --}}
    <main class="max-w-[1280px] mx-auto px-6 pb-16">

        <p class="text-sm text-[#71717a] mb-6" id="results-count">
            Showing <strong id="count-num">{{ $products->count() }}</strong> items
        </p>

        {{-- Product Grid Area --}}
        <div class="relative min-h-[400px]" id="grid-container">
            {{-- Skeleton Loader (Hidden by default) --}}
            <div id="skeleton-grid" class="absolute inset-0 z-10 bg-white" style="display: none;">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 lg:gap-6 animate-pulse">
                    @for ($i = 0; $i < 8; $i++)
                        <div class="bg-gray-200 rounded-2xl h-[360px] w-full"></div>
                    @endfor
                </div>
            </div>

            {{-- Empty State (Hidden by default) --}}
            <div id="empty-state" class="hidden absolute inset-0 z-10">
                <div class="flex flex-col items-center justify-center text-center py-24 text-[#71717a] bg-white h-full">
                    <p class="text-lg">No products found matching your filters.</p>
                </div>
            </div>

            {{-- Product Groups --}}
            <div id="product-groups" class="transition-opacity duration-150 relative z-0">
                @include('components.products._grid', [
                    'products' => $products,
                    'groupBy' => 'brand_id',
                    'headingRelation' => 'brand',
                    'headingFallback' => 'Other',
                    'subLabelRelation' => 'brand',
                    'subLabelFallback' => 'Toner',
                    'compatKey' => 'compatibility',
                    'emptyMessage' => 'No toners found.',
                    'badgeCase' => 'uppercase',
                ])
            </div>
        </div>
    </main>

    @include('layouts.footer')
</body>

</html>

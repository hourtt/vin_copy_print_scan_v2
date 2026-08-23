<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Products Catalog | Vin Copy Print Scan V2</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fraunces:400,500,600,700,900i&family=dm-sans:300,400,500,600"
        rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#f8f9fa] text-[#212529] antialiased min-h-screen flex flex-col">
    @include('layouts.navigation')

    {{-- Top Header & Breadcrumbs --}}
    <div class="max-w-7xl mx-auto w-full px-4 md:px-6 pt-6 pb-2">
        <x-breadcrumb :items="$items" />
        <h1 class="text-3xl font-bold font-sans text-[#212529] mt-2">
            Product Catalogs
        </h1>
    </div>

    {{-- Main Container: Sidebar Filters & Product Grid --}}
    <div
        class="max-w-7xl mx-auto w-full px-4 md:px-6 my-4 md:my-6 flex flex-col md:flex-row gap-6 md:gap-8 items-start flex-1">
        <!-- Sidebar Filters -->
        <aside class="hidden md:block w-full md:w-[280px] shrink-0 md:sticky md:top-8">
            <h2 class="text-2xl font-bold mb-6 text-[#212529]">Filters</h2>

            <form action="{{ route('product-catalog.index') }}" method="GET" id="filter-form">

                <!-- Category Filter -->
                <div class="mb-8">
                    <div
                        class="text-xs font-semibold uppercase tracking-wider text-[#6c757d] p-2 mb-4 rounded bg-white/50">
                        Category</div>
                    <ul class="flex flex-col gap-3 m-0 p-0 list-none">
                        @foreach ($categories as $category)
                            <li>
                                @auth
                                    <label class="flex items-center gap-3 cursor-pointer text-sm text-[#212529]">
                                        <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                            {{ is_array(request('categories')) && in_array($category->id, request('categories')) ? 'checked' : '' }}
                                            onchange="document.getElementById('filter-form').submit();"
                                            class="w-4 h-4 border border-[#dee2e6] rounded text-[#0056b3] cursor-pointer focus:ring-[#0056b3]">
                                        {{ $category->name }}
                                    </label>
                                @else
                                    <label
                                        class="flex items-center gap-3 cursor-not-allowed text-sm text-[#6c757d] opacity-75">
                                        <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                            {{ is_array(request('categories')) && in_array($category->id, request('categories')) ? 'checked' : '' }}
                                            onchange="document.getElementById('filter-form').submit();" disabled
                                            class="w-4 h-4 border border-[#dee2e6] rounded text-[#0056b3] focus:ring-[#0056b3]">
                                        {{ $category->name }}
                                    </label>
                                @endauth
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Price Range Filter -->
                <div class="mb-8">
                    <div
                        class="text-xs font-semibold uppercase tracking-wider text-[#6c757d] p-2 mb-4 rounded bg-white/50">
                        Price Range</div>
                    <div class="flex items-center gap-2 flex-wrap sm:flex-nowrap">
                        <div class="relative flex-1">
                            <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-[#6c757d] text-sm">$</span>
                            <input type="number" name="min_price" placeholder="Min" value="{{ request('min_price') }}"
                                min="10" step="10"
                                class="w-full pl-6 pr-2 py-2 border border-[#dee2e6] rounded text-sm focus:border-[#0056b3] focus:ring-1 focus:ring-[#0056b3] outline-none transition-colors">
                        </div>
                        <span class="text-[#6c757d] font-medium">-</span>
                        <div class="relative flex-1">
                            <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-[#6c757d] text-sm">$</span>
                            <input type="number" name="max_price" placeholder="Max" value="{{ request('max_price') }}"
                                min="10" step="10"
                                class="w-full pl-6 pr-2 py-2 border border-[#dee2e6] rounded text-sm focus:border-[#0056b3] focus:ring-1 focus:ring-[#0056b3] outline-none transition-colors">
                        </div>
                    </div>
                    @auth
                        <button type="submit"
                            class="w-full mt-4 py-2 px-4 bg-[#dee2e6]/50 hover:bg-[#dee2e6] border border-[#dee2e6] rounded text-sm font-medium transition-colors cursor-pointer text-[#212529]">
                            Apply Price
                        </button>
                    @else
                        <button type="submit"
                            class="w-full mt-4 py-2 px-4 bg-[#dee2e6]/30 border border-[#dee2e6]/50 rounded text-sm font-medium text-[#6c757d] cursor-not-allowed"
                            disabled>
                            Sign in to Apply Price
                        </button>
                    @endauth
                </div>

                <!-- Hidden sort field to keep sort state when filtering -->
                @if (request()->has('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
            </form>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 min-w-0 w-full">
            <!-- Top Bar -->
            <div
                class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8 pb-4 border-b border-[#dee2e6]">
                <div class="text-sm text-[#6c757d]">
                    Showing {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }} of
                    {{ $products->total() }} products
                </div>

                <x-sort-dropdown id="catalog-sort-select" :options="[
                    'recommended' => 'Recommended',
                    'newest' => 'Newest',
                    'price_asc' => 'Price: Low → High',
                    'price_desc' => 'Price: High → Low',
                ]" :selected="request('sort', 'recommended')"
                    label="Sort catalog products" formId="filter-form" />
            </div>

            <!-- Product Grid Grouped by Category -->
            <div class="space-y-8">
                @forelse($products->groupBy(function($item) { return $item->category->name ?? 'Uncategorized'; }) as $categoryName => $groupedProducts)
                    <div>
                        <h3 class="text-xl font-bold text-[#212529] mb-4">{{ $categoryName }}</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6">
                            @foreach ($groupedProducts as $product)
                                @include('components.product-card-catalog', ['product' => $product])
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="text-center p-12 text-[#6c757d] bg-white rounded-xl border border-[#dee2e6]">
                        No products found matching your criteria.
                    </div>
                @endforelse
            </div>

        </main>
    </div>

    <!-- PAGINATION -->
    <div class="w-full flex items-center justify-center my-8 px-4">
        <x-pagination :paginator="$products" />
    </div>

    <div class="md:hidden fixed bottom-6 left-1/2 -translate-x-1/2 z-40">
        <button type="button"
            onclick="document.getElementById('mobile-filter-sheet').classList.remove('translate-y-full'); document.getElementById('mobile-filter-overlay').classList.remove('opacity-0', 'pointer-events-none'); document.body.style.overflow = 'hidden';"
            class="bg-[#212529] text-white px-6 py-3 rounded-full shadow-2xl font-medium flex items-center gap-2 border border-white/20">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                </path>
            </svg>
            Filters
        </button>
    </div>

    <!-- Mobile Filter Bottom Sheet Overlay -->
    <div id="mobile-filter-overlay"
        class="md:hidden fixed inset-0 bg-black/60 z-50 opacity-0 pointer-events-none transition-opacity duration-300"
        onclick="document.getElementById('mobile-filter-sheet').classList.add('translate-y-full'); document.getElementById('mobile-filter-overlay').classList.add('opacity-0', 'pointer-events-none'); document.body.style.overflow = '';">
    </div>

    <!-- Mobile Filter Bottom Sheet -->
    <div id="mobile-filter-sheet"
        class="md:hidden fixed bottom-0 left-0 right-0 h-[75vh] bg-white z-50 rounded-t-3xl transform translate-y-full transition-transform duration-300 ease-in-out flex flex-col shadow-2xl border-t border-[#dee2e6]">
        <!-- Drag Handle Indicator -->
        <div class="absolute top-3 left-1/2 -translate-x-1/2 w-12 h-1.5 bg-[#dee2e6] rounded-full"></div>

        <!-- Sheet Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-[#dee2e6] mt-4">
            <h2 class="text-xl font-bold text-[#212529]">Filters</h2>
            <button type="button" class="text-[#6c757d] hover:text-[#212529] transition-colors p-1"
                onclick="document.getElementById('mobile-filter-sheet').classList.add('translate-y-full'); document.getElementById('mobile-filter-overlay').classList.add('opacity-0', 'pointer-events-none'); document.body.style.overflow = '';">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Sheet Content -->
        <div class="flex-1 overflow-y-auto px-6 py-6">
            <form action="{{ route('product-catalog.index') }}" method="GET" id="mobile-filter-form">
                <!-- Category Filter -->
                <div class="mb-8">
                    <div class="text-sm font-bold text-[#212529] mb-4">Category</div>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach ($categories as $category)
                            <div class="relative">
                                @auth
                                    <input type="checkbox" name="categories[]" id="cat-mobile-{{ $category->id }}"
                                        value="{{ $category->id }}"
                                        {{ is_array(request('categories')) && in_array($category->id, request('categories')) ? 'checked' : '' }}
                                        class="peer absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 border border-[#dee2e6] rounded text-[#0056b3] focus:ring-[#0056b3] bg-white z-10 cursor-pointer">
                                    <label for="cat-mobile-{{ $category->id }}"
                                        class="flex items-center w-full p-3 pl-11 text-sm font-medium text-[#6c757d] bg-white border border-[#dee2e6] rounded-xl cursor-pointer transition-colors peer-checked:border-[#0056b3] peer-checked:text-[#0056b3] peer-checked:bg-[#f8faff] hover:border-[#0056b3]">
                                        <span class="truncate">{{ $category->name }}</span>
                                    </label>
                                @else
                                    <input type="checkbox" name="categories[]" id="cat-mobile-{{ $category->id }}"
                                        value="{{ $category->id }}"
                                        {{ is_array(request('categories')) && in_array($category->id, request('categories')) ? 'checked' : '' }}
                                        disabled
                                        class="peer absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 border border-[#dee2e6] rounded text-[#0056b3] focus:ring-[#0056b3] bg-[#f8f9fa] z-10 cursor-not-allowed opacity-50">
                                    <label for="cat-mobile-{{ $category->id }}"
                                        class="flex items-center w-full p-3 pl-11 text-sm font-medium text-[#6c757d] bg-[#f8f9fa] border border-[#dee2e6] rounded-xl cursor-not-allowed opacity-75">
                                        <span class="truncate">{{ $category->name }}</span>
                                    </label>
                                @endauth
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Price Range Filter -->
                <div class="mb-8">
                    <div class="text-sm font-bold text-[#212529] mb-4">Price Range</div>
                    <div class="flex items-center gap-4">
                        <div class="relative flex-1">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[#6c757d] text-sm">$</span>
                            <input type="number" name="min_price" id="filter-min-price" placeholder="Min"
                                value="{{ request('min_price') }}" min="10" step="10"
                                class="w-full pl-6 pr-2 py-2 border border-[#dee2e6] rounded text-sm focus:border-[#0056b3] focus:ring-1 focus:ring-[#0056b3] outline-none transition-colors">
                        </div>
                        <span class="text-[#6c757d] font-medium">-</span>
                        <div class="relative flex-1">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[#6c757d] text-sm">$</span>
                            <input type="number" name="max_price" id="filter-max-price" placeholder="Max"
                                value="{{ request('max_price') }}" min="10" step="10"
                                class="w-full pl-6 pr-2 py-2 border border-[#dee2e6] rounded text-sm focus:border-[#0056b3] focus:ring-1 focus:ring-[#0056b3] outline-none transition-colors">
                        </div>
                    </div>
                </div>

                @if (request()->has('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
            </form>
        </div>

        <!-- Fixed Action Area -->
        <div class="px-6 py-4 border-t border-[#dee2e6] bg-white grid grid-cols-2 gap-4 pb-8">
            <button type="button" onclick="window.location.href='{{ route('product-catalog.index') }}'"
                class="w-full py-3 px-4 bg-white hover:bg-[#f8f9fa] border border-[#dee2e6] rounded-lg text-sm font-medium transition-colors text-[#212529] text-center shadow-sm">
                Clear All
            </button>
            @auth
                <button type="button" data-action="apply-price-filter"
                    class="w-full mt-4 py-2 px-4 bg-[#dee2e6]/50 hover:bg-[#dee2e6] border border-[#dee2e6] rounded text-sm font-medium transition-colors cursor-pointer text-[#212529]">
                    Apply Price
                </button>
                <p id="price-filter-error" class="hidden mt-2 text-xs text-red-600">
                    Please filter the product before the apply the filter
                </p>
            @else
                <button type="submit"
                    class="w-full mt-4 py-2 px-4 bg-[#dee2e6]/30 border border-[#dee2e6]/50 rounded text-sm font-medium text-[#6c757d] cursor-not-allowed"
                    disabled>
                    Sign in to Apply Price
                </button>
            @endauth
        </div>
    </div>

    @include('layouts.footer')
</body>

</html>

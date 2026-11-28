<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Find by Printer — {{ config('app.name') }}</title>
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

    <header class="pt-8 pb-10 px-6 text-center max-w-[780px] mx-auto">
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-[#2563EB] mb-4">
            Compatibility Directory
        </span>
        <h1 class="font-['Kantumruy_Pro',sans-serif] text-3xl sm:text-5xl font-semibold text-[#27272a] tracking-tight">
            Find Supplies by Printer Model
        </h1>
        <p class="mt-4 text-[#71717a] text-base sm:text-lg">
            Select your printer brand and model to see all compatible toners and ink cartridges we carry.
        </p>
    </header>

    <main class="max-w-[1280px] w-full mx-auto px-6 pb-20 flex-1"
          x-data="{
              query: @js($search ?? ''),
              activeBrand: @js($selectedBrand?->slug ?? 'all'),
              matches(brandSlug, modelName) {
                  const brandOk = this.activeBrand === 'all' || this.activeBrand === brandSlug;
                  const q = this.query.trim().toLowerCase();
                  const textOk = !q || modelName.toLowerCase().includes(q);
                  return brandOk && textOk;
              }
          }">

        {{-- Search + Brand Filter Bar --}}
        <form method="GET" action="{{ route('compatibility.index') }}"
              class="flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4 p-5 bg-white border border-[#e4e4e7] rounded-2xl shadow-sm mb-10">
            <div class="relative flex-1">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-[18px] h-[18px] text-[#71717a] pointer-events-none"
                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z" />
                </svg>
                <input type="search"
                       name="search"
                       x-model="query"
                       value="{{ $search }}"
                       placeholder="Search printer model (e.g. M404dn, L3250, MF445dw)..."
                       aria-label="Search printer models"
                       class="w-full pl-11 pr-4 py-3 border border-[#e4e4e7] rounded-xl text-sm bg-white text-[#27272a] placeholder-[#71717a] focus:outline-none focus:border-[#2563EB] focus:ring-2 focus:ring-[#2563EB]/10 transition-all">
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <button type="button"
                        @click="activeBrand = 'all'"
                        :class="activeBrand === 'all' ? 'bg-[#27272a] text-white border-transparent' : 'bg-white text-[#71717a] border-[#e4e4e7] hover:border-[#3f3f46] hover:text-[#27272a]'"
                        class="px-4 py-2 rounded-full text-xs sm:text-sm font-medium border transition-colors cursor-pointer">
                    All Brands
                </button>
                @foreach ($brands as $brand)
                    <button type="button"
                            @click="activeBrand = '{{ $brand->slug }}'"
                            :class="activeBrand === '{{ $brand->slug }}' ? 'bg-[#27272a] text-white border-transparent' : 'bg-white text-[#71717a] border-[#e4e4e7] hover:border-[#3f3f46] hover:text-[#27272a]'"
                            class="px-4 py-2 rounded-full text-xs sm:text-sm font-medium border transition-colors cursor-pointer">
                        {{ $brand->name }}
                    </button>
                @endforeach
            </div>
        </form>

        {{-- Printer Models Grouped by Brand --}}
        @if ($groupedModels->isEmpty())
            <div class="text-center py-20 px-6 bg-[#fafafa] rounded-2xl border border-[#e4e4e7]">
                <p class="text-lg font-medium text-[#27272a]">No printer models matched your search.</p>
                <p class="text-sm text-[#71717a] mt-2">Try clearing your filter or browsing our full catalog.</p>
                <a href="{{ route('compatibility.index') }}"
                   class="inline-flex items-center mt-5 px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-[#2563EB] hover:brightness-95 transition-all">
                    Reset Filters
                </a>
            </div>
        @else
            <div class="space-y-12">
                @foreach ($groupedModels as $brandName => $models)
                    @php
                        $brandSlug = $models->first()?->brand?->slug ?? 'other';
                    @endphp
                    <section x-show="activeBrand === 'all' || activeBrand === '{{ $brandSlug }}'" x-cloak>
                        <div class="flex items-center gap-4 mb-5">
                            <h2 class="font-['Kantumruy_Pro',sans-serif] text-2xl font-semibold text-[#27272a] whitespace-nowrap">
                                {{ $brandName }}
                            </h2>
                            <div class="flex-1 h-px bg-[#e4e4e7]"></div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                            @foreach ($models as $model)
                                <a href="{{ route('compatibility.show', $model) }}"
                                   x-show="matches('{{ $brandSlug }}', @js($model->model_name))"
                                   class="group flex flex-col justify-between p-5 bg-white border border-[#e4e4e7] rounded-2xl shadow-sm hover:-translate-y-1 hover:border-[#2563EB]/40 hover:shadow-md transition-all duration-200">
                                    <div>
                                        <span class="text-xs font-bold uppercase tracking-wider text-[#2563EB]">
                                            {{ $brandName }}
                                        </span>
                                        <h3 class="mt-1.5 font-['Kantumruy_Pro',sans-serif] text-lg font-semibold text-[#27272a] group-hover:text-[#2563EB] transition-colors">
                                            {{ $model->model_name }}
                                        </h3>
                                    </div>

                                    <div class="mt-4 pt-3 border-t border-[#f4f4f5] flex items-center justify-between text-xs text-[#71717a]">
                                        <span>
                                            {{ $model->compatible_products_count ?? 0 }}
                                            {{ \Illuminate\Support\Str::plural('compatible item', $model->compatible_products_count ?? 0) }}
                                        </span>
                                        <span class="font-semibold text-[#27272a] group-hover:text-[#2563EB]">
                                            View →
                                        </span>
                                    </div>
                                </a>
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

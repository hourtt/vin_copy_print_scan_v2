@php $columns ??= 4; @endphp

<section class="py-12 px-4 md:px-8">
    <div class="max-w-[1280px] mx-auto">
        {{-- Section Header --}}
        <div class="flex items-center justify-between mb-8">
            <h2 class="font-sans text-2xl font-semibold text-[#1a1a2e]">{{ $title }}</h2>
            <a href="{{ $viewAllRoute }}"
                class="text-blue-600 font-semibold text-sm no-underline hover:text-blue-800 transition-colors">
                View All &rarr;
            </a>
        </div>

        {{-- Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-{{ $columns }} gap-5 lg:gap-6">
            @foreach ($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </div>
</section>

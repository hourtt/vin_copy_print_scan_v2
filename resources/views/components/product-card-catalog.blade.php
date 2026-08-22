@props(['product'])

@php
    $stock = $product->stock_status;
@endphp

<article
    class="group relative flex flex-col h-full bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 ease-in-out p-3 border border-[#dee2e6]/60">

    <!-- Image Container -->
    <div
        class="relative w-full aspect-[4/3] bg-slate-50 rounded-lg overflow-hidden flex items-center justify-center mb-3">
        <!-- Stock Badge -->
        <span class="absolute top-2 left-2 text-[10px] font-bold px-2 py-0.5 rounded-md z-10 whitespace-nowrap {{ $stock['badgeBg'] ?? 'bg-gray-100 text-gray-800' }}">
            {{ $stock['label'] ?? 'In Stock' }}
        </span>

        @if ($product->image)
            <img src="{{ asset($product?->image) }}" alt="{{ $product?->name }}" loading="lazy"
                class="w-full h-full object-contain p-3 group-hover:scale-105 transition-transform duration-500">
        @else
            <span class="text-slate-400 text-xs font-medium uppercase tracking-wider">No Image</span>
        @endif
    </div>

    <!-- Card Body -->
    <div class="flex flex-col flex-1">
        <span class="text-[11px] font-semibold text-blue-600 uppercase tracking-wider mb-1">
            {{ $product?->category?->name ?? 'Category' }}
        </span>
        <h3 class="text-sm font-medium text-slate-900 leading-snug mb-3 line-clamp-2 break-words" title="{{ $product?->name }}">
            {{ $product?->name }}
        </h3>

        <div class="mt-auto flex items-end justify-between gap-2 pt-2">
            <span class="text-base sm:text-lg font-bold text-slate-900">
                ${{ number_format($product->price, 2) }}
            </span>
            
            <x-inquire-button :product="$product" :isAvailable="$stock['isAvailable'] ?? true" />
        </div>
    </div>
</article>

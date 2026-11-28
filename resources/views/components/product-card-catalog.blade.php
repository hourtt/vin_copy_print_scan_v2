@props(['product'])

@php
    $stock = $product->stock_status;
    $isOnSale = $product->is_on_sale;
    $effectivePrice = $product->effective_price;
@endphp

<article
    class="group relative flex flex-col h-full bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 ease-in-out p-3.5 border border-[#dee2e6]/60">

    <!-- Image Container -->
    <div
        class="relative w-full aspect-[4/3] bg-slate-50 rounded-lg overflow-hidden flex items-center justify-center mb-3">
        <!-- Stock Badge -->
        <span class="absolute top-2 left-2 text-[10px] font-bold px-2 py-0.5 rounded-md z-10 whitespace-nowrap {{ $stock['badgeBg'] ?? 'bg-gray-100 text-gray-800' }}">
            {{ $stock['label'] ?? 'In Stock' }}
        </span>

        @if ($isOnSale)
            <span class="absolute top-2 right-2 text-[10px] font-bold uppercase px-2 py-0.5 rounded-md z-10 bg-red-600 text-white">
                Sale
            </span>
        @endif

        @if ($product->image_url)
            <img src="{{ $product->image_url }}" alt="{{ $product?->name }}" loading="lazy"
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

        <div class="mt-auto flex items-center justify-between gap-2 pt-2 border-t border-slate-100">
            <div class="min-w-0">
                <span class="text-base font-bold text-slate-900 whitespace-nowrap">
                    ${{ number_format($effectivePrice, 2) }}
                </span>
                @if ($isOnSale)
                    <span class="block text-xs text-slate-400 line-through whitespace-nowrap">
                        ${{ number_format($product->price, 2) }}
                    </span>
                @endif
            </div>

            <a href="{{ route('products.show', $product) }}" class="inline-flex items-center justify-center whitespace-nowrap shrink-0 min-h-[36px] px-3 py-2 rounded-lg text-xs font-semibold transition-all duration-200 bg-[#2563EB] text-white hover:brightness-95 active:scale-95">
                View Detail
            </a>
        </div>
    </div>
</article>

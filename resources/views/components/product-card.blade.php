@props(['product', 'showBadge' => null, 'isCarouselCard' => false])

@php
    $stock = $product->stock_status;
    $isOnSale = $product->is_on_sale;
    $effectivePrice = $product->effective_price;
@endphp

<article {{ $attributes->merge(['class' => 'bg-white border border-[#e4e4e7] rounded-2xl overflow-hidden flex flex-col shadow-sm hover:-translate-y-1.5 hover:shadow-lg transition-all duration-300 ease-in-out']) }}
    {{ $isCarouselCard ? 'data-carousel-card' : '' }}>
    
    {{-- Image --}}
    <div class="relative aspect-[4/3] bg-[#fafafa] flex items-center justify-center overflow-hidden border-b border-[#e4e4e7]">
        @if ($product->image)
            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" loading="lazy"
                class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
        @else
            <span class="text-sm text-[#000000]">No image</span>
        @endif

        {{-- Stock badge --}}
        <span class="absolute top-3 right-3 text-[0.65rem] font-semibold capitalize tracking-wide px-2 py-1 rounded-lg whitespace-nowrap {{ $stock['badgeBg'] ?? 'bg-gray-100 text-gray-800' }}">
            {{ $stock['label'] }}
        </span>

        @if ($showBadge)
             <span class="absolute top-3 left-3 text-[0.70rem] font-semibold capitalize tracking-wide px-2 py-1 rounded-lg bg-blue-100 text-blue-900">
                {{ $showBadge }}
            </span>
        @endif

        @if ($isOnSale)
            <span class="absolute {{ $showBadge ? 'bottom-3' : 'top-3' }} left-3 text-[0.65rem] font-bold uppercase tracking-wide px-2 py-1 rounded-lg bg-red-600 text-white">
                Sale
            </span>
        @endif
    </div>

    {{-- Card Body --}}
    <div class="flex flex-col flex-1 p-4 sm:p-5 gap-2">
        <div class="text-xs font-bold capitalize tracking-wide text-[#3f3f46]">
            {{ $product->brand->name ?? ($product->category->name ?? 'Product') }}
        </div>
        <div class="font-['Kantumruy_Pro',serif] text-base sm:text-lg font-semibold text-[#27272a] leading-snug line-clamp-2"
            title="{{ $product->name }}">
            {{ $product->name }}
        </div>

        {{-- Footer: Price + Action --}}
        <div class="flex flex-row items-center justify-between mt-auto pt-3 border-t border-[#e4e4e7]">
            <div>
                <span class="text-lg sm:text-xl font-bold text-[#27272a]">${{ number_format($effectivePrice, 2) }}</span>
                @if ($isOnSale)
                    <span class="text-sm text-[#a1a1aa] line-through ml-1">${{ number_format($product->price, 2) }}</span>
                @endif
            </div>

            @auth
                <x-add-to-cart-button :product="$product" :isAvailable="$stock['isAvailable']" />
            @else
                <a href="{{ route('login') }}"
                    class="inline-flex items-center justify-center min-h-[36px] px-4 py-2 border border-[#e4e4e7] bg-[#ffffff] text-[#27272a] text-xs sm:text-sm font-semibold rounded-lg hover:border-[#3f3f46] hover:text-[#3f3f46] transition-all duration-200">
                    Sign In
                </a>
            @endauth
        </div>
    </div>
</article>

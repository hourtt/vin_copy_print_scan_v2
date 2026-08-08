@forelse ($products->groupBy($groupBy) as $groupKey => $grouped)
    @php $groupHeading = $grouped->first()->{$headingRelation}->name ?? $headingFallback; @endphp

    <section class="category-section mb-12" data-cat="{{ $groupKey }}">

        {{-- Group Heading --}}
        <div class="flex items-center gap-4 mb-6">
            <h2 class="font-['Kantumruy Pro',serif] text-2xl font-semibold text-[#27272a] whitespace-nowrap">
                {{ $groupHeading }}
            </h2>
            <div class="flex-1 h-px bg-[#e4e4e7]"></div>
        </div>

        {{-- Product Grid --}}
        <div class="product-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 lg:gap-6"
            id="grid-{{ $groupKey }}">

            @foreach ($grouped as $product)
                @php
                    $stock      = (int) $product->stock;
                    $stockClass = $stock <= 0 ? 'out-stock' : ($stock <= 5 ? 'low-stock' : 'in-stock');
                    $stockLabel = $stock <= 0 ? 'Out of stock' : ($stock <= 5 ? "Only {$stock} left" : 'In stock');
                    $badgeBg    = match ($stockClass) {
                        'in-stock'  => 'bg-green-100 text-green-800',
                        'low-stock' => 'bg-yellow-100 text-yellow-800',
                        default     => 'bg-red-100 text-red-800',
                    };
                    if (str_starts_with($compatKey, 'spec:')) {
                        $specKey      = substr($compatKey, 5);
                        $compatValue  = $product->specifications[$specKey] ?? null;
                    } else {
                        $compatValue  = $product->{$compatKey} ?? null;
                    }

                    // Sub-label: brand->name or category->name with fallback
                    $subLabel = $product->{$subLabelRelation}->name ?? $subLabelFallback;
                @endphp

                <article
                    class="product-card group bg-white border border-[#e4e4e7] rounded-2xl overflow-hidden flex flex-col shadow-sm hover:-translate-y-1.5 hover:shadow-lg transition-all duration-300 ease-in-out"
                    data-cat="{{ $product->category_id }}"
                    data-brand="{{ $product->brand_id ?? '' }}"
                    data-name="{{ strtolower($product?->name ?? '') }}"
                    data-price="{{ $product->price }}">

                    {{-- Image --}}
                    <div class="relative aspect-[4/3] bg-[#fafafa] flex items-center justify-center overflow-hidden border-b border-[#e4e4e7]">
                        @if ($product->image)
                            <img src="{{ asset($product?->image) }}" alt="{{ $product?->name }}"
                                loading="lazy"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <span class="text-sm text-[#000000]">No image</span>
                        @endif

                        {{-- Stock badge --}}
                        <span class="absolute top-3 right-3 text-[0.65rem] font-semibold capitalize tracking-wide px-2 py-1 rounded-lg {{ $badgeCase }} {{ $badgeBg }}">
                            {{ $stockLabel }}
                        </span>
                    </div>

                    {{-- Card Body --}}
                    <div class="flex flex-col flex-1 p-4 sm:p-5 gap-2">
                        <div class="text-xs font-bold capitalize tracking-wide text-[#3f3f46]">
                            {{ $subLabel }}
                        </div>
                        <div class="font-['Kantumruy Pro',serif] text-base sm:text-lg font-semibold text-[#27272a] leading-snug line-clamp-2"
                            title="{{ $product?->name }}">
                            {{ $product?->name }}
                        </div>

                        @if (!empty($compatValue))
                            <div class="text-xs text-[#71717a] line-clamp-1">
                                Fits: {{ $compatValue }}
                            </div>
                        @endif

                        {{-- Footer: Price + Action --}}
                        <div class="flex flex-row items-center justify-between mt-auto pt-3 border-t border-[#e4e4e7]">
                            <span class="text-lg sm:text-xl font-bold text-[#27272a]">
                                ${{ number_format($product->price, 2) }}
                            </span>

                            @auth
                                <x-add-to-cart-button :product="$product" :isAvailable="$stock > 0" />
                            @else
                                <a href="{{ route('login') }}"
                                    class="inline-flex items-center justify-center min-h-[36px] px-4 py-2 border border-[#e4e4e7] bg-[#ffffff] text-[#27272a] text-xs sm:text-sm font-semibold rounded-lg hover:border-[#3f3f46] hover:text-[#3f3f46] transition-all duration-200">
                                    Sign In
                                </a>
                            @endauth
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </section>

@empty
    <div class="text-center py-24 text-[#71717a] col-span-full">
        <p class="text-lg">{{ $emptyMessage }}</p>
    </div>
@endforelse

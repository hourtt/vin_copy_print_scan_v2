@if (isset($featured) && $featured->count())
    <section class="bg-[#f8f9fa] py-16 px-4 md:px-8">
        <div class="max-w-[1280px] mx-auto">
            {{-- Section Header --}}
            <div class="flex items-center justify-between mb-8">
                <h2 class="font-sans text-2xl font-semibold text-[#1a1a2e]">Featured Products</h2>
                <a href="{{ route('products.printers.index') }}"
                    class="text-blue-600 font-semibold text-sm no-underline hover:text-blue-800 transition-colors">
                    View All &rarr;
                </a>
            </div>

            {{-- Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($featured as $product)
                    @php
                        $stock = (int) $product->stock;
                        $stockClass = $stock <= 0 ? 'out-stock' : ($stock <= 5 ? 'low-stock' : 'in-stock');
                        $stockLabel = $stock <= 0 ? 'Out of stock' : ($stock <= 5 ? "Only {$stock} left" : 'In stock');
                        $badgeBg = match ($stockClass) {
                            'in-stock' => 'bg-green-100 text-green-800',
                            'low-stock' => 'bg-yellow-100 text-yellow-800',
                            default => 'bg-red-100 text-red-800',
                        };
                        $effectivePrice = $product->discount_price ?? $product->price;
                        $isOnSale = $product->discount_price !== null && $product->discount_price < $product->price;
                    @endphp

                    <article
                        class="group bg-white border border-[#e4e4e7] rounded-2xl overflow-hidden flex flex-col shadow-sm hover:-translate-y-1.5 hover:shadow-lg transition-all duration-300 ease-in-out">

                        {{-- Image --}}
                        <div
                            class="relative aspect-[4/3] bg-[#fafafa] flex items-center justify-center overflow-hidden border-b border-[#e4e4e7]">
                            @if ($product->image)
                                <img src="{{ asset($product?->image) }}" alt="{{ $product?->name }}" loading="lazy"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <span class="text-sm text-[#000000]">No image</span>
                            @endif

                            <span
                                class="absolute top-3 right-3 text-[0.65rem] font-semibold capitalize tracking-wide px-2 py-1 rounded-lg {{ $badgeBg }}">
                                {{ $stockLabel }}
                            </span>

                            <span
                                class="absolute top-3 left-3 text-[0.70rem] font-semibold capitalize tracking-wide px-2 py-1 rounded-lg bg-blue-100 text-blue-900">
                                Featured
                            </span>

                            @if ($isOnSale)
                                <span
                                    class="absolute bottom-3 left-3 text-[0.65rem] font-bold uppercase tracking-wide px-2 py-1 rounded-lg bg-red-600 text-white">
                                    Sale
                                </span>
                            @endif
                        </div>

                        {{-- Card Body --}}
                        <div class="flex flex-col flex-1 p-4 sm:p-5 gap-2">
                            <div class="text-xs font-bold capitalize tracking-wide text-[#3f3f46]">
                                {{ $product?->brand?->name ?? ($product?->category?->name ?? 'Product') }}
                            </div>
                            <div class="font-['Kantumruy_Pro',serif] text-base sm:text-lg font-semibold text-[#27272a] leading-snug line-clamp-2"
                                title="{{ $product?->name }}">
                                {{ $product?->name }}
                            </div>

                            {{-- Footer: Price + Action --}}
                            <div
                                class="flex flex-row items-center justify-between mt-auto pt-3 border-t border-[#e4e4e7]">
                                <div>
                                    <span
                                        class="text-lg sm:text-xl font-bold text-[#27272a]">${{ number_format($effectivePrice, 2) }}</span>
                                    @if ($isOnSale)
                                        <span
                                            class="text-sm text-[#a1a1aa] line-through ml-1">${{ number_format($product->price, 2) }}</span>
                                    @endif
                                </div>

                                <a href="{{ route('products.show', $product) }}" class="inline-flex items-center justify-center gap-1.5 min-h-[36px] px-4 py-2 rounded-lg text-xs sm:text-sm font-semibold transition-all duration-200 bg-[#2563EB] text-white hover:brightness-95 active:scale-95">
                                    View Detail
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endif

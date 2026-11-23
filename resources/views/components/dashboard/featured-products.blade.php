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
                    <x-product-card :product="$product" showBadge="Featured" />
                @endforeach
            </div>
        </div>
    </section>
@endif

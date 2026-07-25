@props(['cartItems'])

<div class="bg-white border border-[#e4e4e7] shadow-sm rounded-2xl p-6 lg:sticky lg:top-8">
    <h2 class="font-['Kantumruy_Pro',sans-serif] text-2xl font-bold mb-6 text-[#27272a]">Your Cart</h2>

    <div class="space-y-4 mb-6 max-h-[400px] overflow-y-auto pr-2">
        @foreach ($cartItems as $item)
            <x-checkout.cart-item :item="$item" />
        @endforeach
    </div>

    <hr class="border-[#e4e4e7] my-6">

    <!-- Discount Code -->
    <div class="flex gap-2 mb-6">
        <input type="text" placeholder="Discount code" class="form-input flex-grow text-sm py-2">
        <button type="button"
            class="bg-[#e4e4e7] text-[#27272a] px-4 rounded-lg font-medium text-sm hover:bg-[#d4d4d8] transition-colors">Apply</button>
    </div>

    <!-- Totals -->
    <div class="space-y-3 text-sm text-[#71717a]">
        <div class="flex justify-between">
            <span>Subtotal</span>
            <span class="font-medium text-[#27272a]" x-text="formatPrice(subtotal)"></span>
        </div>
        <div class="flex justify-between">
            <span>Shipping</span>
            <span class="font-medium text-[#27272a]"
                x-text="parseFloat(shippingFee) === 0 ? 'Free' : formatPrice(shippingFee)"></span>
        </div>
        <div class="flex justify-between items-center">
            <span class="flex items-center gap-1">
                Estimated taxes
                <svg class="w-3.5 h-3.5 text-[#a1a1aa]" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24" title="Taxes calculated at checkout">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </span>
            <span class="font-medium text-[#27272a]">$0.00</span>
        </div>
    </div>

    <hr class="border-[#e4e4e7] my-4">

    <div class="flex justify-between items-center mb-2">
        <span class="font-bold text-lg text-[#27272a]">Total</span>
        <span class="font-bold text-2xl text-[#27272a]" x-text="formatPrice(total)"></span>
    </div>
</div>

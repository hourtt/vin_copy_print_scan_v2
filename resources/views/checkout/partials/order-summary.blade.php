<div class="order-summary-card">
    <div class="summary-header">
        <h3>Order Summary</h3>
    </div>

    <!-- Dynamic Cart Items -->
    <div class="summary-items">
        @foreach($cartItems as $item)
        <div class="summary-item">
            <div class="summary-item-img">
                @if($item->product->image)
                    <img src="{{ Storage::url($item->product?->image) }}" alt="{{ $item->product?->name }}" onerror="this.src='https://via.placeholder.com/60x60?text=Item'" loading="lazy">
                @else
                    <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400 text-xs">No Image</div>
                @endif
            </div>
            <div class="summary-item-details">
                <h4 class="summary-item-title">{{ $item->product?->name }}</h4>
                <div class="summary-item-qty">Qty: {{ $item->quantity }}</div>
            </div>
            <div class="summary-item-price">${{ number_format(($item->product?->price ?? 0) * $item->quantity, 2) }}</div>
        </div>
        @endforeach
    </div>

    <div class="summary-totals">
        <div class="totals-row">
            <span>Subtotal</span>
            <span x-text="`$` + subtotal.toFixed(2)">${{ number_format($subtotal ?? 0, 2) }}</span>
        </div>
        
        <div class="totals-row">
            <span>Shipping <span x-show="deliveryMethod === 'delivery'">(Standard)</span><span x-show="deliveryMethod === 'pickup'">(Pickup)</span></span>
            <span x-text="`$` + shippingCost.toFixed(2)">${{ number_format($shippingFee ?? 0, 2) }}</span>
        </div>

        <div class="totals-row">
            <span>Tax (Estimated)</span>
            <span x-text="`$` + tax.toFixed(2)">${{ number_format($tax ?? 0, 2) }}</span>
        </div>

        <div class="totals-row grand-total">
            <span>Total</span>
            <span class="grand-total-amount" x-text="`$` + total.toFixed(2)">${{ number_format($total ?? 0, 2) }}</span>
        </div>
    </div>

    <div class="checkout-action">
        <button type="submit" class="btn-place-order">
            PLACE ORDER 
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
        </button>
        <div class="secure-badge">
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
            Secure encrypted transaction
        </div>
    </div>
</div>

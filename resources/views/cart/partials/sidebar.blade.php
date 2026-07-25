<!-- Coupon Code Card -->
<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Have a coupon?</h3>
    <form action="#" method="POST" class="flex gap-2">
        @csrf
        <input type="text" name="coupon" placeholder="Coupon code" class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
        <button type="submit" class="px-4 py-2 bg-gray-900 border border-transparent rounded-md font-medium text-white hover:bg-gray-800 shadow-sm text-sm transition-colors">Apply</button>
    </form>
</div>

<!-- Order Summary Card -->
<div id="order-summary-card" class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h2 class="text-lg font-medium text-gray-900 mb-6">Order Summary</h2>
    <dl class="space-y-4 text-sm text-gray-600">
        <div class="flex justify-between">
            <dt>Subtotal</dt>
            <dd class="font-medium text-gray-900">${{ number_format($subtotal, 2) }}</dd>
        </div>
        <div class="flex justify-between">
            <dt>Shipping estimate</dt>
            <dd class="font-medium text-gray-900">Calculated at checkout</dd>
        </div>
        <div class="flex justify-between">
            <dt>Tax estimate</dt>
            <dd class="font-medium text-gray-900">Calculated at checkout</dd>
        </div>
        <div class="pt-4 flex items-center justify-between border-t border-gray-100">
            <dt class="text-base font-bold text-gray-900">Order Total</dt>
            <dd class="text-lg font-bold text-gray-900">${{ number_format($subtotal, 2) }}</dd>
        </div>
    </dl>
</div>

<!-- Payment Method Card -->
<div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">Proceed</h3>
    <a href="{{ route('checkout.index') }}" class="w-full flex justify-center items-center px-6 py-4 border border-transparent rounded-md shadow-sm text-base font-bold text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
        Check Out
    </a>
    <div class="mt-4 flex flex-col items-center gap-2">
        <div class="flex space-x-2 opacity-60">
            <!-- Minimalistic Payment Icons placeholders -->
            <svg class="h-6 w-auto" viewBox="0 0 38 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="38" height="24" rx="4" fill="#E5E7EB"/><path d="M19 12H11" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round"/></svg>
            <svg class="h-6 w-auto" viewBox="0 0 38 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="38" height="24" rx="4" fill="#E5E7EB"/><circle cx="15" cy="12" r="4" fill="#9CA3AF"/><circle cx="23" cy="12" r="4" fill="#6B7280" fill-opacity="0.8"/></svg>
            <svg class="h-6 w-auto" viewBox="0 0 38 24" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="38" height="24" rx="4" fill="#E5E7EB"/><path d="M12 10L19 14L26 10" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </div>
    </div>
</div>

<div class="bg-white p-12 rounded-xl shadow-sm text-center border border-gray-100">
    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-6">
        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
    </div>
    <h2 class="text-xl font-medium text-gray-900 mb-2">Your cart is empty</h2>
    <p class="text-gray-500 mb-8">Looks like you haven't added any products to your cart yet.</p>
    <a href="{{ route('product-catalog.index') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 shadow-sm transition-colors duration-200">
        Continue Shopping
    </a>
</div>

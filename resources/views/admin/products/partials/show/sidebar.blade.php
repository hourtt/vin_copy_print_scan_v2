<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
    {{-- Header / Quick Actions --}}
    <div class="p-5 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
        <h3 class="font-semibold text-gray-900">Summary</h3>
        <div class="flex gap-2">
            <a href="{{ route('admin.products.edit', $product) }}"
                class="p-1.5 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded transition-colors"
                title="Edit Product">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </a>
            @if (Route::has('products.show'))
                <a href="{{ route('products.show', $product->slug) }}" target="_blank"
                    class="p-1.5 text-gray-500 hover:text-green-600 hover:bg-green-50 rounded transition-colors"
                    title="View on Storefront">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>
                </a>
            @endif
        </div>
    </div>

    {{-- Details List --}}
    <div class="p-5 space-y-4">
        <div>
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Price</p>
            <p class="text-2xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</p>
        </div>

        <div class="pt-4 border-t border-gray-100">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Inventory Status</p>
            <div class="flex items-center gap-2">
                <div class="@class([
                    'w-2 h-2 rounded-full',
                    'bg-green-500' => $product->stock > 10,
                    'bg-amber-500' => $product->stock > 0 && $product->stock <= 10,
                    'bg-red-500' => $product->stock <= 0,
                ])"></div>
                <p class="text-sm font-medium text-gray-900">{{ $product->stock }} units available</p>
            </div>
        </div>

        <div class="pt-4 border-t border-gray-100">
            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Organization</p>
            <ul class="text-sm space-y-2">
                <li class="flex justify-between">
                    <span class="text-gray-500">Category</span>
                    <span class="font-medium text-gray-900">{{ $product->category?->name ?? 'None' }}</span>
                </li>
                <li class="flex justify-between">
                    <span class="text-gray-500">Brand</span>
                    <span class="font-medium text-gray-900">{{ $product->brand?->name ?? 'None' }}</span>
                </li>
                <li class="flex justify-between">
                    <span class="text-gray-500">Visibility</span>
                    <span class="font-medium {{ $product->is_featured ? 'text-indigo-600' : 'text-gray-900' }}">
                        {{ $product->is_featured ? 'Featured' : 'Standard' }}
                    </span>
                </li>
            </ul>
        </div>
    </div>
</div>

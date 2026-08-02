<x-admin-layout>
    <x-slot name="header">Products</x-slot>

    <div class="space-y-5">

        {{-- Header Row --}}
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500 mt-0.5">Manage your product catalogue</p>
            </div>
            <a href="{{ route('admin.products.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Add Product
            </a>
        </div>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div
                class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm">
                <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div
                class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg text-sm">
                <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- Filters --}}
        <form method="GET" action="{{ route('admin.products.index') }}"
            class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
            @include('admin.products.partials.index.filters')
        </form>

        {{-- Product Table --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
            @if ($products->isEmpty())
                <div class="flex flex-col items-center justify-center py-16 text-gray-400">
                    <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                    </svg>
                    <p class="text-sm font-medium">No products found</p>
                    <p class="text-xs mt-1">Try adjusting your filters or <a href="{{ route('admin.products.create') }}"
                            class="text-indigo-600 hover:underline">add a new product</a>.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                    Product</th>
                                <th
                                    class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                    Category</th>
                                <th
                                    class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                    Price</th>
                                <th
                                    class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                    Stock</th>
                                <th
                                    class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                    Featured</th>
                                <th
                                    class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                    Status</th>
                                <th
                                    class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wide">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($products as $product)
                                <tr
                                    class="hover:bg-gray-50 transition-colors {{ $product->trashed() ? 'opacity-50' : '' }}">
                                    {{-- Product Info --}}
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            @php $thumb = $product->images->firstWhere('is_primary', true) ?? $product->images->first(); @endphp
                                            @if ($thumb)
                                                <img src="{{ Storage::url($thumb->image_path) }}"
                                                    alt="{{ $product->name }}"
                                                    class="w-10 h-10 rounded-lg object-cover border border-gray-100 shrink-0"
                                                    loading="lazy">
                                            @else
                                                <div
                                                    class="w-10 h-10 rounded-lg bg-gray-100 border border-gray-200 flex items-center justify-center shrink-0">
                                                    <svg class="w-5 h-5 text-gray-300" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <rect x="3" y="3" width="18" height="18"
                                                            rx="2" />
                                                        <circle cx="8.5" cy="8.5" r="1.5" />
                                                        <polyline points="21 15 16 10 5 21" />
                                                    </svg>
                                                </div>
                                            @endif
                                            <div class="min-w-0">
                                                <a href="{{ route('admin.products.show', $product) }}"
                                                    class="text-gray-900 hover:text-indigo-600 transition-colors truncate block max-w-[200px]">
                                                    {{ $product->name }}
                                                </a>
                                                <span
                                                    class="text-xs text-gray-400">{{ $product->brand?->name ?? '—' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    {{-- Category --}}
                                    <td class="px-4 py-3">
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700">
                                            {{ $product->category?->name ?? 'Uncategorized' }}
                                        </span>
                                    </td>
                                    {{-- Price --}}
                                    <td class="px-4 py-3 text-right font-medium text-gray-900">
                                        ${{ number_format($product->price, 2) }}
                                    </td>
                                    {{-- Stock Badge --}}
                                    <td class="px-4 py-3 text-center">
                                        @if ($product->stock > 10)
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700">{{ $product->stock }}</span>
                                        @elseif ($product->stock > 0)
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700">{{ $product->stock }}
                                                low</span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700">Out</span>
                                        @endif
                                    </td>
                                    {{-- Featured Toggle --}}
                                    <td class="px-4 py-3 text-center">
                                        <div x-data="{ featured: {{ $product->is_featured ? 'true' : 'false' }}, loading: false }">
                                            <button
                                                @click="
                                                loading = true;
                                                fetch('{{ route('admin.products.toggle-featured', $product) }}', {
                                                    method: 'PATCH',
                                                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
                                                })
                                                .then(r => r.json())
                                                .then(d => { featured = d.is_featured; loading = false; });
                                            "
                                                :class="featured ? 'bg-indigo-600' : 'bg-gray-200'"
                                                :disabled="loading"
                                                class="relative inline-flex h-5 w-9 items-center rounded-full transition-colors focus:outline-none disabled:opacity-50 cursor-pointer">
                                                <span :class="featured ? 'translate-x-5' : 'translate-x-1'"
                                                    class="inline-block h-3 w-3 transform rounded-full bg-white transition-transform"></span>
                                            </button>
                                        </div>
                                    </td>
                                    {{-- Status --}}
                                    <td class="px-4 py-3 text-center">
                                        @if ($product->trashed())
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500">Archived</span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700">Active</span>
                                        @endif
                                    </td>
                                    {{-- Actions --}}
                                    <td class="px-4 py-3 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            @unless ($product->trashed())
                                                <a href="{{ route('admin.products.edit', $product) }}"
                                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                                                    Edit
                                                </a>
                                                <form method="POST"
                                                    action="{{ route('admin.products.destroy', $product) }}" x-data
                                                    @submit.prevent="if(confirm('Archive this product? It will be soft-deleted and hidden from the store.')) $el.submit()">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-600 bg-white border border-red-200 rounded-lg hover:bg-red-50 transition-colors">
                                                        Archive
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-xs text-gray-400 italic">Archived</span>
                                            @endunless
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if ($products->hasPages())
                    <div class="px-4 py-3 border-t border-gray-100">
                        {{ $products->links() }}
                    </div>
                @endif
        </div>

        {{-- Results count --}}
        <p class="text-xs text-gray-400 text-right">
            Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }} products
        </p>
        @endif

    </div>
</x-admin-layout>

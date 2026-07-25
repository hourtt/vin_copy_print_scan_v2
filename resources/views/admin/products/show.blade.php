<x-admin-layout>
    <x-slot name="header">Product Detail</x-slot>

    <div class="space-y-5">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.products.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Products</a>
            <span class="text-gray-300">/</span>
            <span class="text-sm text-gray-700 font-medium">{{ $product->name }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Gallery --}}
            <div class="lg:col-span-2 space-y-5">
                @if ($product->images->isNotEmpty())
                    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm"
                         x-data="{ active: '{{ Storage::url($product->images->firstWhere('is_primary', true)?->image_path ?? $product->images->first()->image_path) }}' }">
                        <img :src="active" class="w-full h-72 object-contain bg-gray-50 p-4" loading="lazy">
                @include('admin.products.partials.show.gallery')

                {{-- Description --}}
                <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                    <h3 class="text-sm font-semibold text-gray-700 mb-3">Description</h3>
                    <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-wrap">{{ $product->description ?? 'No description provided.' }}</p>
                </div>

                {{-- Specifications --}}
                @if ($product->specifications)
                    <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Specifications</h3>
                        <dl class="divide-y divide-gray-100">
                            @foreach ($product->specifications as $key => $val)
                                <div class="flex justify-between py-2 text-sm">
                                    <dt class="text-gray-500 font-medium">{{ $key }}</dt>
                                    <dd class="text-gray-900">{{ $val }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>
                @endif

                {{-- Order History Count --}}
                @include('admin.products.partials.show.sales-history')
            </div>

            {{-- Sidebar --}}
            <div class="space-y-5">

                            @endif
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Slug</span>
                            <span class="text-gray-700 font-mono text-xs">{{ $product->slug }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Created</span>
                            <span class="text-gray-700">{{ $product->created_at->format('d M Y') }}</span>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 pt-3">
                        <a href="{{ route('admin.products.edit', $product) }}"
                           class="block w-full text-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                            Edit Product
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-admin-layout>

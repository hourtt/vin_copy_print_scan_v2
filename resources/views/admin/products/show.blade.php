<x-admin-layout>
    <x-slot name="header">Product Detail</x-slot>

    <div class="space-y-5">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.products.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Products</a>
            <span class="text-gray-300">/</span>
            <span class="text-sm text-gray-700 font-medium">{{ $product->name }}</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-5">
                @include('admin.products.partials.show.gallery')
                @include('admin.products.partials.show.description')
                @include('admin.products.partials.show.specifications')
                @include('admin.products.partials.show.sales-history')
            </div>

            {{-- Sidebar --}}
            <div class="space-y-5">
                @include('admin.products.partials.show.sidebar')
            </div>
        </div>
    </div>
</x-admin-layout>

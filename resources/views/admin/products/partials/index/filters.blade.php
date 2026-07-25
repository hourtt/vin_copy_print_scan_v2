{{-- Filters & Search --}}
<div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
    <form action="{{ route('admin.products.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
        <div class="flex-1">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search products by name or sku..."
                       class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
        </div>

        <select name="category" class="w-full sm:w-48 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" @selected(request('category') == $cat->id)>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>

        <select name="status" class="w-full sm:w-40 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="">All Status</option>
            <option value="in_stock" @selected(request('status') === 'in_stock')>In Stock</option>
            <option value="low_stock" @selected(request('status') === 'low_stock')>Low Stock</option>
            <option value="out_of_stock" @selected(request('status') === 'out_of_stock')>Out of Stock</option>
        </select>

        <div class="flex gap-2">
            <button type="submit" class="px-4 py-2 bg-gray-900 text-white text-sm font-medium rounded-lg hover:bg-gray-800 transition-colors">
                Filter
            </button>
            @if(request()->anyFilled(['search', 'category', 'status']))
                <a href="{{ route('admin.products.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                    Clear
                </a>
            @endif
        </div>
    </form>
</div>

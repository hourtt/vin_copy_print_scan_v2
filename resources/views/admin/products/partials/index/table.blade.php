<div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
    @if ($products->isEmpty())
        @include('admin.products.partials.index.empty-state')
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 border-b border-gray-200 text-gray-500 font-medium">
                    <tr>
                        <th class="py-3 px-4">Product</th>
                        <th class="py-3 px-4">Category</th>
                        <th class="py-3 px-4">Price</th>
                        <th class="py-3 px-4">Stock</th>
                        <th class="py-3 px-4">Featured</th>
                        <th class="py-3 px-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($products as $product)
                        @include('admin.products.partials.index.table-row', ['product' => $product])
                    @endforeach
                </tbody>
            </table>
        </div>
        @if ($products->hasPages())
            <div class="p-4 border-t border-gray-200 bg-gray-50/50">
                {{ $products->links() }}
            </div>
        @endif
    @endif
</div>

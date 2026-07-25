<div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
    <h3 class="text-sm font-semibold text-gray-700 mb-3">Description</h3>
    <div class="prose prose-sm prose-indigo max-w-none text-gray-600">
        {{ $product->description ?: 'No description provided.' }}
    </div>
</div>

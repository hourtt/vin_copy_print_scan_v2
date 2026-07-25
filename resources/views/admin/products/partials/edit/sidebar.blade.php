<div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm space-y-4">
    <h3 class="text-sm font-semibold text-gray-700">Publish</h3>

    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-700">Featured Product</p>
            <p class="text-xs text-gray-400">Show on homepage</p>
        </div>
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="hidden" name="is_featured" value="0">
            <input type="checkbox" name="is_featured" value="1" class="sr-only peer" @checked(old('is_featured', $product->is_featured))>
            <div class="w-9 h-5 bg-gray-200 peer-checked:bg-indigo-600 rounded-full peer transition-colors after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-transform peer-checked:after:translate-x-4"></div>
        </label>
    </div>

    <div class="text-xs text-gray-400 space-y-1 border-t border-gray-100 pt-3">
        <p>Created: {{ $product->created_at->format('d M Y, H:i') }}</p>
        <p>Updated: {{ $product->updated_at->format('d M Y, H:i') }}</p>
    </div>

    <div class="flex gap-2">
        <button type="submit"
                class="flex-1 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
            Save Changes
        </button>
        <a href="{{ route('admin.products.index') }}"
           class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
            Cancel
        </a>
    </div>

    <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
          x-data @submit.prevent="if(confirm('Archive this product? It will be soft-deleted.')) $el.submit()">
        @csrf @method('DELETE')
        <button type="submit"
                class="w-full px-4 py-2 text-xs font-medium text-red-600 border border-red-200 rounded-lg hover:bg-red-50 transition-colors">
            Archive Product
        </button>
    </form>
</div>

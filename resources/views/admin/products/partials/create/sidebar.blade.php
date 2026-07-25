<div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm space-y-4">
    <h3 class="text-sm font-semibold text-gray-700">Publish</h3>

    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-gray-700">Featured Product</p>
            <p class="text-xs text-gray-400">Show on homepage</p>
        </div>
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="hidden" name="is_featured" value="0">
            <input type="checkbox" name="is_featured" value="1" class="sr-only peer" @checked(old('is_featured'))>
            <div class="w-9 h-5 bg-gray-200 peer-checked:bg-indigo-600 rounded-full peer transition-colors after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-transform peer-checked:after:translate-x-4"></div>
        </label>
    </div>

    <div class="flex gap-2 pt-2 border-t border-gray-100">
        <button type="submit"
                class="flex-1 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors">
            Create Product
        </button>
        <a href="{{ route('admin.products.index') }}"
           class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
            Cancel
        </a>
    </div>
</div>

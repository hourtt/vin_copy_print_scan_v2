<div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm space-y-4">
    <h3 class="text-sm font-semibold text-gray-700">Basic Information</h3>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Product Name <span class="text-red-500">*</span></label>
        <input type="text" name="name" value="{{ old('name') }}" required
               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('name') border-red-300 @enderror"
               placeholder="e.g. HP LaserJet Toner 85A">
        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Category <span class="text-red-500">*</span></label>
            <select name="category_id" required class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('category_id') border-red-300 @enderror">
                <option value="">Select category…</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>{{ $cat->name }}</option>
                @endforeach
            </select>
            @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
            <select name="brand_id" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">No Brand</option>
                @foreach ($brands as $brand)
                    <option value="{{ $brand->id }}" @selected(old('brand_id') == $brand->id)>{{ $brand->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
        <textarea name="description" rows="4"
                  class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 resize-none"
                  placeholder="Product description…">{{ old('description') }}</textarea>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Price ($) <span class="text-red-500">*</span></label>
            <input type="number" name="price" value="{{ old('price') }}" step="0.01" min="0" required
                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('price') border-red-300 @enderror"
                   placeholder="0.00">
            @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Stock Quantity <span class="text-red-500">*</span></label>
            <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0" required
                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('stock') border-red-300 @enderror">
            @error('stock') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">URL Slug</label>
        <input type="text" name="slug" value="{{ old('slug') }}"
               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-indigo-500"
               placeholder="auto-generated-if-empty">
        <p class="text-xs text-gray-400 mt-1">Leave empty to auto-generate from name.</p>
    </div>
</div>

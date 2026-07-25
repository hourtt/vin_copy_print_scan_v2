<tr class="hover:bg-gray-50/50 transition-colors">
    <td class="py-3 px-4">
        <div class="flex items-center gap-3">
            <div class="h-10 w-10 shrink-0 rounded-lg border border-gray-100 bg-gray-50 overflow-hidden flex items-center justify-center">
                @if($product->primaryImage())
                    <img src="{{ Storage::url($product->primaryImage()->image_path) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                @else
                    <svg class="h-5 w-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                @endif
            </div>
            <div>
                <a href="{{ route('admin.products.show', $product) }}" class="font-medium text-gray-900 hover:text-indigo-600 transition-colors">
                    {{ $product->name }}
                </a>
                <div class="text-xs text-gray-500 mt-0.5">
                    ID: {{ $product->id }} &bull; Slug: {{ $product->slug }}
                </div>
            </div>
        </div>
    </td>
    <td class="py-3 px-4 text-gray-600">
        {{ $product->category->name ?? '—' }}
        @if($product->brand)
            <div class="text-xs text-gray-400">{{ $product->brand->name }}</div>
        @endif
    </td>
    <td class="py-3 px-4 font-medium text-gray-900">
        ${{ number_format($product->price, 2) }}
    </td>
    <td class="py-3 px-4">
        <div class="flex flex-col items-start gap-1">
            <span class="@class([
                'inline-flex items-center px-2 py-1 rounded text-xs font-medium',
                'bg-green-50 text-green-700' => $product->stock > 10,
                'bg-amber-50 text-amber-700' => $product->stock > 0 && $product->stock <= 10,
                'bg-red-50 text-red-700' => $product->stock <= 0,
            ])">
                {{ $product->stock }} in stock
            </span>
            @if($product->stock <= 10 && $product->stock > 0)
                <span class="text-[10px] text-amber-600 font-medium">Low Stock</span>
            @endif
        </div>
    </td>
    <td class="py-3 px-4">
        <label class="relative inline-flex items-center cursor-pointer" title="Toggle Featured">
            <input type="checkbox" class="sr-only peer" @checked($product->is_featured)
                   @change="toggleFeatured({{ $product->id }}, '{{ csrf_token() }}')">
            <div class="w-9 h-5 bg-gray-200 peer-checked:bg-indigo-600 rounded-full peer transition-colors after:content-[''] after:absolute after:top-0.5 after:left-0.5 after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-transform peer-checked:after:translate-x-4"></div>
        </label>
    </td>
    <td class="py-3 px-4">
        <div class="flex items-center justify-end gap-2">
            <a href="{{ route('admin.products.show', $product) }}" class="p-1.5 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded transition-colors" title="View">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </a>
            <a href="{{ route('admin.products.edit', $product) }}" class="p-1.5 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded transition-colors" title="Edit">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            </a>
            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline"
                  x-data @submit.prevent="if(confirm('Archive this product?')) $el.submit()">
                @csrf @method('DELETE')
                <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded transition-colors" title="Archive">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </form>
        </div>
    </td>
</tr>

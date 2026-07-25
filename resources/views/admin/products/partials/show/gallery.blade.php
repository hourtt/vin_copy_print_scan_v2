<div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm mb-6">
    <h3 class="text-sm font-semibold text-gray-700 mb-4">Product Gallery</h3>
    @if ($product->images->isEmpty())
        <div class="text-center py-8 text-gray-400 bg-gray-50 rounded-lg border border-gray-100">
            <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <p class="text-sm">No images uploaded</p>
        </div>
    @else
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @foreach ($product->images->sortBy('sort_order') as $image)
                <div class="relative group aspect-square rounded-lg border {{ $image->is_primary ? 'border-indigo-400 ring-2 ring-indigo-100' : 'border-gray-200' }} overflow-hidden bg-gray-50">
                    <img src="{{ Storage::url($image->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @if ($image->is_primary)
                        <span class="absolute top-2 left-2 bg-indigo-600 text-white text-[10px] uppercase tracking-wider px-2 py-0.5 rounded shadow-sm font-bold">Primary</span>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</div>

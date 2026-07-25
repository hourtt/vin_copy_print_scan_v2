@if ($product->images->isNotEmpty())
    <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm space-y-3">
        <h3 class="text-sm font-semibold text-gray-700">Current Gallery</h3>
        <p class="text-xs text-gray-400">Click "Set as Thumbnail" to make any image the featured one. Delete removes it permanently.</p>

        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            @foreach ($product->images->sortBy('sort_order') as $image)
                <div class="relative group">
                    <img src="{{ Storage::url($image->image_path) }}" alt="Product image"
                         class="w-full h-24 object-cover rounded-lg border {{ $image->is_primary ? 'border-indigo-400 ring-2 ring-indigo-300' : 'border-gray-100' }}" loading="lazy">

                    @if ($image->is_primary)
                        <span class="absolute top-1 left-1 bg-indigo-600 text-white text-xs px-1.5 py-0.5 rounded font-medium">Thumbnail</span>
                    @endif

                    <div class="absolute inset-x-0 bottom-0 opacity-0 group-hover:opacity-100 transition-opacity flex gap-1 p-1">
                        @unless ($image->is_primary)
                            <button type="button"
                                    @click="setPrimary({{ $product->id }}, {{ $image->id }}, '{{ csrf_token() }}')"
                                    class="flex-1 text-xs bg-indigo-600 text-white rounded py-1 font-medium hover:bg-indigo-700 transition-colors">
                                Set Thumb
                            </button>
                        @endunless
                        <button type="button"
                                @click="deleteImage({{ $product->id }}, {{ $image->id }}, '{{ csrf_token() }}')"
                                class="px-2 text-xs bg-red-500 text-white rounded py-1 hover:bg-red-600 transition-colors">
                            ✕
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

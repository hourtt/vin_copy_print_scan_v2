<div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm space-y-3">
    <h3 class="text-sm font-semibold text-gray-700">Product Images</h3>
    <p class="text-xs text-gray-400">The first image uploaded will automatically be used as the thumbnail. Up to 5MB per image.</p>

    <label class="flex flex-col items-center justify-center border-2 border-dashed border-gray-200 rounded-xl p-8 cursor-pointer hover:border-indigo-400 hover:bg-indigo-50/40 transition-colors">
        <svg class="w-8 h-8 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        <p class="text-sm font-medium text-gray-500">Click to upload images</p>
        <p class="text-xs text-gray-400 mt-1">PNG, JPG, WEBP up to 5MB each</p>
        <input type="file" name="images[]" multiple accept="image/*" class="hidden"
               @change="handleImages($event.target.files)">
    </label>

    {{-- Previews --}}
    <div x-show="previewImages.length > 0" class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-3">
        <template x-for="(img, i) in previewImages" :key="i">
            <div class="relative group">
                <img :src="img.url" :alt="img.name" class="w-full h-24 object-cover rounded-lg border border-gray-100" loading="lazy">
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 rounded-lg transition-colors"></div>
                <span x-show="i === 0" class="absolute top-1 left-1 bg-indigo-600 text-white text-xs px-1.5 py-0.5 rounded font-medium">Thumbnail</span>
                <button type="button" @click="previewImages.splice(i, 1)"
                        class="absolute top-1 right-1 bg-white/90 text-red-500 rounded-full p-0.5 opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-50">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </template>
    </div>
</div>

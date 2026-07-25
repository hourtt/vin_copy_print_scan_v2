<div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm space-y-3">
    <h3 class="text-sm font-semibold text-gray-700">Add More Images</h3>

    <label class="flex flex-col items-center justify-center border-2 border-dashed border-gray-200 rounded-xl p-6 cursor-pointer hover:border-indigo-400 hover:bg-indigo-50/40 transition-colors">
        <svg class="w-7 h-7 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        <p class="text-sm text-gray-500">Click to upload additional images</p>
        <input type="file" name="images[]" multiple accept="image/*" class="hidden"
               @change="handleNewImages($event.target.files)">
    </label>

    <div x-show="newPreviews.length > 0" class="grid grid-cols-2 sm:grid-cols-4 gap-3">
        <template x-for="(img, i) in newPreviews" :key="i">
            <div class="relative group">
                <img :src="img.url" class="w-full h-24 object-cover rounded-lg border border-gray-100" loading="lazy">
                <button type="button" @click="newPreviews.splice(i, 1)"
                        class="absolute top-1 right-1 bg-white/90 text-red-500 rounded-full p-0.5 opacity-0 group-hover:opacity-100 transition-opacity">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </template>
    </div>
</div>

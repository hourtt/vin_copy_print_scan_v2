<div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm space-y-3">
    <div class="flex items-center justify-between">
        <h3 class="text-sm font-semibold text-gray-700">Specifications</h3>
        <button type="button" @click="addSpec()"
                class="inline-flex items-center gap-1 text-xs font-medium text-indigo-600 hover:text-indigo-800">
            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            Add Row
        </button>
    </div>
    <div class="space-y-2">
        <template x-for="(spec, i) in specs" :key="i">
            <div class="flex gap-2 items-center">
                <input type="text" :name="`specifications[${i}][key]`" x-model="spec.key" placeholder="Key"
                       class="flex-1 border border-gray-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <input type="text" :name="`specifications[${i}][value]`" x-model="spec.value" placeholder="Value"
                       class="flex-1 border border-gray-200 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <button type="button" @click="removeSpec(i)" class="text-gray-300 hover:text-red-500 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </template>
        <template x-if="specs.length === 0">
            <p class="text-xs text-gray-400 py-2">No specifications. Click "Add Row" to begin.</p>
        </template>
    </div>
</div>

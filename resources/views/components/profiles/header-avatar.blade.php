<div class="flex flex-col sm:flex-row sm:items-center gap-6 mb-10">
    <div
        class="w-20 h-20 md:w-24 md:h-24 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 flex-shrink-0">
        <span class="text-3xl font-bold uppercase">
            {{ substr(Auth::user()->first_name, 0, 1) }}
        </span>
    </div>

    <div class="flex flex-col gap-2">
        <h2 class="text-2xl font-bold text-gray-900">{{ Auth::user()->first_name }}
            {{ Auth::user()->last_name }}
        </h2>
        <div class="flex flex-wrap gap-3 mt-1">
            <button type="button"
                class="px-3 py-1.5 text-sm font-medium border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">Upload
                new</button>
            <button type="button"
                class="px-3 py-1.5 text-sm font-medium border border-gray-300 rounded-md bg-white transition-colors text-red-600 hover:bg-red-50 hover:border-red-300 hover:text-red-700">Delete</button>
        </div>
    </div>
</div>

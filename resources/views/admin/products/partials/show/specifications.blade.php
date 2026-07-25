<div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
    <h3 class="text-sm font-semibold text-gray-700 mb-3">Specifications</h3>
    @empty($product->specifications)
        <p class="text-sm text-gray-500">No specifications defined.</p>
    @else
        <dl class="divide-y divide-gray-100 border border-gray-100 rounded-lg">
            @foreach ($product->specifications as $spec)
                <div class="px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 hover:bg-gray-50 transition-colors">
                    <dt class="text-sm font-medium text-gray-900">{{ $spec['key'] }}</dt>
                    <dd class="mt-1 text-sm text-gray-600 sm:mt-0 sm:col-span-2">{{ $spec['value'] }}</dd>
                </div>
            @endforeach
        </dl>
    @endempty
</div>

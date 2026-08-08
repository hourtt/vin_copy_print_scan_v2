@props(['item'])

<div class="flex items-center gap-4">
    <div class="relative flex-shrink-0">
        <div class="w-16 h-16 bg-zinc-100 rounded-lg overflow-hidden flex items-center justify-center">
            @if ($item->product->image)
                <img src="{{ asset('storage/' . $item->product?->image) }}"
                    alt="{{ $item->product?->name }}"
                    class="object-contain w-full h-full" loading="lazy">
            @else
                <span class="text-zinc-400">No Img</span>
            @endif
        </div>
        <div class="absolute -top-2 -left-2 bg-zinc-500 text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full">
            {{ $item->quantity }}
        </div>
    </div>
    <div class="flex-grow min-w-0">
        <h4 class="font-medium text-sm text-[#27272a] truncate">
            {{ $item->product?->name }}</h4>
        <p class="text-xs text-[#71717a]">{{ $item->product?->category?->name ?? 'Product' }}</p>
    </div>
    <div class="font-bold text-sm text-[#27272a]">
        ${{ number_format(($item->product?->price ?? 0) * $item->quantity, 2) }}
    </div>
</div>

@props(['items', 'showBack' => true])

@php
    $lastItem = end($items);
    $isTerminal = in_array($lastItem['label'] ?? '', ['Checkout', 'Shopping Cart', 'Product Catalog', 'Product Catalogs']);
@endphp

<nav class="flex flex-wrap items-center text-sm font-['Kantumruy Pro',sans-serif] py-2 mb-6 gap-y-2">
    {{-- @if ($showBack)
        <a href="{{ route('breadcrumb.back', ['from' => $isTerminal ? 'terminal' : 'category']) }}"
           class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-600 hover:text-gray-900 mr-3 transition-colors shrink-0"
           title="Go Back">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
    @endif --}}

    @foreach ($items as $item)
        <div class="flex items-center">
            @if ($loop->last || empty($item['url']))
                <span class="font-bold text-[var(--dark-ink)] truncate max-w-[200px] sm:max-w-none">
                    {{ $item['label'] }}
                </span>
            @else
                <a href="{{ $item['url'] }}" class="text-gray-500 hover:text-[var(--brand)] transition-colors truncate max-w-[150px] sm:max-w-none">
                    {{ $item['label'] }}
                </a>
            @endif

            @if (!$loop->last)
                <svg class="w-3 h-3 text-gray-300 mx-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            @endif
        </div>
    @endforeach
</nav>

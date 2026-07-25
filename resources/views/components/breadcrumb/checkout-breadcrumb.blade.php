@props(['current'])

@php
    $steps = [
        'cart' => 'Cart',
        'shipping' => 'Shipping',
        'payment' => 'Payment'
    ];
    
    $currentKeyIndex = array_search($current, array_keys($steps));
@endphp

<nav class="flex items-center text-sm font-['Kantumruy_Pro',sans-serif] py-2 mb-6">
    @foreach ($steps as $key => $label)
        @php
            $loopIndex = $loop->index;
            $isActive = $key === $current;
            $isCompleted = $loopIndex < $currentKeyIndex;
        @endphp

        <div class="flex items-center">
            @if ($isCompleted)
                <a href="{{ $key === 'cart' ? route('cart.index') : ($key === 'shipping' ? route('checkout.index') : '#') }}" class="text-gray-500 hover:text-[var(--brand)] transition-colors">
                    {{ $label }}
                </a>
            @elseif ($isActive)
                <span class="font-bold text-[var(--dark-ink)]">{{ $label }}</span>
            @else
                <span class="text-gray-400">{{ $label }}</span>
            @endif

            @if (!$loop->last)
                <svg class="w-3 h-3 text-gray-300 mx-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            @endif
        </div>
    @endforeach
</nav>

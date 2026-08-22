<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 py-10">
        <div class="mb-8">
            <h1 class="font-serif text-2xl font-semibold text-[#0D0D0B]">My Inquiries</h1>
            <p class="mt-1 text-sm text-[#6B6B6B]">A record of all products you have inquired about.</p>
        </div>

        @if($inquiries->isEmpty())
            <div class="bg-white rounded-2xl border border-[#E5E5E2] p-12 text-center">
                <div class="w-14 h-14 rounded-2xl bg-[#1D9E75]/10 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-[#1D9E75]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                </div>
                <p class="text-[#6B6B6B] font-medium">No inquiries yet.</p>
                <p class="text-sm text-[#9A9A96] mt-1">Browse our products and tap the Inquire button to get started.</p>
                <a href="{{ route('dashboard') }}"
                   class="inline-flex items-center gap-2 mt-6 px-5 py-2.5 rounded-xl text-sm font-semibold text-white bg-[#1D9E75] hover:brightness-95 transition-all">
                    Browse Products
                </a>
            </div>
        @else
            <div class="bg-white rounded-2xl border border-[#E5E5E2] overflow-hidden shadow-sm">
                <table class="w-full text-sm">
                    <thead class="bg-[#fafaf9] border-b border-[#E5E5E2]">
                        <tr>
                            <th class="px-5 py-3.5 text-left text-xs font-semibold text-[#6B6B6B] uppercase tracking-wide">Product</th>
                            <th class="px-5 py-3.5 text-left text-xs font-semibold text-[#6B6B6B] uppercase tracking-wide">Price</th>
                            <th class="px-5 py-3.5 text-left text-xs font-semibold text-[#6B6B6B] uppercase tracking-wide">Language</th>
                            <th class="px-5 py-3.5 text-left text-xs font-semibold text-[#6B6B6B] uppercase tracking-wide">Date</th>
                            <th class="px-5 py-3.5 text-left text-xs font-semibold text-[#6B6B6B] uppercase tracking-wide">Product</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#F0F0EE]">
                        @foreach($inquiries as $inquiry)
                            <tr class="hover:bg-[#fafaf9] transition-colors">
                                <td class="px-5 py-4">
                                    <span class="font-medium text-[#27272a] line-clamp-1">{{ $inquiry->product_name_snapshot }}</span>
                                </td>
                                <td class="px-5 py-4 text-[#27272a]">
                                    ${{ number_format($inquiry->product_price_snapshot, 2) }}
                                </td>
                                <td class="px-5 py-4">
                                    @php
                                        $langLabel = match($inquiry->language) {
                                            'km' => '🇰🇭 Khmer',
                                            'zh' => '🇨🇳 Chinese',
                                            default => '🇺🇸 English',
                                        };
                                    @endphp
                                    <span class="text-xs text-[#6B6B6B]">{{ $langLabel }}</span>
                                </td>
                                <td class="px-5 py-4 text-[#9A9A96] text-xs whitespace-nowrap">
                                    {{ $inquiry->created_at->diffForHumans() }}
                                </td>
                                <td class="px-5 py-4">
                                    @if($inquiry->product)
                                        <a href="{{ route('products.' . Str::plural(strtolower($inquiry->product->category->name ?? 'printers')) . '.index') }}"
                                           class="text-xs font-medium text-[#1D9E75] hover:underline">
                                            View →
                                        </a>
                                    @else
                                        <span class="text-xs text-[#9A9A96]">Product removed</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if($inquiries->hasPages())
                    <div class="px-5 py-4 border-t border-[#E5E5E2]">
                        {{ $inquiries->links() }}
                    </div>
                @endif
            </div>
        @endif
    </div>
</x-app-layout>

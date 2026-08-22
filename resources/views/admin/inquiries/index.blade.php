<x-admin-layout>
    <x-slot name="header">Inquiry Log</x-slot>

    <div class="space-y-6">

        {{-- ── Filter Card ─────────────────────────────────────────────────── --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5"
             x-data="{
                 dateFrom: '{{ $date_from ?? '' }}',
                 dateTo:   '{{ $date_to ?? '' }}',
                 search:   '{{ $search ?? '' }}'
             }">
            <h2 class="text-sm font-semibold text-gray-700 mb-4">Filter Inquiries</h2>
            <form method="GET" action="{{ route('admin.inquiries.index') }}" id="filter-form">
                <div class="flex flex-wrap gap-4 items-end">
                    {{-- Date From --}}
                    <div class="flex flex-col gap-1 min-w-[160px]">
                        <label for="date_from" class="text-xs font-medium text-gray-500">From</label>
                        <input type="date" id="date_from" name="date_from"
                               x-model="dateFrom"
                               @change="$el.form.submit()"
                               class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    {{-- Date To --}}
                    <div class="flex flex-col gap-1 min-w-[160px]">
                        <label for="date_to" class="text-xs font-medium text-gray-500">To</label>
                        <input type="date" id="date_to" name="date_to"
                               x-model="dateTo"
                               @change="$el.form.submit()"
                               class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    {{-- Search --}}
                    <div class="flex flex-col gap-1 flex-1 min-w-[220px]">
                        <label for="search" class="text-xs font-medium text-gray-500">Search customer or product</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                                </svg>
                            </span>
                            <input type="text" id="search" name="search"
                                   x-model="search"
                                   placeholder="Name, email, or product…"
                                   class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex gap-2 pb-[1px]">
                        <button type="submit"
                                class="px-4 py-2 rounded-lg text-sm font-medium bg-indigo-600 text-white hover:bg-indigo-700 transition-colors">
                            Apply
                        </button>
                        <a href="{{ route('admin.inquiries.index') }}"
                           class="px-4 py-2 rounded-lg text-sm font-medium border border-gray-200 text-gray-600 hover:bg-gray-50 transition-colors">
                            Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- ── Export + Count Row ───────────────────────────────────────────── --}}
        <div class="flex items-center justify-between">
            <p class="text-sm text-gray-500">
                {{ $inquiries->total() }} {{ Str::plural('inquiry', $inquiries->total()) }}
                @if($date_from || $date_to)
                    <span class="text-gray-400">·</span>
                    <span class="text-gray-400 text-xs">
                        {{ $date_from ? 'from '.$date_from : '' }}
                        {{ $date_to ? ' to '.$date_to : '' }}
                    </span>
                @endif
            </p>

            <a href="{{ route('admin.inquiries.export', array_filter(['date_from' => $date_from, 'date_to' => $date_to, 'search' => $search])) }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium border border-gray-200 text-gray-700 hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                </svg>
                Export PDF
            </a>
        </div>

        {{-- ── Table ───────────────────────────────────────────────────────── --}}
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Customer</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Product</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Price</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Phone</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Lang</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($inquiries as $inquiry)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900">{{ $inquiry->user_name_snapshot }}</div>
                                    <div class="text-xs text-gray-500">{{ $inquiry->user_email_snapshot }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900 line-clamp-1 max-w-[200px]">{{ $inquiry->product_name_snapshot }}</div>
                                </td>
                                <td class="px-4 py-3 text-gray-700">
                                    ${{ number_format($inquiry->product_price_snapshot, 2) }}
                                </td>
                                <td class="px-4 py-3 text-gray-700">
                                    {{ $inquiry->user_phone_snapshot ?? '—' }}
                                </td>
                                <td class="px-4 py-3">
                                    @php
                                        $langLabel = match($inquiry->language) {
                                            'km' => '🇰🇭 KM',
                                            'zh' => '🇨🇳 ZH',
                                            default => '🇺🇸 EN',
                                        };
                                    @endphp
                                    <span class="text-xs text-gray-500">{{ $langLabel }}</span>
                                </td>
                                <td class="px-4 py-3 text-gray-500 whitespace-nowrap text-xs">
                                    {{ $inquiry->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="px-4 py-3">
                                    @if ($inquiry->user_phone_snapshot)
                                        <a href="https://t.me/{{ ltrim($inquiry->user_phone_snapshot, '+') }}"
                                           target="_blank" rel="noopener noreferrer"
                                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium bg-[#1D9E75]/10 text-[#1D9E75] hover:bg-[#1D9E75]/20 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                                            </svg>
                                            Reply
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400">No phone</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-16 text-center text-gray-400 text-sm">
                                    No inquiries found for the selected filters.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if ($inquiries->hasPages())
                <div class="px-4 py-3 border-t border-gray-200">
                    {{ $inquiries->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>

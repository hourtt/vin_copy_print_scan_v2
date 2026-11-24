<div class="space-y-6 text-sm text-slate-700 dark:text-slate-200">
    {{-- Header Banner --}}
    <div class="flex flex-wrap items-center justify-between gap-4 p-4 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700/60">
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-amber-100 text-amber-800 dark:bg-amber-900/50 dark:text-amber-300">
                #INQ-{{ str_pad($record->id, 5, '0', STR_PAD_LEFT) }}
            </span>
            <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Submitted: <strong class="text-slate-700 dark:text-slate-200">{{ $record->created_at ? $record->created_at->timezone('Asia/Phnom_Penh')->format('M d, Y • h:i A') : '—' }}</strong></span>
                @if($record->created_at)
                    <span class="text-slate-400">({{ $record->created_at->diffForHumans() }})</span>
                @endif
            </div>
        </div>

        <div class="flex items-center gap-2">
            <span class="text-xs text-slate-500 dark:text-slate-400">Language:</span>
            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium uppercase bg-slate-200 dark:bg-slate-700 text-slate-800 dark:text-slate-200">
                {{ $record->language ?? 'en' }}
            </span>
        </div>
    </div>

    {{-- Main Grid: Product & Customer --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        {{-- Product Details Card --}}
        <div class="p-5 rounded-xl border border-slate-200 dark:border-slate-700/60 bg-white dark:bg-slate-800 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700/60 pb-3">
                <h3 class="font-semibold text-slate-900 dark:text-white flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    Inquired Product
                </h3>
                @if($record->product)
                    <a href="{{ route('products.show', $record->product->slug) }}"
                       target="_blank"
                       class="text-xs text-amber-600 dark:text-amber-400 hover:underline inline-flex items-center gap-1 font-medium">
                        View in Store
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                @endif
            </div>

            <div class="flex items-start gap-4">
                {{-- Product Image Thumbnail --}}
                <div class="w-20 h-20 shrink-0 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900/50 flex items-center justify-center overflow-hidden p-1.5">
                    @if($record->product && $record->product->image)
                        <img src="{{ asset('storage/' . $record->product->image) }}"
                             alt="{{ $record->product_name_snapshot }}"
                             class="w-full h-full object-contain mix-blend-multiply dark:mix-blend-normal">
                    @else
                        <svg class="w-8 h-8 text-slate-300 dark:text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    @endif
                </div>

                {{-- Product Summary --}}
                <div class="space-y-1.5 min-w-0 flex-1">
                    <h4 class="font-medium text-slate-900 dark:text-white leading-snug line-clamp-2">
                        {{ $record->product_name_snapshot }}
                    </h4>

                    <div class="flex flex-wrap items-center gap-2 pt-0.5">
                        <span class="text-base font-bold text-amber-600 dark:text-amber-400">
                            ${{ number_format((float) $record->product_price_snapshot, 2) }}
                        </span>

                        @if($record->product && $record->product->category)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300">
                                {{ $record->product->category->name }}
                            </span>
                        @endif

                        @if($record->product && $record->product->brand)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-blue-50 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300">
                                {{ $record->product->brand->name }}
                            </span>
                        @endif
                    </div>

                    @if($record->product)
                        <div class="text-xs text-slate-500 dark:text-slate-400 pt-1">
                            Current Stock:
                            <span class="{{ $record->product->stock > 0 ? 'text-emerald-600 dark:text-emerald-400 font-medium' : 'text-rose-600 dark:text-rose-400 font-medium' }}">
                                {{ $record->product->stock > 0 ? $record->product->stock . ' units available' : 'Out of Stock' }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Customer Information Card --}}
        <div class="p-5 rounded-xl border border-slate-200 dark:border-slate-700/60 bg-white dark:bg-slate-800 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700/60 pb-3">
                <h3 class="font-semibold text-slate-900 dark:text-white flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Customer Profile
                </h3>

                @if($record->user)
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium {{ $record->user->is_banned ? 'bg-rose-100 text-rose-800 dark:bg-rose-900/40 dark:text-rose-300' : 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300' }}">
                        {{ $record->user->is_banned ? 'Banned' : 'Active Account' }}
                    </span>
                @else
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-300">
                        Guest Snapshot
                    </span>
                @endif
            </div>

            <div class="space-y-3">
                <div class="flex items-center justify-between py-1 border-b border-slate-50 dark:border-slate-700/30">
                    <span class="text-xs text-slate-500 dark:text-slate-400">Full Name</span>
                    <span class="font-medium text-slate-900 dark:text-white">
                        {{ $record->user_name_snapshot ?: ($record->user ? trim("{$record->user->first_name} {$record->user->last_name}") : '—') }}
                    </span>
                </div>

                <div class="flex items-center justify-between py-1 border-b border-slate-50 dark:border-slate-700/30">
                    <span class="text-xs text-slate-500 dark:text-slate-400">Email Address</span>
                    <a href="mailto:{{ $record->user_email_snapshot ?: $record->user?->email }}"
                       class="text-amber-600 dark:text-amber-400 hover:underline font-medium inline-flex items-center gap-1">
                        {{ $record->user_email_snapshot ?: ($record->user?->email ?? '—') }}
                    </a>
                </div>

                <div class="flex items-center justify-between py-1">
                    <span class="text-xs text-slate-500 dark:text-slate-400">Phone Number</span>
                    @if($record->user_phone_snapshot || $record->user?->phone_number)
                        <a href="tel:{{ $record->user_phone_snapshot ?: $record->user?->phone_number }}"
                           class="text-amber-600 dark:text-amber-400 hover:underline font-medium inline-flex items-center gap-1">
                            {{ $record->user_phone_snapshot ?: $record->user?->phone_number }}
                        </a>
                    @else
                        <span class="text-slate-400 italic">Not provided</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Inquiry Message Card --}}
    <div class="p-5 rounded-xl border border-slate-200 dark:border-slate-700/60 bg-white dark:bg-slate-800 shadow-sm space-y-3">
        <h3 class="font-semibold text-slate-900 dark:text-white flex items-center gap-2 border-b border-slate-100 dark:border-slate-700/60 pb-3">
            <svg class="w-4 h-4 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
            </svg>
            Customer Message / Questions
        </h3>

        @if(!empty($record->message))
            <div class="p-4 rounded-lg bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700 text-slate-800 dark:text-slate-200 leading-relaxed font-sans whitespace-pre-line">
                {{ $record->message }}
            </div>
        @else
            <div class="p-4 rounded-lg bg-slate-50 dark:bg-slate-900/40 text-slate-400 italic text-center">
                The customer did not provide additional notes. Inquiry was initiated directly for product consultation.
            </div>
        @endif
    </div>

    {{-- Contact Customer Actions --}}
    <div class="flex flex-wrap items-center justify-end gap-3 pt-2">
        @if($record->user_phone_snapshot || $record->user?->phone_number)
            <a href="tel:{{ $record->user_phone_snapshot ?: $record->user?->phone_number }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-xs font-semibold bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-800 dark:text-slate-200 transition-colors">
                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                Call Customer
            </a>
        @endif

        @if($record->user_email_snapshot || $record->user?->email)
            <a href="mailto:{{ $record->user_email_snapshot ?: $record->user?->email }}?subject=Regarding your inquiry for {{ rawurlencode($record->product_name_snapshot) }}"
               class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-xs font-semibold bg-amber-500 hover:bg-amber-600 text-white shadow-sm transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Email Customer
            </a>
        @endif
    </div>
</div>
{{--
    <x-inquire-button :product="$product" :isAvailable="$stock > 0" />

    Props:
        $product     — App\Models\Product
        $isAvailable — bool
--}}
@props(['product', 'isAvailable' => true])

@guest
    {{-- Guest: redirect to login --}}
    <a href="{{ route('login') }}"
       class="inline-flex items-center justify-center min-h-[36px] px-4 py-2 border border-[#e4e4e7] bg-white text-[#27272a] text-xs sm:text-sm font-semibold rounded-lg hover:border-[#1D9E75] hover:text-[#1D9E75] transition-all duration-200">
        Sign in to Inquire
    </a>
@else
    <div
        x-data="{
            step: 'idle',     {{-- idle | lang-pick | loading | done --}}
            pendingLang: null,

            open() {
                @if(!auth()->user()->phone_number)
                    {{-- No phone → trigger global phone-prompt modal --}}
                    $dispatch('phone-prompt', { productId: {{ $product->id }} });
                @else
                    this.step = 'lang-pick';
                @endif
            },

            async choose(lang) {
                this.pendingLang = lang;
                this.step = 'loading';
                try {
                    const res = await fetch('{{ route('inquire.store', $product) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ language: lang }),
                    });
                    const data = await res.json();
                    if (data.needs_phone) {
                        this.step = 'idle';
                        $dispatch('phone-prompt', { productId: {{ $product->id }} });
                        return;
                    }
                    window.open(data.telegram_url, '_blank', 'noopener,noreferrer');
                    this.step = 'done';
                    setTimeout(() => this.step = 'idle', 3000);
                } catch(e) {
                    console.error(e);
                    this.step = 'idle';
                }
            }
        }"
        class="relative"
        @keydown.escape.window="step === 'lang-pick' && (step = 'idle')"
        @phone-saved.window="if ($event.detail.productId === {{ $product->id }}) { step = 'lang-pick'; }"
    >
        {{-- ── Main Inquire Button ──────────────────────────────────────────── --}}
        <button
            @click="open()"
            :disabled="step === 'loading' || !{{ $isAvailable ? 'true' : 'false' }}"
            class="inline-flex items-center justify-center gap-1.5 min-h-[36px] px-4 py-2 rounded-lg text-xs sm:text-sm font-semibold transition-all duration-200
                   {{ $isAvailable
                       ? 'bg-[#1D9E75] text-white hover:brightness-95 active:scale-95'
                       : 'bg-gray-100 text-gray-400 cursor-not-allowed' }}"
            :class="{
                'opacity-60 cursor-wait': step === 'loading',
                'bg-green-600': step === 'done',
            }"
        >
            {{-- Idle / Lang-pick: chat icon --}}
            <svg x-show="step !== 'loading' && step !== 'done'" class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01"/>
            </svg>
            {{-- Loading: spinner --}}
            <svg x-show="step === 'loading'" x-cloak class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
            </svg>
            {{-- Done: checkmark --}}
            <svg x-show="step === 'done'" x-cloak class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>

            <span x-text="step === 'done' ? 'Sent!' : 'Inquire'"></span>
        </button>

        {{-- ── Language Picker Dropdown ─────────────────────────────────────── --}}
        <div
            x-show="step === 'lang-pick'"
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 scale-95 translate-y-1"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-1"
            x-cloak
            @click.outside="step = 'idle'"
            class="absolute z-50 bottom-full mb-2 right-0 w-64 bg-white rounded-2xl border border-[#1D9E75]/30 shadow-[0_8px_32px_rgba(29,158,117,0.15)] overflow-hidden"
        >
            <div class="px-4 pt-3.5 pb-2">
                <p class="text-[11px] font-semibold text-[#6B6B6B] uppercase tracking-wide">Inquire in</p>
            </div>
            <div class="flex flex-col gap-0.5 px-2 pb-3">
                {{-- English --}}
                <button @click="choose('en')"
                        class="flex items-center gap-3 w-full px-3 py-2.5 rounded-xl text-sm font-medium text-[#27272a] hover:bg-[#1D9E75]/8 hover:text-[#1D9E75] transition-colors text-left">
                    <span class="text-lg leading-none">🇺🇸</span>
                    <span>English</span>
                </button>
                {{-- Khmer --}}
                <button @click="choose('km')"
                        class="flex items-center gap-3 w-full px-3 py-2.5 rounded-xl text-sm font-medium text-[#27272a] hover:bg-[#1D9E75]/8 hover:text-[#1D9E75] transition-colors text-left">
                    <span class="text-lg leading-none">🇰🇭</span>
                    <span class="font-['Kantumruy_Pro',sans-serif]">ភាសាខ្មែរ</span>
                </button>
                {{-- Chinese --}}
                <button @click="choose('zh')"
                        class="flex items-center gap-3 w-full px-3 py-2.5 rounded-xl text-sm font-medium text-[#27272a] hover:bg-[#1D9E75]/8 hover:text-[#1D9E75] transition-colors text-left">
                    <span class="text-lg leading-none">🇨🇳</span>
                    <span>中文</span>
                </button>
            </div>
        </div>
    </div>
@endguest

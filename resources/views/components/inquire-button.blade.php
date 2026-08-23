@props(['product', 'isAvailable' => true])

@guest
    {{-- Guest: redirect to login --}}
    <a href="{{ route('login') }}"
        class="inline-flex items-center justify-center min-h-[36px] px-4 py-2 border border-[#e4e4e7] bg-white text-[#27272a] text-xs sm:text-sm font-semibold rounded-lg hover:border-[#2563EB] hover:text-[#2563EB] transition-all duration-200">
        Sign in to Inquire
    </a>
@else
    <div x-data="{
        step: 'idle',
        pendingLang: null,
    
        open() {
            @if (!auth()->user()->phone_number) {{-- No phone → trigger global phone-prompt modal --}}
                    $dispatch('phone-prompt', { productId: {{ $product->id }} });
                @else
                    this.step = 'lang-pick'; @endif
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
            } catch (e) {
                console.error(e);
                this.step = 'idle';
            }
        }
    }" class="relative" @keydown.escape.window="step === 'lang-pick' && (step = 'idle')"
        @phone-saved.window="if ($event.detail.productId === {{ $product->id }}) { step = 'lang-pick'; }">
        {{--  Main Inquire Button  --}}
        <button @click="open()" :disabled="step === 'loading' || !{{ $isAvailable ? 'true' : 'false' }}"
            class="inline-flex items-center justify-center gap-1.5 min-h-[36px] px-4 py-2 rounded-lg text-xs sm:text-sm font-semibold transition-all duration-200
                   {{ $isAvailable
                       ? 'bg-[#2563EB] text-white hover:brightness-95 active:scale-95'
                       : 'bg-gray-100 text-gray-400 cursor-not-allowed' }}"
            :class="{
                'opacity-60 cursor-wait': step === 'loading',
                'bg-blue-600': step === 'done',
            }">
            {{-- Idle / Lang-pick: chat icon --}}
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telegram"
                viewBox="0 0 16 16">
                <path
                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.287 5.906q-1.168.486-4.666 2.01-.567.225-.595.442c-.03.243.275.339.69.47l.175.055c.408.133.958.288 1.243.294q.39.01.868-.32 3.269-2.206 3.374-2.23c.05-.012.12-.026.166.016s.042.12.037.141c-.03.129-1.227 1.241-1.846 1.817-.193.18-.33.307-.358.336a8 8 0 0 1-.188.186c-.38.366-.664.64.015 1.088.327.216.589.393.85.571.284.194.568.387.936.629q.14.092.27.187c.331.236.63.448.997.414.214-.02.435-.22.547-.82.265-1.417.786-4.486.906-5.751a1.4 1.4 0 0 0-.013-.315.34.34 0 0 0-.114-.217.53.53 0 0 0-.31-.093c-.3.005-.763.166-2.984 1.09" />
            </svg>
            {{-- Loading: spinner --}}
            <svg x-show="step === 'loading'" x-cloak class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z" />
            </svg>

            <svg x-show="step === 'done'" x-cloak class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>

            <span x-text="step === 'done' ? 'Sent!' : 'Inquire Via Telegram'"></span>
        </button>

        {{--  Language Picker Dropdown  --}}
        <div x-show="step === 'lang-pick'" x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 scale-95 translate-y-1"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-1" x-cloak @click.outside="step = 'idle'"
            class="absolute z-50 bottom-full mb-2 right-0 w-64 bg-white rounded-2xl border border-[#2563EB]/30 shadow-[0_8px_32px_rgba(29,158,117,0.15)] overflow-hidden">
            <div class="px-4 pt-3.5 pb-2">
                <p class="text-[11px] font-semibold text-[#6B6B6B] uppercase tracking-wide">Inquire in</p>
            </div>
            <div class="flex flex-col gap-0.5 px-2 pb-3">
                {{-- English --}}
                <button @click="choose('en')"
                    class="flex items-center gap-3 w-full px-3 py-2.5 rounded-xl text-sm font-medium text-[#27272a] hover:bg-[#2563EB]/8 hover:text-[#2563EB] transition-colors text-left">
                    <span class="text-lg leading-none">🇺🇸</span>
                    <span>English</span>
                </button>
                {{-- Khmer --}}
                <button @click="choose('km')"
                    class="flex items-center gap-3 w-full px-3 py-2.5 rounded-xl text-sm font-medium text-[#27272a] hover:bg-[#2563EB]/8 hover:text-[#2563EB] transition-colors text-left">
                    <span class="text-lg leading-none">🇰🇭</span>
                    <span class="font-['Kantumruy_Pro',sans-serif]">ភាសាខ្មែរ</span>
                </button>
                {{-- Chinese --}}
                <button @click="choose('zh')"
                    class="flex items-center gap-3 w-full px-3 py-2.5 rounded-xl text-sm font-medium text-[#27272a] hover:bg-[#2563EB]/8 hover:text-[#2563EB] transition-colors text-left">
                    <span class="text-lg leading-none">🇨🇳</span>
                    <span>中文</span>
                </button>
            </div>
        </div>
    </div>
@endguest

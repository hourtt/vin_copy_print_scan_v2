@props([
    'name' => null,
    'id' => null,
    'options' => [],
    'selected' => null,
    'placeholder' => 'Select an option',
    'placeholderKey' => null,
    'searchable' => true,
    'required' => false,
    'autoSubmit' => false,
    'variant' => 'default', // 'default' (rounded-xl full width) or 'pill' (rounded-full compact for hero/navbar search bars)
    'align' => 'right',
    'width' => '48',
    'contentClasses' => 'py-2 bg-white',
])

@if (isset($trigger) && isset($content))
    {{-- Legacy Slot-based Dropdown Compatibility --}}
    @php
        $alignmentClasses = match ($align) {
            'left' => 'ltr:origin-top-left rtl:origin-top-right start-0',
            'top' => 'origin-top',
            default => 'ltr:origin-top-right rtl:origin-top-left end-0',
        };

        $dropdownWidth = match ($width) {
            '48' => 'w-48',
            '56' => 'w-56',
            '60' => 'w-60',
            default => $width,
        };
    @endphp

    <div class="relative"
         x-data="{ open: false }"
         @click.outside="open = false"
         @close.stop="open = false"
         @keydown.escape.prevent.stop="open = false">
        <div @click="open = ! open" aria-haspopup="true" :aria-expanded="open.toString()">
            {{ $trigger }}
        </div>

        <div x-show="open"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
             class="absolute z-50 mt-2 {{ $dropdownWidth }} rounded-2xl shadow-xl border border-gray-100 bg-white p-2 {{ $alignmentClasses }}"
             style="display: none;"
             @click="open = false"
             role="menu">
            <div class="{{ $contentClasses }}">
                {{ $content }}
            </div>
        </div>
    </div>
@else
    {{-- New Styled Option Dropdown Menu --}}
    @php
        // Normalize options so both associative array ['key' => 'Label'] and list of objects [['value' => '...', 'label' => '...']] work seamlessly
        $normalizedOptions = [];
        foreach ($options as $key => $opt) {
            if (is_array($opt) && array_key_exists('value', $opt)) {
                $normalizedOptions[] = [
                    'value' => (string) $opt['value'],
                    'label' => (string) ($opt['label'] ?? $opt['value']),
                    'key'   => $opt['key'] ?? null,
                ];
            } else {
                $normalizedOptions[] = [
                    'value' => (string) $key,
                    'label' => (string) $opt,
                    'key'   => null,
                ];
            }
        }

        $selectedVal = (string) ($selected ?? '');
        $initialOption = collect($normalizedOptions)->first(function ($opt) use ($selectedVal) {
            return (string) ($opt['value'] ?? '') === $selectedVal;
        }) ?? ($selectedVal !== '' && $selectedVal !== 'null'
            ? ['label' => $selectedVal, 'value' => $selectedVal, 'key' => null]
            : ['label' => $placeholder, 'value' => '', 'key' => $placeholderKey]);
    @endphp

    <div {{ $attributes->merge(['class' => 'relative transition-all' . ($variant === 'pill' ? ' mr-1 md:mr-2 shrink-0' : '')]) }}
         :class="{ 'z-50': open, 'z-20': !open }"
         x-data="{
             open: false,
             search: '',
             selected: {{ json_encode($initialOption) }},
             options: {{ json_encode($normalizedOptions) }},
             select(option) {
                 this.selected = option;
                 this.open = false;
                 this.search = '';

                 // Notify hidden input / external listeners if ID is bound
                 @if ($id)
                     const targetEl = document.getElementById('{{ $id }}');
                     if (targetEl) {
                         targetEl.value = option.value;
                         targetEl.dispatchEvent(new Event('change', { bubbles: true }));
                     }
                 @endif

                 if (@js($autoSubmit)) {
                     this.$nextTick(() => {
                         this.$el.closest('form')?.submit();
                     });
                 }
             },
             getLabel(option) {
                 if (!option) return '';
                 if (option.key && this.$store && this.$store.i18n && typeof this.$store.i18n.t === 'function') {
                     return this.$store.i18n.t(option.key);
                 }
                 return option.label || '';
             },
             get filteredOptions() {
                 if (!this.search) return this.options;
                 const q = this.search.toLowerCase();
                 return this.options.filter(o => this.getLabel(o).toLowerCase().includes(q));
             }
         }"
         @click.outside="open = false; search = ''"
         @keydown.escape.window="open = false; search = ''"
         x-effect="if (open && $refs.searchInput) { setTimeout(() => $refs.searchInput.focus(), 60); }">

        {{-- Hidden Input for Form Submission / Event Dispatching --}}
        @if ($name)
            <input type="hidden" name="{{ $name }}" :value="selected.value" value="{{ $initialOption['value'] }}" {{ $required ? 'required' : '' }} @if($id) id="{{ $id }}" @endif>
        @elseif ($id)
            <input type="hidden" :value="selected.value" value="{{ $initialOption['value'] }}" id="{{ $id }}">
        @endif

        {{-- Trigger Button --}}
        @if ($variant === 'pill')
            <button type="button"
                    @click="open = !open"
                    class="flex items-center space-x-1.5 sm:space-x-2.5 px-3 sm:px-4 py-2 rounded-full text-xs sm:text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-50 transition-colors duration-150 focus:outline-none cursor-pointer select-none">
                <span x-text="getLabel(selected) || '{{ $placeholder }}'" class="whitespace-nowrap">{{ $initialOption['label'] ?? $placeholder }}</span>
                <svg class="w-4 h-4 text-gray-400 transition-transform duration-200 transform"
                     :class="{ 'rotate-180 text-gray-700': open }"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
        @else
            <button type="button"
                    @click="open = !open"
                    class="w-full px-4 py-2.5 border rounded-xl bg-white border-gray-200 text-sm text-left flex items-center justify-between transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer select-none"
                    :class="{ 'ring-2 ring-blue-500 border-blue-500': open }">
                <span x-text="getLabel(selected) || '{{ $placeholder }}'"
                      class="block truncate"
                      :class="(selected.value !== '' || (selected.label && selected.label !== '{{ $placeholder }}') || selected.key) ? 'text-gray-900 font-medium' : 'text-gray-400'">
                    {{ $initialOption['label'] ?? $placeholder }}
                </span>
                <svg class="w-4 h-4 text-gray-400 transition-transform duration-200 transform shrink-0 ml-2"
                     :class="{ 'rotate-180 text-blue-600': open }"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
        @endif

        {{-- Animated Dropdown Panel --}}
        <div x-show="open"
             x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
             x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
             class="absolute {{ $variant === 'pill' ? 'right-0 mt-3 w-48 sm:w-56 max-w-[calc(100vw-2rem)] shadow-2xl p-1.5 ring-1 ring-black/5' : 'left-0 right-0 mt-2 shadow-xl p-2' }} bg-white rounded-2xl border border-gray-100 z-50 origin-top"
             style="display: none;">

            @if ($searchable)
                <div x-show="options.length > 6" class="p-1 mb-1 border-b border-gray-100">
                    <div class="relative">
                        <svg class="absolute left-3 top-2.5 w-3.5 h-3.5 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z" />
                        </svg>
                        <input type="text"
                               x-ref="searchInput"
                               x-model="search"
                               @click.stop
                               placeholder="Search..."
                               class="w-full pl-8 pr-3 py-1.5 text-xs bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500 focus:bg-white transition">
                    </div>
                </div>
            @endif

            <div class="max-h-60 overflow-y-auto space-y-1">
                <template x-for="option in filteredOptions" :key="option.value">
                    <button type="button"
                            @click="select(option)"
                            class="w-full flex items-center justify-between px-3.5 py-2.5 text-sm rounded-xl text-left transition-colors duration-150 cursor-pointer"
                            :class="String(selected.value) === String(option.value)
                                ? 'bg-blue-50 text-blue-600 font-semibold'
                                : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900 font-medium'">
                        <span x-text="getLabel(option)"></span>
                        <svg x-show="String(selected.value) === String(option.value)"
                             class="w-4 h-4 text-blue-600 shrink-0 ml-2"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                    </button>
                </template>
                <div x-show="filteredOptions.length === 0" class="px-3 py-3 text-xs text-center text-gray-400">
                    No matching results
                </div>
            </div>
        </div>
    </div>
@endif

<x-app-layout>
    <div class="flex flex-col md:flex-row min-h-screen bg-gray-50" x-data="{
        activeTab: 'general',
        defaultAddressHtml: {{ \Illuminate\Support\Js::from($defaultAddress ? $defaultAddress->address . '<br>' . $defaultAddress->city . ($defaultAddress->state ? ', ' . $defaultAddress->state : '') . ' ' . $defaultAddress->zip_code : '') }}
    }"
        @update-default-address.window="defaultAddressHtml = $event.detail">

        {{-- PANEL 1: FAR-LEFT GLOBAL NAV --}}
        <x-profiles.sidebar-nav />



        {{-- PANEL 3: MAIN CONTENT AREA --}}
        <main class="flex-1 p-4 md:p-8 lg:p-12 overflow-y-auto w-full max-w-full">
            <div x-show="activeTab === 'general'" x-transition class="max-w-4xl mx-auto w-full">
                <x-profiles.header-avatar />
                <x-profiles.activity-overview :recentOrderCount="$recentOrderCount ?? 0" :activeVoucherCount="$activeVoucherCount ?? 0" />
                <x-profiles.personal-info-card />
                <x-profiles.shipping-billing-card />
                <x-profiles.security-integrations-card />
            </div>

            <div x-show="activeTab === 'security'" x-transition style="display: none;" class="max-w-4xl mx-auto w-full">
                @include('profile.security.index')
            </div>
        </main>
    </div>

    {{-- 
         MODAL — Payment Method (Coming Soon)
     --}}
    <x-profiles.modal id="modal-payment" title="Payment Method">
        <div class="text-center py-10 px-6">
            <div
                class="w-14 h-14 rounded-2xl bg-orange-100 flex items-center justify-center mx-auto mb-5 text-orange-600">
                <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2" />
                    <line x1="1" y1="10" x2="23" y2="10" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 m-0 mb-2">
                Coming Soon</h3>
            <p class="text-sm text-gray-500 m-0 mb-6 leading-relaxed">
                Payment method management is currently under development. We'll notify you when it's ready.</p>
            <button type="button"
                class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition-colors w-full max-w-[180px] mx-auto block"
                onclick="closeModal('modal-payment')">Got it</button>
        </div>
    </x-profiles.modal>

    {{-- MODAL — Address Management (Full CRUD) --}}
    <x-address.address-modal />

    {{--  JAVASCRIPT --}}
    @push('scripts')
        @vite(['resources/js/profile.js'])
        <script>
            // Auto-open modals if there are validation errors (password modal, etc.)
            @if ($errors->updatePassword->isNotEmpty())
                document.addEventListener('DOMContentLoaded', () => openModal('modal-password'));
            @endif

            // Auto-open if session status indicates recent update via the old modal flow
            @if (session('status') === 'password-updated')
                document.addEventListener('DOMContentLoaded', () => openModal('modal-password'));
            @endif

            // Auto-open address modal after address save
            @if (session('inline_field') === 'address')
                document.addEventListener('DOMContentLoaded', () => openModal('modal-address'));
            @endif
        </script>
    @endpush
</x-app-layout>

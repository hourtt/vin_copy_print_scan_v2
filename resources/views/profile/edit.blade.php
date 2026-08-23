<x-app-layout>
    <div class="flex flex-col md:flex-row min-h-screen bg-gray-50" x-data="{
        activeTab: 'general',
        isSidebarExpanded: true
    }">

        {{-- PANEL 1: FAR-LEFT GLOBAL NAV --}}
        <x-profiles.sidebar-nav />



        {{-- PANEL 3: MAIN CONTENT AREA --}}
        <main class="flex-1 p-4 md:p-8 lg:p-12 overflow-y-auto w-full max-w-full" :class="isSidebarExpanded ? 'md:ml-0' : 'md:ml-0'">
            <div x-show="activeTab === 'general'" x-transition class="max-w-4xl mx-auto w-full">
                <x-profiles.header-avatar />
                <x-profiles.activity-overview :recentOrderCount="$recentOrderCount ?? 0" :activeVoucherCount="$activeVoucherCount ?? 0" />
                <x-profiles.personal-info-card />
                <x-profiles.shipping-billing-card />
                <x-profiles.security-integrations-card />
            </div>

            <div x-show="activeTab === 'activity'" x-transition style="display: none;" class="max-w-4xl mx-auto w-full">
                <h2 class="text-2xl font-bold mb-4">Activity</h2>
                <x-profiles.activity-overview :recentOrderCount="$recentOrderCount ?? 0" :activeVoucherCount="$activeVoucherCount ?? 0" />
                <!-- More detailed activity logs can go here later -->
            </div>

            <div x-show="activeTab === 'favorites'" x-transition style="display: none;" class="max-w-4xl mx-auto w-full">
                <h2 class="text-2xl font-bold mb-4">Favorites</h2>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
                    <p class="text-gray-500">You haven't saved any items yet.</p>
                </div>
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

    {{-- 
         MODAL — Preferences (Coming Soon)
     --}}
    <x-profiles.modal id="modal-preferences" title="Edit Preferences">
        <div class="text-center py-10 px-6">
            <div
                class="w-14 h-14 rounded-2xl bg-indigo-100 flex items-center justify-center mx-auto mb-5 text-indigo-600">
                <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="2" y1="12" x2="22" y2="12" />
                    <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 m-0 mb-2">
                Coming Soon</h3>
            <p class="text-sm text-gray-500 m-0 mb-6 leading-relaxed">
                Language and Currency preferences will be available in a future update.</p>
            <button type="button"
                class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition-colors w-full max-w-[180px] mx-auto block"
                onclick="closeModal('modal-preferences')">Got it</button>
        </div>
    </x-profiles.modal>

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
        </script>
    @endpush
</x-app-layout>

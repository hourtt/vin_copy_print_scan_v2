<x-app-layout>
    <div class="flex flex-col md:flex-row min-h-screen bg-gray-50">
        {{-- MAIN CONTENT AREA --}}
        <main class="flex-1 p-4 md:p-8 lg:p-12 overflow-y-auto w-full max-w-full">
            <div class="max-w-4xl mx-auto w-full">
                <x-profiles.header-avatar />
                <x-profiles.activity-overview :recentInquiryCount="$recentInquiryCount ?? 0" />
                <x-profiles.personal-info-card />
                <x-profiles.security-integrations-card />
            </div>
        </main>
    </div>

    {{--  JAVASCRIPT --}}
    @push('scripts')
        @vite(['resources/js/profile.js'])
    @endpush
</x-app-layout>

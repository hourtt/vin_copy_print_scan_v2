@props([
    'recentInquiryCount' => 0,
])

<div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8 overflow-hidden">
    <h3 class="px-6 py-4 border-b border-gray-200 text-lg font-semibold text-gray-900 bg-gray-50/50">
        Activity Overview</h3>

    {{-- My Inquiries --}}
    <div
        class="px-6 py-5 border-b border-gray-100 last:border-0 flex flex-col md:flex-row md:items-center gap-4">
        <div class="md:w-1/3 text-sm font-medium text-gray-700">My Inquiries</div>
        <div class="flex-1 text-sm text-gray-900 flex items-baseline">
            <span class="text-xl font-semibold text-gray-900">{{ $recentInquiryCount }}</span>
            <span class="text-sm text-gray-500 ml-2">total inquiries sent</span>
        </div>
        <div class="md:text-right">
            <a href="{{ route('inquire.history') }}"
                class="text-sm font-medium text-indigo-600 hover:text-indigo-700 transition-colors">View
                History</a>
        </div>
    </div>

    {{-- Saved --}}
    <div
        class="px-6 py-5 border-b border-gray-100 last:border-0 flex flex-col md:flex-row md:items-center gap-4">
        <div class="md:w-1/3 text-sm font-medium text-gray-700">Saved</div>
        <div class="flex-1 text-sm text-gray-900">
            <div class="flex items-center gap-6">
                <div>
                    <span class="text-lg font-semibold text-gray-900">0</span>
                    <span class="text-sm text-gray-500 ml-1">wishlist</span>
                </div>
            </div>
        </div>
        <div class="md:text-right">
            <a href="https://t.me/{{ config('services.telegram.owner_username') }}" target="_blank" rel="noopener noreferrer"
                class="inline-flex items-center text-sm font-medium text-white bg-[#1D9E75] hover:bg-[#15805e] px-4 py-2 rounded-lg transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
                Telegram Support
            </a>
        </div>
    </div>
</div>

<aside
    class="w-full md:w-64 bg-white border-r border-gray-200 flex md:flex-col flex-shrink-0 z-10 md:sticky md:top-0 md:h-screen md:min-h-screen overflow-y-auto">

    {{-- User Identity Block --}}
    <div class="p-5 border-b border-gray-100 hidden md:flex items-center gap-3">
        <div
            class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-black font-bold text-sm capitalize flex-shrink-0">
            {{ substr(Auth::user()->first_name, 0, 1) }}
        </div>
        <div class="min-w-0">
            <p class="text-sm font-semibold text-black truncate">{{ Auth::user()->first_name }}
                {{ Auth::user()->last_name }}</p>
            <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
        </div>
    </div>

    {{-- Main Navigation --}}
    <div class="flex md:flex-col gap-1 p-4 overflow-x-auto md:overflow-visible">
        <a href="{{ route('dashboard') }}"
            class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors whitespace-nowrap">
            <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
            Home
        </a>

        <a href="{{ route('orders.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors whitespace-nowrap">
            <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path
                    d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                </path>
                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                <line x1="12" y1="22.08" x2="12" y2="12"></line>
            </svg>
            Orders
        </a>

        <button type="button"
            class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors whitespace-nowrap">
            <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="23 4 23 10 17 10"></polyline>
                <polyline points="1 20 1 14 7 14"></polyline>
                <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
            </svg>
            Activity
        </button>

        <button type="button"
            class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors whitespace-nowrap">
            <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path
                    d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                </path>
            </svg>
            Favorites
        </button>
    </div>

    {{-- Separator --}}
    <div class="hidden md:block mx-4 border-t border-gray-100"></div>

    {{-- Settings Section --}}
    <div class="hidden md:flex flex-col gap-1 p-4">
        <h2 class="px-3 mb-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">Settings</h2>

        <button
            :class="{ 'bg-gray-100 text-indigo-600': activeTab === 'general', 'text-gray-600 hover:bg-gray-50 hover:text-gray-900': activeTab !== 'general' }"
            @click="activeTab = 'general'" type="button"
            class="flex items-center gap-3 px-3 py-2.5 text-left text-sm font-medium rounded-lg whitespace-nowrap transition-colors">
            <svg class="w-5 h-5 flex-shrink-0" :class="{ 'text-indigo-600': activeTab === 'general' }"
                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
            General Profile
        </button>

        <button type="button" onclick="openModal('modal-address')"
            class="flex items-center gap-3 px-3 py-2.5 text-left text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 whitespace-nowrap transition-colors">
            <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                <circle cx="12" cy="10" r="3"></circle>
            </svg>
            Address Book
        </button>

        <button type="button" onclick="openModal('modal-payment')"
            class="flex items-center gap-3 px-3 py-2.5 text-left text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 whitespace-nowrap transition-colors">
            <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                <line x1="1" y1="10" x2="23" y2="10"></line>
            </svg>
            Payment Methods
        </button>

        <button
            :class="{ 'bg-gray-100 text-indigo-600': activeTab === 'security', 'text-gray-600 hover:bg-gray-50 hover:text-gray-900': activeTab !== 'security' }"
            @click="activeTab = 'security'" type="button"
            class="flex items-center gap-3 px-3 py-2.5 text-left text-sm font-medium rounded-lg whitespace-nowrap transition-colors">
            <svg class="w-5 h-5 flex-shrink-0" :class="{ 'text-indigo-600': activeTab === 'security' }"
                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
            </svg>
            Login &amp; Security
        </button>

        <button type="button"
            class="flex items-center gap-3 px-3 py-2.5 text-left text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 whitespace-nowrap transition-colors">
            <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
            </svg>
            Notification Preferences
        </button>
    </div>

    {{-- Bottom Section: Help & Logout --}}
    <div class="hidden md:flex flex-col gap-1 p-4 mt-auto border-t border-gray-100">
        <button type="button"
            class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors">
            <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                <line x1="12" y1="17" x2="12.01" y2="17"></line>
            </svg>
            Help
        </button>

        <button type="button" onclick="openLogoutModal()"
            class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg text-red-500 hover:bg-red-50 hover:text-red-600 transition-colors">
            <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                <polyline points="16 17 21 12 16 7"></polyline>
                <line x1="21" y1="12" x2="9" y2="12"></line>
            </svg>
            Log Out
        </button>
    </div>
</aside>

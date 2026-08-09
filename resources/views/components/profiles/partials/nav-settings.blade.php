    <div class="hidden md:flex flex-col gap-1 p-4">
        <h2 x-show="isSidebarExpanded" class="px-3 mb-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">Settings</h2>

        <button
            :class="{ 'bg-gray-100 text-indigo-600': activeTab === 'general', 'text-gray-600 hover:bg-gray-50 hover:text-gray-900': activeTab !== 'general' }"
            @click="activeTab = 'general'" type="button" title="General Profile"
            class="flex items-center gap-3 px-3 py-2.5 text-left text-sm font-medium rounded-lg whitespace-nowrap transition-colors">
            <svg class="w-5 h-5 flex-shrink-0" :class="{ 'text-indigo-600': activeTab === 'general' }"
                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
            <span x-show="isSidebarExpanded">General Profile</span>
        </button>

        <button type="button" onclick="openModal('modal-address')" title="Address Book"
            class="flex items-center gap-3 px-3 py-2.5 text-left text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 whitespace-nowrap transition-colors">
            <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                <circle cx="12" cy="10" r="3"></circle>
            </svg>
            <span x-show="isSidebarExpanded">Address Book</span>
        </button>

        <button type="button" onclick="openModal('modal-payment')" title="Payment Methods"
            class="flex items-center gap-3 px-3 py-2.5 text-left text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 whitespace-nowrap transition-colors">
            <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                <line x1="1" y1="10" x2="23" y2="10"></line>
            </svg>
            <span x-show="isSidebarExpanded">Payment Methods</span>
        </button>

        <button
            :class="{ 'bg-gray-100 text-indigo-600': activeTab === 'security', 'text-gray-600 hover:bg-gray-50 hover:text-gray-900': activeTab !== 'security' }"
            @click="activeTab = 'security'" type="button" title="Login &amp; Security"
            class="flex items-center gap-3 px-3 py-2.5 text-left text-sm font-medium rounded-lg whitespace-nowrap transition-colors">
            <svg class="w-5 h-5 flex-shrink-0" :class="{ 'text-indigo-600': activeTab === 'security' }"
                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
            </svg>
            <span x-show="isSidebarExpanded">Login &amp; Security</span>
        </button>

        <button type="button" onclick="openModal('modal-preferences')" title="Notification Preferences"
            class="flex items-center gap-3 px-3 py-2.5 text-left text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 whitespace-nowrap transition-colors">
            <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
            </svg>
            <span x-show="isSidebarExpanded">Notification Preferences</span>
        </button>
    </div>

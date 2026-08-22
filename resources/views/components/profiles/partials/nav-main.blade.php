    <div class="flex md:flex-col gap-1 p-4 overflow-x-auto md:overflow-visible">
        <a href="{{ route('dashboard') }}"
            class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors whitespace-nowrap"
            title="Home">
            <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
            <span x-show="isSidebarExpanded">Home</span>
        </a>

        <a href="{{ route('profile.inquiries.index') }}"
            class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition-colors whitespace-nowrap"
            title="Inquiries">
            <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
            </svg>
            <span x-show="isSidebarExpanded">Inquiries</span>
        </a>

        <button type="button" @click="activeTab = 'activity'"
            :class="{ 'bg-gray-100 text-indigo-600': activeTab === 'activity', 'text-gray-600 hover:bg-gray-50 hover:text-gray-900': activeTab !== 'activity' }"
            class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-colors whitespace-nowrap"
            title="Activity">
            <svg class="w-5 h-5 flex-shrink-0" :class="{ 'text-indigo-600': activeTab === 'activity' }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="23 4 23 10 17 10"></polyline>
                <polyline points="1 20 1 14 7 14"></polyline>
                <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
            </svg>
            <span x-show="isSidebarExpanded">Activity</span>
        </button>

        <button type="button" @click="activeTab = 'favorites'"
            :class="{ 'bg-gray-100 text-indigo-600': activeTab === 'favorites', 'text-gray-600 hover:bg-gray-50 hover:text-gray-900': activeTab !== 'favorites' }"
            class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium rounded-lg transition-colors whitespace-nowrap"
            title="Favorites">
            <svg class="w-5 h-5 flex-shrink-0" :class="{ 'text-indigo-600': activeTab === 'favorites' }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path
                    d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                </path>
            </svg>
            <span x-show="isSidebarExpanded">Favorites</span>
        </button>
    </div>

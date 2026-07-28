<nav
    class="w-full md:w-64 bg-white border-r border-gray-200 flex flex-col flex-shrink-0 md:sticky md:top-0 md:h-screen overflow-y-auto">
    <div class="p-6 border-b border-gray-100 hidden md:block">
        <h1 class="text-xl font-bold text-gray-900">Settings</h1>
    </div>

    <div class="flex md:flex-col gap-1 p-4 overflow-x-auto md:overflow-visible">
        <button
            :class="{ 'bg-gray-100 text-gray-900': activeTab === 'general', 'text-gray-600 hover:bg-gray-50 hover:text-gray-900': activeTab !== 'general' }"
            @click="activeTab = 'general'" type="button"
            class="px-4 py-2.5 text-left text-sm font-medium rounded-lg whitespace-nowrap transition-colors">General
            Profile</button>
        <button type="button" onclick="openModal('modal-address')"
            class="px-4 py-2.5 text-left text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 whitespace-nowrap transition-colors">Address
            Book</button>
        <button type="button" onclick="openModal('modal-payment')"
            class="px-4 py-2.5 text-left text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 whitespace-nowrap transition-colors">Payment
            Methods</button>
        <button
            :class="{ 'bg-gray-100 text-gray-900': activeTab === 'security', 'text-gray-600 hover:bg-gray-50 hover:text-gray-900': activeTab !== 'security' }"
            @click="activeTab = 'security'" type="button"
            class="px-4 py-2.5 text-left text-sm font-medium rounded-lg whitespace-nowrap transition-colors">Login
            &amp; Security</button>
        <button type="button"
            class="px-4 py-2.5 text-left text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 whitespace-nowrap transition-colors">Notification
            Preferences</button>
    </div>
</nav>

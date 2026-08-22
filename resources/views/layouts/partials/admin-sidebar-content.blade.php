<!-- Logo -->
<div class="h-16 flex items-center px-6 border-b border-gray-100 shrink-0">
    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
        <!-- Logo SVG -->
        <img class="h-10 w-auto rounded-lg" src="{{ asset('storage/images/logo-icon-only.webp') }}" alt="Logo" loading="lazy">
    </a>
</div>

<!-- Navigation Links -->
<nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto sidebar-scroll">

    <!-- Dashboard -->
    <a href="{{ Route::has('admin.dashboard') ? route('admin.dashboard') : '#' }}"
        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors mb-1
       {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 text-indigo-700 relative' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
        @if (request()->routeIs('admin.dashboard'))
            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-indigo-600 rounded-r-full"></span>
        @endif
        <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-indigo-600' : 'text-gray-400' }}"
            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
        </svg>
        Dashboard
    </a>

    <!-- Products (Dropdown) -->
    <div x-data="{ open: {{ request()->routeIs('admin.products.*') ? 'true' : 'false' }} }" class="mb-1">
        <button @click="open = !open"
            class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                {{ request()->routeIs('admin.products.*') ? 'text-indigo-700 bg-indigo-50/50' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            <div class="flex items-center gap-3 relative">
                @if (request()->routeIs('admin.products.*'))
                    <span class="absolute -left-3 top-1/2 -translate-y-1/2 w-1 h-6 bg-indigo-600 rounded-r-full"></span>
                @endif
                <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('admin.products.*') ? 'text-indigo-600' : 'text-gray-400' }}"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                Products
            </div>
            <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
        <div x-show="open" x-collapse x-cloak>
            <div class="mt-1 space-y-1 px-3 pb-1">
                <a href="{{ Route::has('admin.products.index') ? route('admin.products.index') : '#' }}"
                    class="block pl-10 pr-3 py-2 text-sm font-medium rounded-lg transition-colors
                   {{ request()->routeIs('admin.products.index') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
                    Product List
                </a>
                <a href="{{ Route::has('admin.categories.index') ? route('admin.categories.index') : '#' }}"
                    class="block pl-10 pr-3 py-2 text-sm font-medium rounded-lg transition-colors
                   {{ request()->routeIs('admin.categories.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
                    Categories
                </a>
            </div>
        </div>
    </div>



    <!-- Customers -->
    <a href="{{ Route::has('admin.customers.index') ? route('admin.customers.index') : '#' }}"
        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors mb-1
       {{ request()->routeIs('admin.customers.*') ? 'bg-indigo-50 text-indigo-700 relative' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
        @if (request()->routeIs('admin.customers.*'))
            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-indigo-600 rounded-r-full"></span>
        @endif
        <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('admin.customers.*') ? 'text-indigo-600' : 'text-gray-400' }}"
            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
        Customers
    </a>

    <!-- Inquiries -->
    <a href="{{ Route::has('admin.inquiries.index') ? route('admin.inquiries.index') : '#' }}"
        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors mb-1
       {{ request()->routeIs('admin.inquiries.*') ? 'bg-indigo-50 text-indigo-700 relative' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
        @if (request()->routeIs('admin.inquiries.*'))
            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-indigo-600 rounded-r-full"></span>
        @endif
        <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('admin.inquiries.*') ? 'text-indigo-600' : 'text-gray-400' }}"
            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg>
        Inquiries
    </a>
</nav>

<!-- Settings section at bottom -->
<div class="p-4 border-t border-gray-100">
    <a href="{{ Route::has('admin.settings.index') ? route('admin.settings.index') : '#' }}"
        class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
       {{ request()->routeIs('admin.settings.*') ? 'bg-indigo-50 text-indigo-700 relative' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
        @if (request()->routeIs('admin.settings.*'))
            <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-indigo-600 rounded-r-full"></span>
        @endif
        <svg class="w-5 h-5 flex-shrink-0 {{ request()->routeIs('admin.settings.*') ? 'text-indigo-600' : 'text-gray-400' }}"
            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        Settings
    </a>
</div>

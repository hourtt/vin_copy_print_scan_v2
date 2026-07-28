<aside
    class="w-full md:w-20 bg-gray-900 flex md:flex-col items-center justify-between py-4 px-4 md:px-0 flex-shrink-0 z-10 md:sticky md:top-0 md:h-screen md:min-h-screen">
    <div class="flex md:flex-col gap-4 items-center w-full">
        {{-- Customer Account Dropdown Trigger / Avatar --}}
        <div class="w-10 h-10 flex items-center justify-center rounded-lg text-gray-400 mx-auto"
            aria-label="Customer Account">
            <div
                class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-white font-bold text-sm capitalize">
                {{ substr(Auth::user()->first_name, 0, 1) }}
            </div>
        </div>

        {{-- Separator --}}
        <div class="hidden md:block w-8 h-px bg-white/10 my-2"></div>
        <div class="block md:hidden h-8 w-px bg-white/10 mx-2"></div>

        {{-- Home / Storefront --}}
        <a href="{{ route('dashboard') }}"
            class="w-10 h-10 flex items-center justify-center rounded-lg text-gray-400 hover:text-white hover:bg-gray-800 transition-colors"
            aria-label="Storefront">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                <polyline points="9 22 9 12 15 12 15 22"></polyline>
            </svg>
        </a>

        {{-- My Orders --}}
        <a href="{{ route('orders.index') }}"
            class="w-10 h-10 flex items-center justify-center rounded-lg text-gray-400 hover:text-white hover:bg-gray-800 transition-colors"
            aria-label="My Orders">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path
                    d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                </path>
                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                <line x1="12" y1="22.08" x2="12" y2="12"></line>
            </svg>
        </a>

        {{-- My Subscriptions (Placeholder) --}}
        <button type="button"
            class="w-10 h-10 flex items-center justify-center rounded-lg text-gray-400 hover:text-white hover:bg-gray-800 transition-colors"
            aria-label="My Subscriptions">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="23 4 23 10 17 10"></polyline>
                <polyline points="1 20 1 14 7 14"></polyline>
                <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
            </svg>
        </button>

        {{-- Saved Items / Wishlist (Placeholder) --}}
        <button type="button"
            class="w-10 h-10 flex items-center justify-center rounded-lg text-gray-400 hover:text-white hover:bg-gray-800 transition-colors"
            aria-label="Wishlist">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path
                    d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                </path>
            </svg>
        </button>
    </div>

    <div class="flex md:flex-col gap-4 items-center mt-auto">
        {{-- Support / Help Center (Placeholder) --}}
        <button type="button"
            class="w-10 h-10 flex items-center justify-center rounded-lg text-gray-400 hover:text-white hover:bg-gray-800 transition-colors md:mb-2"
            aria-label="Help Center">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"></circle>
                <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                <line x1="12" y1="17" x2="12.01" y2="17"></line>
            </svg>
        </button>

        {{-- Logout --}}
        <div class="w-full flex justify-center">
            <button type="button"
                class="w-10 h-10 flex items-center justify-center rounded-lg text-red-400 hover:bg-red-500/10 hover:text-red-500 transition-colors"
                aria-label="Log Out" onclick="openLogoutModal()">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
            </button>
        </div>
    </div>
</aside>

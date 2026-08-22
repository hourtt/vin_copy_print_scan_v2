<nav x-data="{ mobileMenuOpen: false }"
    class="sticky top-0 z-50 w-full bg-white border-b border-[#E5E5E2]">
    <div class="max-w-[1280px] mx-auto px-6 md:px-12 lg:px-16">
        <div class="relative flex items-center h-16 lg:h-[68px]">

            {{--  LEFT: Logo  --}}
            <div class="flex-shrink-0">
                <a href="{{ Auth::check() ? Auth::user()->getRedirectRoute() : route('dashboard') }}"
                    class="flex items-center gap-2.5 group" aria-label="Vin Copy Print Scan V2 — Home">
                    <img src="{{ asset('storage/images/logo-icon-only.webp') }}" class="h-9 w-auto object-contain transition-transform duration-300 group-hover:scale-105"
                        alt="Vin Copy Print Scan V2 logo" loading="lazy">
                </a>
            </div>

            {{--  CENTER: Desktop nav links  --}}
            <div class="hidden lg:flex absolute left-1/2 -translate-x-1/2 items-center gap-8">

                <a href="{{ Auth::check() ? Auth::user()->getRedirectRoute() : route('dashboard') }}"
                    class="nav-link text-sm font-medium transition-colors duration-200 font-['Kantumruy Pro',sans-serif] text-[#6B6B6B] hover:text-[#0D0D0B]">
                    Home
                </a>

                {{-- Products dropdown --}}
                <div x-data="{ open: false }" @click.outside="open = false" class="relative">
                    <button @click="open = !open"
                        class="flex items-center gap-1.5 text-sm font-medium transition-colors duration-200 focus:outline-none font-['Kantumruy Pro',sans-serif] text-[#6B6B6B] hover:text-[#0D0D0B]"
                        :class="{ '!text-[#0D0D0B]': open }">
                        Products
                        <svg class="w-4 h-4 shrink-0 transition-transform duration-200" :class="{ 'rotate-180': open }"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-1" x-cloak
                        class="absolute z-50 top-full left-1/2 -translate-x-1/2 mt-3 w-48 rounded-xl overflow-hidden bg-white border border-[#E5E5E2] shadow-[0_8px_24px_rgba(0,0,0,0.07)]">
                        <div class="flex flex-col gap-1.5">
                            <a href="{{ route('products.printers.index') }}"
                                class="flex items-center gap-2 px-4 py-2.5 text-sm transition-colors duration-150 font-['Kantumruy Pro',sans-serif] text-[#4A4A48] hover:bg-[#D3D3D3] hover:text-[#0D0D0B] rounded-t-md justify-center">
                                Printers
                            </a>
                            <a href="{{ route('products.toners.index') }}"
                                class="flex items-center gap-2 px-4 py-2.5 text-sm transition-colors duration-150 font-['Kantumruy Pro',sans-serif] text-[#4A4A48] hover:bg-[#D3D3D3] hover:text-[#0D0D0B] justify-center">
                                Toners
                            </a>
                            <a href="{{ route('products.inks.index') }}"
                                class="flex items-center gap-2 px-4 py-2.5 text-sm transition-colors duration-150 font-['Kantumruy Pro',sans-serif] text-[#4A4A48] hover:bg-[#D3D3D3] hover:text-[#0D0D0B] justify-center">
                                Ink Cartridges
                            </a>
                            <a href="{{ route('products.papers.index') }}"
                                class="flex items-center gap-2 px-4 py-2.5 text-sm transition-colors duration-150 font-['Kantumruy Pro',sans-serif] text-[#4A4A48] hover:bg-[#D3D3D3] hover:text-[#0D0D0B] rounded-b-md justify-center">
                                Papers
                            </a>
                        </div>
                    </div>
                </div>

                <a href="{{ route('services') }}"
                    class="text-sm font-medium transition-colors duration-200 font-['Kantumruy Pro',sans-serif] text-[#6B6B6B] hover:text-[#0D0D0B]">
                    Services
                </a>
            </div>

            {{--  RIGHT: Icon trio + account  --}}
            <div class="ml-auto flex items-center gap-5">

                @auth
                    @if (Auth::user()->role === 'customer')
                        <a href="{{ route('profile.inquiries.index') }}"
                            class="hidden lg:flex items-center justify-center w-8 h-8 rounded-full transition-colors duration-150 text-[#6B6B6B] hover:text-[#0D0D0B]"
                            aria-label="My Inquiries">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.75"
                                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" />
                            </svg>
                        </a>
                    @endif

                    {{-- Account dropdown --}}
                    <div x-data="{ accountOpen: false }" @click.outside="accountOpen = false" class="relative">
                        <button @click="accountOpen = !accountOpen"
                            class="flex items-center justify-center w-8 h-8 rounded-full transition-colors duration-150 focus:outline-none text-[#6B6B6B] hover:text-[#0D0D0B]"
                            :class="accountOpen ? '!text-[#0D0D0B]' : ''" aria-label="Account menu">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.75"
                                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                        </button>

                        <div x-show="accountOpen" x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-1" x-cloak
                            class="absolute z-50 right-0 top-full mt-3 w-52 rounded-xl overflow-hidden bg-white border border-[#E5E5E2] shadow-[0_8px_24px_rgba(0,0,0,0.07)]">
                            <div class="px-4 py-3 border-b border-[#F0F0EE]">
                                <div class="text-sm font-semibold font-['Kantumruy_Pro',sans-serif] text-[#0D0D0B]">
                                    {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                                </div>
                                <div class="text-xs mt-0.5 truncate text-[#9A9A96] font-['Kantumruy_Pro',sans-serif]">
                                    {{ Auth::user()->email }}
                                </div>
                            </div>
                            <div class="py-1.5">
                                <a href="{{ route('profile.edit') }}"
                                    class="flex items-center px-4 py-2.5 text-sm transition-colors duration-150 font-['Kantumruy_Pro',sans-serif] text-[#4A4A48] hover:bg-[#D3D3D3] hover:text-[#0D0D0B]">
                                    Profile
                                </a>
                                <button type="button" onclick="event.preventDefault(); openLogoutModal();"
                                    class="w-full flex items-center px-4 py-2.5 text-sm transition-colors duration-150 font-['Kantumruy_Pro',sans-serif] text-[#C0392B] hover:bg-[#FFF5F5]">
                                    Log Out
                                </button>
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Guest: Sign In text link + Register pill --}}
                    <div class="hidden sm:flex items-center gap-4">
                        <a href="{{ route('login') }}"
                            class="text-sm font-medium transition-colors duration-200 font-['Kantumruy Pro',sans-serif] text-[#6B6B6B] hover:text-[#0D0D0B]">
                            Sign In
                        </a>
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center px-4 py-2 rounded-lg text-sm font-normal text-white transition-all duration-200 hover:brightness-90 bg-[#305CDE] font-['Kantumruy Pro',sans-serif]">
                            Get Started
                        </a>
                    </div>
                @endauth

                {{-- Hamburger (mobile / tablet, hidden on lg) --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="flex lg:hidden items-center justify-center w-9 h-9 rounded-lg transition-colors duration-150 focus:outline-none text-[#0D0D0B]"
                    aria-label="Toggle menu">
                    <svg x-show="!mobileMenuOpen" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <svg x-show="mobileMenuOpen" x-cloak class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

            </div>
        </div>
    </div>

    {{--  Mobile Drawer  --}}
    <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2" x-cloak
        class="lg:hidden bg-[#FFFFFF] border-t border-[#FFFFFF]">
        <div class="max-w-[1280px] mx-auto px-6 py-4 space-y-1">

            <a href="{{ Auth::check() ? Auth::user()->getRedirectRoute() : route('dashboard') }}"
                class="block px-3 py-2.5 rounded-lg text-sm font-medium transition-colors font-['Kantumruy_Pro',sans-serif] text-[#0D0D0B]">
                Home
            </a>

            {{-- Mobile Products Accordion --}}
            <div x-data="{ mOpen: false }">
                <button @click="mOpen = !mOpen"
                    class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg text-sm font-medium transition-colors font-['Kantumruy_Pro',sans-serif] text-[#0D0D0B]">
                    Products
                    <svg class="w-4 h-4 shrink-0 transition-transform duration-200" :class="{ 'rotate-180': mOpen }"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div x-show="mOpen" x-cloak class="pl-5 pt-1 space-y-0.5">
                    <a href="{{ route('products.printers.index') }}"
                        class="block px-3 py-2 rounded-lg text-sm transition-colors font-['Kantumruy_Pro',sans-serif] text-[#6B6B6B] hover:bg-[#ECEAE6] hover:text-[#0D0D0B]">Printers</a>
                    <a href="{{ route('products.toners.index') }}"
                        class="block px-3 py-2 rounded-lg text-sm transition-colors font-['Kantumruy_Pro',sans-serif] text-[#6B6B6B] hover:bg-[#ECEAE6] hover:text-[#0D0D0B]">Toners</a>
                    <a href="{{ route('products.inks.index') }}"
                        class="block px-3 py-2 rounded-lg text-sm transition-colors font-['Kantumruy_Pro',sans-serif] text-[#6B6B6B] hover:bg-[#ECEAE6] hover:text-[#0D0D0B]">Ink
                        Cartridges</a>
                    <a href="{{ route('products.papers.index') }}"
                        class="block px-3 py-2 rounded-lg text-sm transition-colors font-['Kantumruy_Pro',sans-serif] text-[#6B6B6B] hover:bg-[#ECEAE6] hover:text-[#0D0D0B]">Papers</a>
                </div>
            </div>

            <a href="{{ route('services') }}"
                class="block px-3 py-2.5 rounded-lg text-sm font-medium transition-colors font-['Kantumruy_Pro',sans-serif] text-[#0D0D0B]">
                Services
            </a>

            <a href="{{ route('product-catalog.index') }}"
                class="block px-3 py-2.5 rounded-lg text-sm font-medium transition-colors font-['Kantumruy_Pro',sans-serif] text-[#0D0D0B]">
                Catalog
            </a>
        </div>

        <div class="max-w-[1280px] mx-auto px-6 pb-5 pt-3 border-t border-[#E5E5E2]">
            @auth
                <div class="flex items-center gap-3 mb-3 pt-3">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center bg-[#305CDE]">
                        <span
                            class="text-xs font-bold text-white">{{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}</span>
                    </div>
                    <div>
                        <div class="text-sm font-semibold font-['Kantumruy_Pro',sans-serif] text-[#0D0D0B]">
                            {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                        </div>
                        <div class="text-xs text-[#9A9A96] font-['Kantumruy_Pro',sans-serif]">
                            {{ Auth::user()->email }}</div>
                    </div>
                </div>
                <div class="space-y-0.5">
                    @if (Auth::user()->role === 'customer')
                        <a href="{{ route('profile.inquiries.index') }}"
                            class="block px-3 py-2.5 rounded-lg text-sm font-semibold transition-colors font-['Kantumruy_Pro',sans-serif] text-[#6B6B6B] hover:bg-[#ECEAE6] hover:text-[#0D0D0B]">
                            My Inquiries
                        </a>
                    @endif
                    @if (Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                            class="block px-3 py-2.5 rounded-lg text-sm font-semibold transition-colors font-['Kantumruy_Pro',sans-serif] text-indigo-600 hover:bg-[#ECEAE6] hover:text-indigo-800">Admin
                            Dashboard</a>
                    @endif
                    <a href="{{ route('profile.edit') }}"
                        class="block px-3 py-2.5 rounded-lg text-sm transition-colors font-['Kantumruy_Pro',sans-serif] text-[#6B6B6B] hover:bg-[#ECEAE6] hover:text-[#0D0D0B]">Profile</a>
                    <button type="button" onclick="event.preventDefault(); openLogoutModal();"
                        class="w-full text-left px-3 py-2.5 rounded-lg text-sm transition-colors font-['Kantumruy_Pro',sans-serif] text-[#C0392B] hover:bg-[#FFF5F5]">
                        Log Out
                    </button>
                </div>
            @else
                <div class="flex items-center gap-3 pt-3">
                    <a href="{{ route('login') }}"
                        class="flex-1 text-center px-4 py-2.5 rounded-lg text-sm font-medium border transition-colors font-['Kantumruy_Pro',sans-serif] text-[#0D0D0B] border-[#DDDDD8] hover:bg-[#ECEAE6]">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}"
                        class="flex-1 text-center px-4 py-2.5 rounded-lg text-sm font-semibold text-white transition-all hover:brightness-90 bg-[#305CDE] font-['Kantumruy_Pro',sans-serif]">
                        Get Started
                    </a>
                </div>
            @endauth
        </div>
    </div>

</nav>

@include('components.logout-modal')

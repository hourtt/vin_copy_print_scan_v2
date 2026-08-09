<aside
    :class="isSidebarExpanded ? 'md:w-64' : 'md:w-20'"
    class="w-full bg-white border-r border-gray-200 flex md:flex-col flex-shrink-0 z-10 md:sticky md:top-0 md:h-screen md:min-h-screen overflow-y-auto transition-all duration-300">

    {{-- Toggle Button --}}
    <div class="hidden md:flex items-center justify-end p-2 border-b border-gray-100">
        <button type="button" @click="isSidebarExpanded = !isSidebarExpanded"
            class="p-1.5 rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors">
            <svg x-show="isSidebarExpanded" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
            </svg>
            <svg x-show="!isSidebarExpanded" class="w-5 h-5" style="display: none;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />
            </svg>
        </button>
    </div>

    {{-- User Identity Block --}}
    <div class="p-5 border-b border-gray-100 hidden md:flex items-center gap-3">
        <div
            class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-black font-bold text-sm capitalize flex-shrink-0">
            {{ substr(Auth::user()->first_name, 0, 1) }}
        </div>
        <div class="min-w-0" x-show="isSidebarExpanded">
            <p class="text-sm font-semibold text-black truncate">{{ Auth::user()->first_name }}
                {{ Auth::user()->last_name }}</p>
            <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
        </div>
    </div>

    @include('components.profiles.partials.nav-main')

    {{-- Separator --}}
    <div class="hidden md:block mx-4 border-t border-gray-100"></div>

    @include('components.profiles.partials.nav-settings')

    @include('components.profiles.partials.nav-bottom')
</aside>

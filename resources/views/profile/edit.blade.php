<x-app-layout>
    <div class="flex flex-col md:flex-row min-h-screen bg-gray-50" x-data="{ 
        activeTab: 'general',
        defaultAddressHtml: {{ \Illuminate\Support\Js::from($defaultAddress ? $defaultAddress->address . '<br>' . $defaultAddress->city . ($defaultAddress->state ? ', ' . $defaultAddress->state : '') . ' ' . $defaultAddress->zip_code : '') }}
    }" @update-default-address.window="defaultAddressHtml = $event.detail">

        {{-- 
             PANEL 1: FAR-LEFT GLOBAL NAV
         --}}
        <aside class="w-full md:w-20 bg-gray-900 flex md:flex-col items-center justify-between py-4 px-4 md:px-0 flex-shrink-0 z-10 md:sticky md:top-0 md:h-screen md:min-h-screen">
            <div class="flex md:flex-col gap-4 items-center w-full">
                {{-- Customer Account Dropdown Trigger / Avatar --}}
                <div class="w-10 h-10 flex items-center justify-center rounded-lg text-gray-400 mx-auto" aria-label="Customer Account">
                    <div
                        class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center text-white font-bold text-sm capitalize">
                        {{ substr(Auth::user()->first_name, 0, 1) }}
                    </div>
                </div>

                {{-- Separator --}}
                <div class="hidden md:block w-8 h-px bg-white/10 my-2"></div>
                <div class="block md:hidden h-8 w-px bg-white/10 mx-2"></div>

                {{-- Home / Storefront --}}
                <a href="{{ route('dashboard') }}" class="w-10 h-10 flex items-center justify-center rounded-lg text-gray-400 hover:text-white hover:bg-gray-800 transition-colors" aria-label="Storefront">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                </a>

                {{-- My Orders --}}
                <a href="{{ route('orders.index') }}" class="w-10 h-10 flex items-center justify-center rounded-lg text-gray-400 hover:text-white hover:bg-gray-800 transition-colors" aria-label="My Orders">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z">
                        </path>
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                    </svg>
                </a>

                {{-- My Subscriptions (Placeholder) --}}
                <button type="button" class="w-10 h-10 flex items-center justify-center rounded-lg text-gray-400 hover:text-white hover:bg-gray-800 transition-colors" aria-label="My Subscriptions">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="23 4 23 10 17 10"></polyline>
                        <polyline points="1 20 1 14 7 14"></polyline>
                        <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                    </svg>
                </button>

                {{-- Saved Items / Wishlist (Placeholder) --}}
                <button type="button" class="w-10 h-10 flex items-center justify-center rounded-lg text-gray-400 hover:text-white hover:bg-gray-800 transition-colors" aria-label="Wishlist">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                        </path>
                    </svg>
                </button>
            </div>

            <div class="flex md:flex-col gap-4 items-center mt-auto">
                {{-- Support / Help Center (Placeholder) --}}
                <button type="button" class="w-10 h-10 flex items-center justify-center rounded-lg text-gray-400 hover:text-white hover:bg-gray-800 transition-colors md:mb-2" aria-label="Help Center">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                    </button>
                </div>
            </div>
        </aside>

        {{--  PANEL 2: INNER-LEFT SETTINGS MENU--}}
        <nav class="w-full md:w-64 bg-white border-r border-gray-200 flex flex-col flex-shrink-0 md:sticky md:top-0 md:h-screen overflow-y-auto">
            <div class="p-6 border-b border-gray-100 hidden md:block">
                <h1 class="text-xl font-bold text-gray-900">Settings</h1>
            </div>

            <div class="flex md:flex-col gap-1 p-4 overflow-x-auto md:overflow-visible">
                <button :class="activeTab === 'general' ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'" @click="activeTab = 'general'" type="button" class="px-4 py-2.5 text-left text-sm font-medium rounded-lg whitespace-nowrap transition-colors">General Profile</button>
                <button type="button" onclick="openModal('modal-address')" class="px-4 py-2.5 text-left text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 whitespace-nowrap transition-colors">Address Book</button>
                <button type="button" onclick="openModal('modal-payment')" class="px-4 py-2.5 text-left text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 whitespace-nowrap transition-colors">Payment Methods</button>
                <button :class="activeTab === 'security' ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'" @click="activeTab = 'security'" type="button" class="px-4 py-2.5 text-left text-sm font-medium rounded-lg whitespace-nowrap transition-colors">Login &amp; Security</button>
                <button type="button" class="px-4 py-2.5 text-left text-sm font-medium rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 whitespace-nowrap transition-colors">Notification Preferences</button>
            </div>
        </nav>

        {{-- 
             PANEL 3: MAIN CONTENT AREA
         --}}
        <main class="flex-1 p-4 md:p-8 lg:p-12 overflow-y-auto w-full max-w-full">
            <div x-show="activeTab === 'general'" x-transition class="max-w-4xl mx-auto w-full">

                {{-- Header / Avatar --}}
                <div class="flex flex-col sm:flex-row sm:items-center gap-6 mb-10">
                    <div class="w-20 h-20 md:w-24 md:h-24 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 flex-shrink-0">
                        <span class="text-3xl font-bold uppercase">
                            {{ substr(Auth::user()->first_name, 0, 1) }}
                        </span>
                    </div>

                    <div class="flex flex-col gap-2">
                        <h2 class="text-2xl font-bold text-gray-900">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}
                        </h2>
                        <div class="flex flex-wrap gap-3 mt-1">
                            <button type="button" class="px-3 py-1.5 text-sm font-medium border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">Upload new</button>
                            <button type="button"
                                class="px-3 py-1.5 text-sm font-medium border border-gray-300 rounded-md bg-white transition-colors text-red-600 hover:bg-red-50 hover:border-red-300 hover:text-red-700">Delete</button>
                        </div>
                    </div>
                </div>

                {{-- Activity Overview --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8 overflow-hidden">
                    <h3 class="px-6 py-4 border-b border-gray-200 text-lg font-semibold text-gray-900 bg-gray-50/50">Activity Overview</h3>

                    {{-- Recent Orders --}}
                    <div class="px-6 py-5 border-b border-gray-100 last:border-0 flex flex-col md:flex-row md:items-center gap-4">
                        <div class="md:w-1/3 text-sm font-medium text-gray-700">Recent Orders</div>
                        <div class="flex-1 text-sm text-gray-900 flex items-baseline">
                            <span class="text-xl font-semibold text-gray-900">{{ $recentOrderCount ?? 0 }}</span>
                            <span class="text-sm text-gray-500 ml-2">total orders placed</span>
                        </div>
                        <div class="md:text-right">
                            <a href="{{ route('orders.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-700 transition-colors">View Orders</a>
                        </div>
                    </div>

                    {{-- Saved & Vouchers --}}
                    <div class="px-6 py-5 border-b border-gray-100 last:border-0 flex flex-col md:flex-row md:items-center gap-4">
                        <div class="md:w-1/3 text-sm font-medium text-gray-700">Saved & Vouchers</div>
                        <div class="flex-1 text-sm text-gray-900">
                            <div class="flex items-center gap-6">
                                <div>
                                    <span class="text-lg font-semibold text-gray-900">0</span>
                                    <span class="text-sm text-gray-500 ml-1">wishlist</span>
                                </div>
                                <div class="w-px h-5 bg-gray-200"></div>
                                <div>
                                    <span class="text-lg font-semibold text-gray-900">{{ $activeVoucherCount ?? 0 }}</span>
                                    <span class="text-sm text-gray-500 ml-1">active vouchers</span>
                                </div>
                            </div>
                        </div>
                        <div class="md:text-right">
                            <button type="button" class="text-sm font-medium text-indigo-600 hover:text-indigo-700 transition-colors">View Details</button>
                        </div>
                    </div>
                </div>

                {{-- Inline-Editable Profile Rows --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8 overflow-hidden">
                    <h3 class="px-6 py-4 border-b border-gray-200 text-lg font-semibold text-gray-900 bg-gray-50/50">Personal Information</h3>

                    {{--  Row 1: Full Name (inline edit)  --}}
                    <div class="px-6 py-5 border-b border-gray-100 last:border-0 flex flex-col md:flex-row gap-4" data-inline-field="name">

                        <div class="md:w-1/3 text-sm font-medium text-gray-700 md:mt-1">Full Name</div>

                        {{-- Display slot: shown by default --}}
                        <div class="flex-1 text-sm text-gray-900 ie-display flex justify-between items-start w-full">
                            <span id="ie-display-name" class="mt-1">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
                            <button type="button" class="text-sm font-medium text-indigo-600 hover:text-indigo-700 transition-colors mt-1" onclick="ieOpen('name')">Edit</button>
                        </div>

                        {{-- Editor slot: hidden by default --}}
                        <div class="flex-1 ie-editor w-full" id="ie-editor-name" style="display:none;">
                            <form method="POST" action="{{ route('profile.update') }}" class="flex flex-col gap-4 w-full" data-field="name">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="inline_field" value="name">
                                <div class="flex flex-col sm:flex-row gap-4 w-full">
                                    <div class="flex-1 flex flex-col gap-1.5">
                                        <label class="text-sm font-medium text-gray-700" for="ie-first-name">First Name</label>
                                        <input class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm @error('first_name') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                            id="ie-first-name" type="text" name="first_name"
                                            value="{{ old('first_name', Auth::user()->first_name) }}"
                                            autocomplete="given-name" required>
                                        @error('first_name')
                                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="flex-1 flex flex-col gap-1.5">
                                        <label class="text-sm font-medium text-gray-700" for="ie-last-name">Last Name</label>
                                        <input class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm @error('last_name') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                            id="ie-last-name" type="text" name="last_name"
                                            value="{{ old('last_name', Auth::user()->last_name) }}"
                                            autocomplete="family-name" required>
                                        @error('last_name')
                                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 mt-2">
                                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition-colors">Save</button>
                                    <button type="button" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50 transition-colors" onclick="ieClose('name')">Cancel</button>
                                </div>
                            </form>
                        </div>

                    </div>

                    {{--  Row 2: Contact Details (inline edit)  --}}
                    <div class="px-6 py-5 border-b border-gray-100 last:border-0 flex flex-col md:flex-row gap-4" data-inline-field="email">

                        <div class="md:w-1/3 text-sm font-medium text-gray-700 md:mt-1">Contact Details</div>

                        {{-- Display slot: shown by default --}}
                        <div class="flex-1 text-sm text-gray-900 ie-display flex justify-between items-start w-full">
                            <div>
                                <div id="ie-display-email" class="mt-1">{{ Auth::user()->email }}</div>
                                <div class="text-sm text-gray-500 mt-1">Phone not added</div>
                            </div>
                            <button type="button" class="text-sm font-medium text-indigo-600 hover:text-indigo-700 transition-colors mt-1" onclick="ieOpen('email')">Edit</button>
                        </div>

                        {{-- Editor slot: hidden by default --}}
                        <div class="flex-1 ie-editor w-full" id="ie-editor-email" style="display:none;">
                            <form method="POST" action="{{ route('profile.update') }}" class="flex flex-col gap-4 w-full" data-field="email">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="inline_field" value="email">
                                <div class="w-full sm:max-w-md">
                                    <div class="flex flex-col gap-1.5">
                                        <label class="text-sm font-medium text-gray-700" for="ie-email">Email Address</label>
                                        <input class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm @error('email') border-red-500 focus:ring-red-500 focus:border-red-500 @enderror"
                                            id="ie-email" type="email" name="email"
                                            value="{{ old('email', Auth::user()->email) }}" autocomplete="email"
                                            required>
                                        @error('email')
                                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 mt-2">
                                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition-colors">Save</button>
                                    <button type="button" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50 transition-colors" onclick="ieClose('email')">Cancel</button>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8 overflow-hidden">
                    <h3 class="px-6 py-4 border-b border-gray-200 text-lg font-semibold text-gray-900 bg-gray-50/50">Shipping &amp; Billing</h3>

                    {{-- Row 3: Shipping Address --}}
                    <div class="px-6 py-5 border-b border-gray-100 last:border-0 flex flex-col md:flex-row gap-4">
                        <div class="md:w-1/3 text-sm font-medium text-gray-700 md:mt-1">Default Address</div>
                        <div class="flex-1 text-sm text-gray-900 leading-relaxed">
                            <template x-if="defaultAddressHtml">
                                <div x-html="defaultAddressHtml"></div>
                            </template>
                            <template x-if="!defaultAddressHtml">
                                <span class="text-gray-400 italic">No address saved</span>
                            </template>
                        </div>
                        <div class="md:text-right">
                            <button type="button" class="text-sm font-medium text-indigo-600 hover:text-indigo-700 transition-colors md:mt-1"
                                onclick="openModal('modal-address')"><span x-text="defaultAddressHtml ? 'Edit' : 'Add'"></span></button>
                        </div>
                    </div>

                    {{-- Row 4: Language & Currency --}}
                    <div class="px-6 py-5 border-b border-gray-100 last:border-0 flex flex-col md:flex-row gap-4">
                        <div class="md:w-1/3 text-sm font-medium text-gray-700 md:mt-1">Preferences</div>
                        <div class="flex-1 text-sm text-gray-900 leading-relaxed">
                            English (US)<br>
                            USD ($)
                        </div>
                        <div class="md:text-right">
                            <button type="button" class="text-sm font-medium text-indigo-600 hover:text-indigo-700 transition-colors md:mt-1">Edit</button>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8 overflow-hidden">
                    <h3 class="px-6 py-4 border-b border-gray-200 text-lg font-semibold text-gray-900 bg-gray-50/50">Security &amp; Integrations</h3>

                    {{-- Row 5: Connected Accounts --}}
                    <div class="px-6 py-5 border-b border-gray-100 last:border-0 flex flex-col md:flex-row md:items-center gap-4">
                        <div class="md:w-1/3 text-sm font-medium text-gray-700">Connected Accounts</div>
                        <div class="flex-1 text-sm text-gray-900 flex items-center gap-3">
                            <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                                    fill="#4285F4" />
                                <path
                                    d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                                    fill="#34A853" />
                                <path
                                    d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                                    fill="#FBBC05" />
                                <path
                                    d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                                    fill="#EA4335" />
                            </svg>
                            <span>Signed in with Google</span>
                        </div>
                        <div class="md:text-right">
                            <button type="button" class="text-sm font-medium text-indigo-600 hover:text-indigo-700 transition-colors">Manage</button>
                        </div>
                    </div>
                </div>

            </div>

            <div x-show="activeTab === 'security'" x-transition style="display: none;" class="max-w-4xl mx-auto w-full">
                @include('profile.security.index')
            </div>
        </main>
    </div>


    {{-- MODAL — Edit Profile Information (Retained for legacy if needed, but styling updated) --}}
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/50 backdrop-blur-sm opacity-0 invisible [&.active]:opacity-100 [&.active]:visible transition-all duration-300 group" id="modal-profile-info" role="dialog" aria-modal="true"
        aria-labelledby="modal-profile-info-title">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md transform transition-all duration-300 scale-95 opacity-0 group-[.active]:scale-100 group-[.active]:opacity-100 flex flex-col max-h-full">
            <div class="flex items-center justify-between p-6 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-900" id="modal-profile-info-title">Edit Profile</h2>
                <button class="text-gray-400 hover:text-gray-600 transition-colors" onclick="closeModal('modal-profile-info')" aria-label="Close">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
            </div>
            <div class="p-6 overflow-y-auto">
                @if (session('status') === 'profile-updated')
                    <div class="mb-6 p-4 rounded-lg bg-green-50 text-green-700 flex items-center gap-3 text-sm font-medium">
                        <svg class="w-5 h-5 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                        Profile updated successfully!
                    </div>
                @endif

                <form method="post" action="{{ route('profile.update') }}" id="form-profile-info" class="flex flex-col gap-5">
                    @csrf
                    @method('patch')

                    <div>
                        <x-floating-input id="first_name" name="first_name" type="text" label="First Name"
                            :value="old('first_name', Auth::user()->first_name)" required autofocus autocomplete="first_name" />
                        <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                    </div>

                    <div>
                        <x-floating-input id="last_name" name="last_name" type="text" label="Last Name"
                            :value="old('last_name', Auth::user()->last_name)" required autocomplete="last_name" />
                        <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
                    </div>

                    <div>
                        <x-floating-input id="email" name="email" type="email" label="Email"
                            :value="old('email', Auth::user()->email)" required autocomplete="username" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div class="flex items-center justify-end gap-3 mt-4 pt-4 border-t border-gray-100">
                        <button type="button" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50 transition-colors"
                            onclick="closeModal('modal-profile-info')">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition-colors">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>





    {{-- 
         MODAL — Payment Method (Coming Soon)
     --}}
    <x-profiles.modal id="modal-payment" title="Payment Method">
        <div class="text-center py-10 px-6">
            <div
                class="w-14 h-14 rounded-2xl bg-orange-100 flex items-center justify-center mx-auto mb-5 text-orange-600">
                <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"
                    stroke-linejoin="round">
                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2" />
                    <line x1="1" y1="10" x2="23" y2="10" />
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 m-0 mb-2">
                Coming Soon</h3>
            <p
                class="text-sm text-gray-500 m-0 mb-6 leading-relaxed">
                Payment method management is currently under development. We'll notify you when it's ready.</p>
            <button type="button" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition-colors w-full max-w-[180px] mx-auto block"
                onclick="closeModal('modal-payment')">Got it</button>
        </div>
    </x-profiles.modal>

    {{-- MODAL — Address Management (Full CRUD) --}}
    <x-address.address-modal />


    {{--  INLINE EDITING + MODAL JAVASCRIPT --}}
    @push('scripts')
        @vite(['resources/js/profile.js'])

        <script>
            // Auto-open modals if there are validation errors (password modal, etc.)
            @if ($errors->updatePassword->isNotEmpty())
                document.addEventListener('DOMContentLoaded', () => openModal('modal-password'));
            @endif

            // Auto-open if session status indicates recent update via the old modal flow
            @if (session('status') === 'password-updated')
                document.addEventListener('DOMContentLoaded', () => openModal('modal-password'));
            @endif

            // Auto-open address modal after address save
            @if (session('inline_field') === 'address')
                document.addEventListener('DOMContentLoaded', () => openModal('modal-address'));
            @endif
        </script>
    @endpush
</x-app-layout>

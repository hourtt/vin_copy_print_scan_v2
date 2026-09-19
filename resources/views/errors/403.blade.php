<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 - Forbidden | {{ config('app.name', 'Vin Copy Print Scan') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="min-h-full font-sans antialiased bg-slate-50 text-slate-800 flex flex-col justify-center items-center p-4 sm:p-6 lg:p-8 selection:bg-blue-500 selection:text-white">

    <main class="w-full max-w-xl mx-auto text-center flex flex-col items-center">

        <!-- Illustration Card -->
        <div class="relative w-full max-w-md sm:max-w-lg mb-8 overflow-hidden rounded-2xl shadow-xl shadow-slate-200/80 border border-slate-100 bg-white p-2">
            <img src="{{ asset('images/403-forbidden.jpg') }}" alt="403 Forbidden - Restricted Access"
                class="w-full h-auto object-cover rounded-2xl select-none" loading="eager" />
        </div>

        <!-- Headings & Content -->
        <div class="space-y-3 max-w-lg px-4">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                Bro....
            </h1>

            <p class="text-slate-600 text-base sm:text-lg leading-relaxed">
                The page you're trying to access has restricted access. Please refer to your system administrator.
            </p>

            @auth
                <div class="pb-3">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-medium border border-slate-200">
                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                        <span>Logged in as: <strong class="text-slate-800">{{ auth()->user()->email }}</strong>
                            ({{ ucfirst(auth()->user()->role ?? 'Customer') }})</span>
                    </div>
                </div>
            @endauth
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3 w-full sm:w-auto px-6">
            <!-- Rounded Blue Button: Go Back -->
            <button
                onclick="window.history.length > 1 ? window.history.back() : window.location.href='{{ url('/') }}'"
                type="button"
                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-full bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold text-base shadow-lg shadow-blue-600/25 hover:shadow-blue-600/35 transition-all duration-200 transform hover:-translate-y-0.5 focus:outline-none focus:ring-4 focus:ring-blue-500/30 cursor-pointer">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Go Back
            </button>
        </div>

    </main>

</body>

</html>

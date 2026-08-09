<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

{{-- *Default value for using in Login & Signup page [Pasts the title and subtitle inside the x-guest-layout]* --}}
@props(['title' => 'Welcome back','subtitle'=>'Sign in to manage your printing order and tracking your data'])

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col justify-center items-center p-5 bg-gray-100">
        <div class="mt-6 text-center">
            <div class="inline-flex items-center gap-3 text-xl font-medium px-3 py-1 rounded-fill mb-3">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500 rounded-fill" />
            </div>
            <div>
                <h1 class="text-2xl font-medium text-gray-900 font-bold">{{ $title }}</h1>
                <p class="mt-2 text-sm text-gray-500 max-w-xs mx-auto leading-relaxed">{{ $subtitle }}</p>
            </div>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden rounded-lg">
            {{ $slot }}
        </div>
    </div>
</body>

</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Services — {{ config('app.name', 'PrintCo') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fraunces:400,500,600,700,900i&family=dm-sans:300,400,500,600"
        rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/services.js'])
</head>

<body>

    {{-- Navigation --}}
    @include('layouts.navigation')

    {{-- PAGE HERO  --}}
    @include('components.services.page-hero')

    {{-- QUICK NAV --}}
    @include('components.services.quick-nav')

    {{-- PRODUCTS WE SELL --}}
    @include('components.services.product-we-sell')

    {{-- IN-STORE SERVICES --}}
    @include('components.services.in-store-services')

    {{-- VISIT US / LOCATION --}}
    @include('components.services.visit-us')

    {{-- WHY CHOOSE US --}}
    @include('components.services.why-choose-us')

    {{-- HOW IT WORKS / ORDERING PROCESS --}}
    @include('components.services.how-it-works')

    {{-- FAQ --}}
    @include('components.services.faq')
</body>

</html>

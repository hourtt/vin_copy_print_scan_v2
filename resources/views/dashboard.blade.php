<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'PrintCo') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fraunces:400,500,600,700,900i&family=dm-sans:300,400,500,600"
        rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased overflow-x-hidden w-full relative bg-white">
    {{-- NAVIGATION --}}
    @include('layouts.navigation')

    {{-- Cinematic Hero --}}
    @include('components.dashboard.cinematic-hero')

    {{-- POPULAR PRODUCTS --}}
    @if(isset($popular) && $popular->count())
        @include('components.dashboard.product-carousel', [
            'title' => 'Popular Products',
            'products' => $popular,
            'viewAllRoute' => route('product-catalog.index'),
            'badge' => 'Popular',
        ])
    @endif

    {{-- NEW ARRIVALS --}}
    @if(isset($newArrivals) && $newArrivals->count())
        @include('components.dashboard.product-grid-section', [
            'title' => 'New Arrivals',
            'products' => $newArrivals,
            'viewAllRoute' => route('product-catalog.index'),
            'columns' => 4,
        ])
    @endif

    {{-- HOT SALE --}}
    @if(isset($hotSale) && $hotSale->count())
        @include('components.dashboard.product-carousel', [
            'title' => 'Hot Sale',
            'products' => $hotSale,
            'viewAllRoute' => route('product-catalog.index'),
            'badge' => 'Sale',
        ])
    @endif

    {{-- FEATURED PRODUCTS --}}
    @include('components.dashboard.featured-products')

    {{-- FOOTER --}}
    @include('layouts.footer')

</body>

</html>

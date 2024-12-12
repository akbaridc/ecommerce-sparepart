<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'E-commerce Sparepart') }}</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.frontstore.partials.navbar')

        <div class="flex" x-data="{ show: true }">
            <!-- Sidebar -->
            @include('layouts.frontstore.partials.sidebar')

            <!-- Main Content -->
            <main class="flex-1 px-4 py-6" :class="show ? 'ml-[23%]' : ''">
                {{ $slot }}
            </main>
        </div>


        @if (session('alert-toast') && session('type') && session('message'))
            <x-toast.toast />
        @endif
    </div>
</body>

</html>

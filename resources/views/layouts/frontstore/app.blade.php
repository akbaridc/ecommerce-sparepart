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

    <!-- Font Awwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
        integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

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
            <main class="flex-1 px-4 py-6" :class="show ? 'ml-[17%]' : ''">
                {{ $slot }}
            </main>
        </div>

        {{-- chat customer services --}}
        <div class="hidden md:block fixed bottom-[5.5rem] right-[4.5rem]">
            <div class="flex flex-col items-center justify-center">
                <figure class="mb-4">
                    <img src="{{ asset('image/checkin.gif') }}" class="w-20 h-20" alt="checkin sekarang">
                </figure>
                <a href="https://api.whatsapp.com/send?phone=6283111693720&text=Hi%20Belanjaparts,%20saya%20ingin%20membeli%20spareparts."
                    target="_blank"
                    class="flex items-center justify-center bg-green-500 text-white p-4 rounded-full w-12 h-12 shadow-lg">
                    <i class="fa-brands fa-whatsapp text-3xl"></i>
                </a>
            </div>
        </div>

        @if (session()->get('alert-toast'))
            <x-toast.toast />
        @endif
    </div>
</body>

</html>

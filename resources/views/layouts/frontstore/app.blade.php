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

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.frontstore.partials.navbar')

        <div class="flex" x-data="{show: false}">
            <!-- Sidebar -->
            <span x-show="false" class="btn btn-md btn-secondary btn-circle absolute left-0 top-1/2 z-40" @click="show = !show">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-base">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </span>

            <span x-show="true" class="btn btn-md btn-secondary btn-circle absolute left-[23rem] top-1/2 z-40" @click="console.log('oke')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-base">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
            </span>

            <!-- Sidebar -->
            <aside x-show="show" x-transition class="w-[23%] min-h-screen bg-gray-200 text-primary p-4 flex flex-col fixed top-15 left-0 h-full">
                <div class="text-center">
                    <h1 class="font-bold text-2xl">Pilih Kategori</h1>
                    <div class="divider"></div>
                </div>
                <!-- Navigation Menu -->
                <nav class="flex-1 overflow-y-auto h-full p-4 pb-14">
                    <ul class="space-y-2">
                        <li>
                            <a href="#dashboard" class="nav-item active">
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="#profile" class="nav-item">
                                <span>Profile</span>
                            </a>
                        </li>
                        <li>
                            <a href="#settings" class="nav-item">
                                <span>Settings</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 p-4" :class="show ? 'ml-[23%]' : ''">
                {{ $slot }}
            </main>
        </div>


        @if (session('alert-toast') && session('type') && session('message'))
            <x-toast.toast />
        @endif
    </div>
</body>

</html>

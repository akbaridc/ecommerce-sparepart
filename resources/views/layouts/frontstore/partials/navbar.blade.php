{{-- content download aplikasi --}}
@if (!request()->routeIs('frontstore.akun'))
    <div class="md:hidden flex justify-between items-center w-full p-2 bg-[#066043]">
        <div class="flex items-center gap-2">
            <figure>
                <img src="{{ asset('image/logo.png') }}" class="w-10 h-10" alt="logo">
            </figure>
            <div class="flex flex-col text-white text-sm">
                <span class="font-bold">Belanjaparts</span>
                <span>Belanja mudah di aplikasi Belanjaparts</span>
            </div>
        </div>

        <div>
            <a href="https://play.google.com/store/apps/details?id=com.belanjaparts" target="_blank"
                class="py-1 px-2 bg-white rounded text-slate-600 text-sm">Buka</a>
        </div>
    </div>
@endif



<div class="navbar bg-primary-500 gap-3 p-3 items-center sticky top-0 z-[999]" x-data="{ isLogin: false }">
    <a href="{{ route('frontstore.homepage') }}" class="hidden w-[17%] md:flex justify-center">
        <img src="{{ asset('image/logo.jpg') }}" alt="" class="w-[100% - 200px] h-16">
    </a>
    <div class="flex justify-between gap-2 w-full md:w-[80%]">
        <div class="join w-[90%] md:w-[65%]">
            <button class="btn btn-sm join-item rounded-r-full bg-gray-50 hover:bg-gray-100"
                x-on:click="window.location.href = '{{ route('frontstore.homepage') }}?search=' + $refs.searchInput.value">
                <i class="fa-solid fa-magnifying-glass text-md text-gray-400"></i>
            </button>
            <input x-ref="searchInput"
                class="input input-bordered input-sm join-item w-full focus:outline-0 focus:outline-transparent focus:outline-none focus:outline-offset-0"
                placeholder="Cari Produk"
                x-on:keydown.enter="window.location.href = '{{ route('frontstore.homepage') }}?search=' + $event.target.value" />
        </div>
        {{-- <div class="form-control w-[55%]">
            <input type="text" placeholder="type and enter ..." class="w-24 input input-bordered md:w-auto"
                x-on:keydown.enter="window.location.href = '{{ route('frontstore.homepage') }}?search=' + $event.target.value" />
        </div> --}}
        <div class="flex justify-end gap-4 items-center">

            <x-button.success-button
                class="hidden md:inline-block bg-primary-500 brightness-125 hover:bg-primary-500 hover:brightness-125 border-transparent focus:ring-offset-0 focus:ring-transparent focus:ring-0 active:bg-transparent w-52 align-middle">
                {{ __('Aktifkan Lokasi') }}
            </x-button.success-button>

            {{-- Shopping Cart --}}
            <div class="shopping-cart indicator cursor-pointer tooltip tooltip-bottom" data-tip="Carts"
                x-on:click="window.location.href = '{{ route('frontstore.cart') }}'">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-8 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                </svg>
            </div>


            {{-- Notification --}}
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="hidden md:inline-block size-8 text-white cursor-pointer m-0">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
            </svg>


            <button
                class="hidden md:inline-flex items-center justify-center px-5 py-1 rounded bg-yellow-300 text-primary font-bold"
                x-show="!isLogin">{{ __('Login') }}</button>

            <div class="dropdown dropdown-end" x-show="isLogin">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                    <div class="w-10 rounded-full">
                        <img alt="Tailwind CSS Navbar component"
                            src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
                    </div>
                </div>
                <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded z-[1] mt-2 w-52 p-2 shadow">
                    <li><a>Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

@include('layouts.frontstore.partials.navbar-bottom')

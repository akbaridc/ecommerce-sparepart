<x-app-front-layout>
    <div class="mx-auto max-w-full sm:px-6 lg:px-8">
        <div class="overflow-hidden p-6 text-gray-900 bg-white shadow-sm sm:rounded-lg">
            <div>
                <p class="text-sm">Jadilah member dan nikmati keuntungannya</p>
                <div class="flex justify-between mt-4">
                    <button
                        class="flex items-center justify-center px-5 py-3 border border-gray-200 rounded bg-white text-primary font-bold">{{ __('Masuk') }}</button>

                    <button
                        class="flex items-center justify-center px-5 py-3 rounded border-gray-200 bg-yellow-300 text-primary font-bold">{{ __('Daftar') }}</button>
                </div>
            </div>
            <div class="divider"></div>
            <div class="mt-4 flex justify-between">
                <div class="flex items-center gap-3 w-4/5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" color="#01573e" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                    </svg>

                    <p>Lokasi</p>
                </div>
                <div>
                    <p>Surabaya</p>
                </div>
            </div>
        </div>
    </div>
</x-app-front-layout>

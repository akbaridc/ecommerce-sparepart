<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-wrap gap-3">
                <div class="w-full md:w-[24%] mb-2">
                    <x-card.count-card color="bg-red-300" title="categories" count="{{ $totalCategory }}"
                        icon="fa-regular fa-rectangle-list" />
                </div>

                <div class="w-full md:w-[24%] mb-2">
                    <x-card.count-card color="bg-cyan-300" title="products" count="{{ $totalProduct }}"
                        icon="fa-solid fa-boxes-stacked" />
                </div>

                <div class="w-full md:w-[24%] mb-2">
                    <x-card.count-card color="bg-yellow-300" title="banners" count="{{ $totalBanner }}"
                        icon="fa-solid fa-bandage" />
                </div>

                <div class="w-full md:w-[24%] mb-2">
                    <x-card.count-card color="bg-green-300" title="transaction" count="{{ $totalTransaction }}"
                        icon="fa-solid fa-dollar-sign" />
                </div>
            </div>

            <div class="flex flex-wrap gap-3 mt-4">
                <div class="w-full md:w-[49%]">
                    <div class="card shadow-md bg-white rounded-md min-h-30 max-h-30">
                        <div class="card-body py-2 px-4">
                            <div>
                                <h5 class="font-bold text-gray-600">Total Daily Sales</h5>
                            </div>
                            <div class="mt-2 mb-4 text-center">
                                <span class="text-2xl font-semibold text-gray-600">Rp.
                                    {{ formatRupiah($sales['transactionDaily']) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-[49%] ms-auto">
                    <div class="card shadow-md bg-white rounded-md min-h-30 max-h-30">
                        <div class="card-body py-2 px-4">
                            <div>
                                <h5 class="font-bold text-gray-600">Total Week Sales</h5>
                            </div>
                            <div class="mt-2 mb-4 text-center">
                                <span class="text-2xl font-semibold text-gray-600">Rp.
                                    {{ formatRupiah($sales['transactionWeek']) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-[49%] ">
                    <div class="card shadow-md bg-white rounded-md min-h-30 max-h-30">
                        <div class="card-body py-2 px-4">
                            <div>
                                <h5 class="font-bold text-gray-600">Total Monthly Sales</h5>
                            </div>
                            <div class="mt-2 mb-4 text-center">
                                <span class="text-2xl font-semibold text-gray-600">Rp.
                                    {{ formatRupiah($sales['transactionMonthly']) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-[49%] ms-auto">
                    <div class="card shadow-md bg-white rounded-md min-h-30 max-h-30">
                        <div class="card-body py-2 px-4">
                            <div>
                                <h5 class="font-bold text-gray-600">Total Year Sales</h5>
                            </div>
                            <div class="mt-2 mb-4 text-center">
                                <span class="text-2xl font-semibold text-gray-600">Rp.
                                    {{ formatRupiah($sales['transactionYear']) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-wrap gap-4">
                <div class="w-1/5">
                    <x-card.count-card color="red" title="categories" count="{{ $totalCategory }}"
                        icon="fa-regular fa-rectangle-list" />
                </div>

                <div class="w-1/5">
                    <x-card.count-card color="cyan" title="products" count="{{ $totalProduct }}"
                        icon="fa-solid fa-boxes-stacked" />
                </div>

                <div class="w-1/5">
                    <x-card.count-card color="blue" title="banners" count="{{ $totalBanner }}"
                        icon="fa-solid fa-bandage" />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

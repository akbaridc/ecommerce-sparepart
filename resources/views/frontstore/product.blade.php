<x-app-front-layout>
    <div class="mx-auto max-w-full sm:px-6 lg:px-8">
        <div class="overflow-hidden p-6 text-gray-900 bg-white shadow-sm sm:rounded-lg">
            <div>
                <figure>
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('image/no-image.jpg') }}"
                        class="w-full object-cover" alt="$product->name" />
                </figure>

                <div class="mt-4 lh-lg">
                    <h3 class="text-2xl font-semibold">{{ $product->name }} </h3>
                    <div class="flex gap-3 font-semibold text-md">
                        <p>Rp. {{ formatRupiah($product->price) }}</p>
                        <p class="text-gray-400">{{ formatRupiah($product->stock) }} pcs</p>
                    </div>
                    <p class="text-lg text-gray-500">{{ $product->description }}</p>
                    <div class="flex gap-5 mt-7">
                        <x-button.secondary-button
                            @click="window.history.back()">{{ __('Kembali') }}</x-button.secondary-button>

                        <x-button.success-button
                            @click="console.log('oke')">{{ __('Pesan') }}</x-button.success-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-front-layout>

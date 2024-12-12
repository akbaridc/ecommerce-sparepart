@props(['categoriesProducts'])

@if (request()->query('search'))
    <div class="mb-5">
        <h1 class="font-bold text-2xl">Hasil pencarian untuk "{{ request()->query('search') }}"</h1>
    </div>
@endif

@forelse ($categoriesProducts as $category)
    <div class="mt-2">
        <div class="border px-4 py-2 text-warning bg-primary max-w-fit rounded-md shadow relative">
            <div
                class="p-3 rounded-full max-w-fit bg-primary absolute -left-3 -top-1 border border-primary ring-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                </svg>
            </div>
            <h3 class="font-bold ml-7">{{ $category->name }}</h3>
        </div>
        <div class="flex mt-6 gap-3">
            @forelse ($category->product as $product)
                <div class="w-1/5 card bg-base-100 shadow-xl hover:shadow-2xl hover:scale-105">
                    <figure
                        @click="window.location.href = '{{ route('frontstore.product', ['slug' => $category->slug, 'productSlug' => $product->slug]) }}'"
                        class="cursor-pointer">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('image/no-image.jpg') }}"
                            class="w-full h-40 object-cover" alt="$product->name" />
                    </figure>
                    <div class="card-body p-3 lh-sm">
                        <h3 class="card-title text-lg cursor-pointer"
                            @click="window.location.href = '{{ route('frontstore.product', ['slug' => $category->slug, 'productSlug' => $product->slug]) }}'">
                            {{ \Illuminate\Support\Str::limit($product->name, 20) }}</h3>
                        <div class="flex justify-between font-semibold">
                            <small>Rp. {{ number_format($product->price, 0, ',', '.') }}</small>
                            <small>{{ $product->stock }} pcs</small>
                        </div>
                        <p class="text-sm text-gray-500">
                            {{ \Illuminate\Support\Str::limit($product->short_description, 50) }}
                        </p>

                        <x-button.success-button class="mt-3 w-full" x-data=""
                            @click="console.log('oke')">{{ __('Pesan') }}</x-button.success-button>
                    </div>
                </div>
            @empty
                <div class="w-full flex flex-col justify-center items-center">
                    <figure>
                        <img src="{{ asset('image/empty.png') }}" class="w-30 h-24 text-center" alt="Empty" />
                    </figure>
                    <h3 class="font-semibold text-center">Data Kosong</h3>
                </div>
            @endforelse
        </div>
    </div>
    <div class="divider"></div>
@empty
    <div class="w-full flex flex-col justify-center items-center">
        <figure>
            <img src="{{ asset('image/no-data.png') }}" class="w-30 h-24 text-center" alt="no data" />
        </figure>
        <h3 class="font-semibold text-center">Produk Tidak Tersedia</h3>
    </div>
@endforelse

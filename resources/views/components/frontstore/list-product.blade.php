@props(['categoriesProducts'])

@if (request()->query('search'))
    <div class="mb-5">
        <h1 class="font-bold text-2xl">Hasil pencarian untuk "{{ request()->query('search') }}"</h1>
    </div>
@endif

@forelse ($categoriesProducts as $index => $category)
    <div class="card mb-6"
        style="background-image: url('{{ $index % 2 == 0 ? asset('image/bg-yellow-fronstore.png') : asset('image/bg-green-fronstore.png') }}');">
        <div class="card-body">
            <div class="label-section flex items-center max-w-fit min-w-fit">
                <div class="triangle mt-3 mb-0 mx-3 bg-primary relative pl-9 pr-5 h-8 -skew-x-[30deg]">
                    <div class="label-content flex items-center skew-x-[30deg]">
                        <div
                            class="label-icon p-2 rounded-full max-w-fit bg-white absolute -left-14 -top-[0.65em] border-2 border-gray-400 ring-primary">
                            <figure>
                                <img src="{{ asset('storage/' . $category->icon) }}" class="w-8 h-8"
                                    alt="{{ $category->name }}" />
                            </figure>
                        </div>
                        <div class="label-title text-yellow-400 font-bold tracking-wider ml-2 mt-1">
                            {{ $category->name }}
                        </div>
                    </div>
                </div>
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
                        <h1 class="text-2xl font-semibold text-center">Data Kosong</h1>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@empty
    <div class="card bg-white w-full p-8">
        <div class="w-full flex flex-col justify-center items-center">
            <figure>
                <img src="{{ asset('image/no-data.png') }}" class="w-40 h-30 text-center" alt="no data" />
            </figure>
            <h3 class="font-semibold text-center">Produk Tidak Tersedia</h3>
        </div>
    </div>
@endforelse

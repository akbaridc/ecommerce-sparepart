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
                <div class="triangle mt-3 mb-0 mx-3 bg-primary-500 relative pl-9 pr-5 h-8 -skew-x-[30deg]">
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

            <div class="flex flex-wrap mt-6 gap-2 md:gap-4">
                @forelse ($category->product as $product)
                    <div class="w-full sm:w-[48%] md:w-1/5 card bg-base-100 shadow-xl hover:shadow-2xl hover:scale-105">
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
                            <div class="font-semibold">
                                @if ($product->discount > 0)
                                    <div class="flex flex-col">
                                        <p class="text-red-400 text-xl">
                                            Rp.
                                            {{ formatRupiah($product->price - ($product->price * $product->discount) / 100) }}
                                        </p>
                                        <div class="flex gap-2">
                                            <s class="text-xs text-gray-500">Rp.
                                                {{ formatRupiah($product->price) }}</s>
                                            <small>- {{ formatRupiah($product->discount) }}%</small>
                                        </div>

                                    </div>
                                @else
                                    <p class="text-xl">Rp. {{ formatRupiah($product->price) }}</p><br>
                                @endif

                            </div>

                            <p class="text-sm text-gray-500">
                                {{ \Illuminate\Support\Str::limit($product->short_description, 50) }}
                            </p>

                            <div class="mt-3 flex justify-between items-center">
                                <small class="text-gray-500">Stock {{ formatRupiah($product->stock) }} pcs</small>

                                <div>
                                    <button class="tooltip tooltip-bottom" data-tip="Add to cart">
                                        <i class="fa fa-shopping-cart me-2 text-2xl text-green-400 cursor-pointer"
                                            @click="addToCart('{{ $product->id }}', '{{ $product->name }}', '{{ $product->price }}', '{{ $product->discount }}'); setLabelCarts(); showToast('success', 'Product added to cart')"></i>
                                    </button>

                                </div>
                            </div>

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

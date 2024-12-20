<x-app-front-layout>
    <div class="mx-auto max-w-full sm:px-6 lg:px-8">
        <div class="overflow-hidden p-6 text-gray-900 bg-white shadow-sm sm:rounded-lg">
            <div class="flex flex-wrap gap-3">
                <div class="w-[20%]">
                    <figure>
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('image/no-image.jpg') }}"
                            class="w-full object-cover h-60" alt="$product->name" />
                    </figure>
                </div>

                <div class="lh-lg w-[77%]" x-data="{ quantity: 1, stock: {{ $product->stock }} }">
                    <h3 class="text-3xl font-semibold">{{ $product->name }} </h3>
                    <div class="flex gap-1 mt-1 text-gray-400">
                        {{-- <div>0 Ulasan</div>
                        <div class="divider divider-horizontal"></div>
                        <div>0 Terjual</div>
                        <div class="divider divider-horizontal"></div> --}}
                        <div>Kategori : {{ $product->category->name }}</div>
                    </div>
                    <div class="mt-2 rounded py-3 px-2 bg-gray-50 w-full">
                        @if ($product->discount > 0)
                            <div class="flex items-center gap-2">
                                <s class="text-gray-500">Rp. {{ formatRupiah($product->price) }}</s>
                                <p class="text-2xl text-red-400">
                                    Rp.
                                    {{ formatRupiah($product->price - ($product->price * $product->discount) / 100) }}
                                </p>
                                <div class="bg-red-200 text-red-500 p-1 font-bold rounded">- {{ $product->discount }} %
                                </div>
                            </div>
                        @else
                            <p class="text-2xl">Rp. {{ formatRupiah($product->price) }}</p>
                        @endif
                    </div>
                    <div class="flex items-center gap-4 mt-3">
                        <div class="flex items-center gap-2">
                            <span class="font-medium">Qty</span>
                            <div class="flex items-center border rounded-md shadow">
                                <button class="btn btn-sm btn-ghost disabled:bg-transparent disabled:cursor-not-allowed"
                                    :disabled="quantity <= 1"
                                    @click="quantity > 1 ? quantity-- : quantity = 1">-</button>
                                <input type="text" id="quantity" x-model="quantity"
                                    class="w-12 numeric text-center border-0 focus:shadow-transparent focus:outline-0 focus:outline-transparent focus:outline-none focus:outline-offset-0" />
                                <button class="btn btn-sm btn-ghost" :disabled="quantity >= stock"
                                    @click="quantity++">+</button>
                            </div>
                        </div>
                        <span class="text-gray-400 text-sm">Stock {{ formatRupiah($product->stock) }}</span>
                    </div>
                    <div class="flex gap-3 my-5">
                        <x-button.info-button class="py-3"
                            @click="updateCart('{{ $product->id }}', 'button', quantity, '{{ $product->name }}','{{ $product->price }}','{{ $product->discount }}');setLabelCarts();showToast('success', 'Product added to cart')">
                            <i class="fa fa-shopping-cart me-2"></i>
                            {{ __('Add to Cart') }}</x-button.info-button>
                        <x-button.success-button class="py-3"
                            @click="updateCart('{{ $product->id }}', 'button', quantity, '{{ $product->name }}','{{ $product->price }}','{{ $product->discount }}');setLabelCarts();window.location.href = '{{ route('frontstore.cart') }}'">
                            <i class="fa-solid fa-dollar-sign me-2"></i>
                            {{ __('Buy Now') }}</x-button.success-button>
                    </div>
                    <article class="mt-4">
                        <h6 class="font-semibold">Description Product</h6>
                        <p class="mt-2 text-sm text-gray-500">{{ $product->description }}</p>
                    </article>
                </div>
            </div>
        </div>
    </div>
</x-app-front-layout>

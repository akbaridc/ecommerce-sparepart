<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="card bg-white p-5">
                <div class="card-title">
                    <h3 class="text-slate-900">{{ request()->routeIs('backoffice.product.show') ? 'Show' : 'Form' }}
                        Product
                    </h3>
                    <x-button.secondary-button x-data=""
                        x-on:click="window.location.href = '{{ route('backoffice.product.index') }}'"
                        class="ml-auto">{{ __('Back') }}</x-button.secondary-button>
                </div>
                <div class="card-body">
                    <form method="post"
                        action="{{ isset($product) ? route('backoffice.product.update', $product->id) : route('backoffice.product.store') }}"
                        enctype="multipart/form-data" class="p-6">
                        @csrf

                        @if (isset($product))
                            @method('PUT')
                        @endif

                        <div class="flex flex-wrap gap-2">

                            @if (!request()->routeIs('backoffice.product.show'))
                                <div class="mb-2 w-[48%]">
                                    <x-input-label for="category_id" value="{{ __('Category') }}" />
                                    <x-input.select id="category_id" name="category_id" class="mt-1 block w-full">
                                        @if ($categories)
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ isset($product) && $product->category_id == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}</option>
                                            @endforeach
                                        @endif
                                    </x-input.select>
                                    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                                </div>

                                <div class="mb-2 w-[48%]">
                                    <x-input-label for="name" value="{{ __('Product Name') }}" />
                                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                        placeholder="{{ __('Product Name') }}"
                                        value="{{ isset($product) && $product->name ? $product->name : '' }}" />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div class="mb-2 w-full">
                                    <x-input-label for="description" value="{{ __('Description') }}" />
                                    <x-input.textarea id="description" name="description" cols="10" rows="3"
                                        class="mt-1 block w-full"
                                        placeholder="{{ __('Description') }}">{{ isset($product) && $product->description ? $product->description : '' }}</x-input.textarea>
                                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                </div>

                                <div class="mb-2 w-full">
                                    <x-input-label for="short_description" value="{{ __('Short Description') }}" />
                                    <x-input.textarea id="short_description" name="short_description" cols="10"
                                        rows="1" class="mt-1 block w-full"
                                        placeholder="{{ __('Short Description') }}">{{ isset($product) && $product->short_description ? $product->short_description : '' }}</x-input.textarea>
                                    <x-input-error :messages="$errors->get('short_description')" class="mt-2" />
                                </div>

                                <div class="mb-2 w-[32%]">
                                    <x-input-label for="price" value="{{ __('Price') }}" />
                                    <x-text-input id="price" name="price" type="text" class="mt-1 block w-full"
                                        inputmode="decimal" pattern="[0-9]*" placeholder="{{ __('Price') }}"
                                        value="{{ isset($product) && $product->price ? $product->price : '' }}" />
                                    <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                </div>

                                <div class="mb-2 w-[32%]">
                                    <x-input-label for="stock" value="{{ __('Stock') }}" />
                                    <x-text-input id="stock" name="stock" type="text" class="mt-1 block w-full"
                                        inputmode="decimal" pattern="[0-9]*" placeholder="{{ __('Stock') }}"
                                        value="{{ isset($product) && $product->stock ? $product->stock : '' }}" />
                                    <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                                </div>

                                <div class="mb-2 w-[32%]">
                                    <x-input-label for="image" value="{{ __('Product Image') }}" /> <span
                                        class="text-sm">{{ isset($product) ? 'Abaikan jika tidak dirubah' : '' }}</span>
                                    <x-text-input id="image" name="image" type="file"
                                        class="mt-1 block w-full file-input file-input-bordered" accept="image/*"
                                        placeholder="{{ __('Product Image') }}" />
                                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                                </div>
                            @else
                                <div class="mb-2 w-[48%]">
                                    <x-input-label for="category" value="{{ __('Category') }}" class="mb-3" />
                                    <p class="text-gray-500">{{ $product->category->name }}</p>
                                </div>

                                <div class="mb-2 w-[48%]">
                                    <x-input-label for="name" value="{{ __('Product Name') }}" class="mb-3" />
                                    <p class="text-gray-500">{{ $product->name }}</p>
                                </div>

                                <div class="mb-2 w-full">
                                    <x-input-label for="description" value="{{ __('Description') }}" class="mb-3" />
                                    <p class="text-gray-500">{{ $product->description }}</p>
                                </div>

                                <div class="mb-2 w-full">
                                    <x-input-label for="short_description" value="{{ __('Short Description') }}"
                                        class="mb-3" />
                                    <p class="text-gray-500">{{ $product->short_description }}</p>
                                </div>

                                <div class="mb-2 w-[48%]">
                                    <x-input-label for="price" value="{{ __('Price') }}" class="mb-3" />
                                    <p class="text-gray-500">{{ $product->price }}</p>
                                </div>

                                <div class="mb-2 w-[48%]">
                                    <x-input-label for="stock" value="{{ __('Stock') }}" class="mb-3" />
                                    <p class="text-gray-500">{{ $product->stock }}</p>
                                </div>

                                <div class="mb-2 w-full">
                                    <x-input-label for="image" value="{{ __('Product Image') }}"
                                        class="mb-3" />
                                    <div class="w-35">
                                        @if ($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" />
                                        @endif
                                    </div>
                                </div>
                            @endif

                        </div>

                        <div class="mt-3 flex justify-end">
                            @if (!request()->routeIs('backoffice.product.show'))
                                <x-button.success-button type="submit" class="ms-3">
                                    {{ __('Submit') }}
                                </x-button.success-button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

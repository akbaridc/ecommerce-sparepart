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
                    @if (!request()->routeIs('backoffice.product.show'))
                        <div x-data="productForm" x-init="init()">
                            <form method="post"
                                action="{{ isset($product) ? route('backoffice.product.update', $product->id) : route('backoffice.product.store') }}"
                                enctype="multipart/form-data" class="p-6" x-ref="productForm">
                                @csrf

                                @if (isset($product))
                                    @method('PUT')
                                @endif

                                <div class="flex flex-wrap gap-2">
                                    <div class="mb-2 w-[30%]">
                                        <x-input-label for="category_id" value="{{ __('Category') }}" />
                                        <x-text-input id="category_id" name="category_id" type="hidden" class="mt-1"
                                            x-model="dataProduct.category" />

                                        <div class="relative w-full">
                                            <x-text-input id="category_display" name="category_display" type="text"
                                                x-model="dataDisplay.category" x-on:input="searchCategory()"
                                                class="mt-1" />
                                            <template x-if="dataDisplay.category && filteredCategories.length > 0">
                                                <div
                                                    class="absolute shadow-xl w-full min-h-48 max-h-48 bg-white z-10 border border-gray-300 mt-1 rounded overflow-y-auto">
                                                    <ul>
                                                        <template x-for="item in filteredCategories">
                                                            <li class="px-4 py-2 hover:bg-gray-200 cursor-pointer"
                                                                x-on:click="selectCategory(item)">
                                                                <span x-text="item.name"></span>
                                                            </li>
                                                        </template>
                                                    </ul>
                                                </div>
                                            </template>
                                        </div>
                                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                                    </div>

                                    <div class="mb-2 w-[34%]">
                                        <x-input-label for="name" value="{{ __('Product Name') }}" />
                                        <x-text-input id="name" name="name" type="text" class="mt-1"
                                            placeholder="{{ __('Product Name') }}" x-model="dataProduct.name"
                                            x-on:keyup="generateSlug()" />
                                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                    </div>

                                    <div class="mb-2 w-[34%]">
                                        <x-input-label for="slug">
                                            {{ __('Slug') }} <small
                                                class="text-xs text-gray-500">{{ __('Auto Generated from Product Name') }}</small>
                                        </x-input-label>
                                        <x-text-input id="slug" name="slug" type="text"
                                            class="mt-1 block w-full"
                                            placeholder="{{ __('Auto Generated from Product Name') }}"
                                            x-model="dataProduct.slug" :readonly="true" />
                                        <x-input-error x-show="slug.error" :messages="$errors->get('slug')" class="mt-2" />
                                    </div>

                                    <div class="mb-2 w-full">
                                        <x-input-label for="description" value="{{ __('Description') }}" />
                                        <x-input.textarea id="description" name="description" cols="10"
                                            rows="3" class="mt-1" placeholder="{{ __('Description') }}"
                                            x-text="dataProduct.description"></x-input.textarea>
                                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                                    </div>

                                    <div class="mb-2 w-full">
                                        <x-input-label for="short_description" value="{{ __('Short Description') }}" />
                                        <x-input.textarea id="short_description" name="short_description" cols="10"
                                            rows="1" class="mt-1" placeholder="{{ __('Short Description') }}"
                                            x-text="dataProduct.short_description"></x-input.textarea>
                                        <x-input-error :messages="$errors->get('short_description')" class="mt-2" />
                                    </div>

                                    <div class="mb-2 w-[32%]">
                                        <x-input-label for="price" value="{{ __('Price') }}" />
                                        <x-text-input id="price" name="price" type="hidden" class="mt-1"
                                            x-model="dataProduct.price" />
                                        <x-text-input id="price_display" name="price_display" type="text"
                                            class="mt-1" placeholder="{{ __('Price') }}"
                                            x-model="dataDisplay.price" x-on:input="patternNumeric('price')" />
                                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                    </div>

                                    <div class="mb-2 w-[32%]">
                                        <x-input-label for="stock" value="{{ __('Stock') }}" />
                                        <x-text-input id="stock" name="stock" type="hidden" class="mt-1"
                                            x-model="dataProduct.stock" />
                                        <x-text-input id="stock_display" name="stock_display" type="text"
                                            class="mt-1" placeholder="{{ __('Stock') }}"
                                            x-model="dataDisplay.stock" x-on:input="patternNumeric('stock')" />
                                        <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                                    </div>

                                    <div class="mb-2 w-[32%]">
                                        <x-input-label for="image">
                                            {{ __('Product Image') }} <small
                                                class="text-xs text-gray-500">{{ isset($product) ? __('Ignore if not changed') : '' }}</small>
                                        </x-input-label>
                                        <x-input.file-input id="image" name="image" class="mt-1 block w-full"
                                            accept="image/*" placeholder="{{ __('Product Image') }}"
                                            x-model="dataProduct.image" />
                                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="mt-3 flex justify-end">
                                    <x-button.success-button type="submit" class="ms-3">
                                        {{ __('Submit') }}
                                    </x-button.success-button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="flex flex-wrap gap-2">
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
                                <p class="text-gray-500">Rp. {{ formatRupiah($product->price) }}</p>
                            </div>

                            <div class="mb-2 w-[48%]">
                                <x-input-label for="stock" value="{{ __('Stock') }}" class="mb-3" />
                                <p class="text-gray-500">{{ formatRupiah($product->stock) }} Pcs </p>
                            </div>

                            <div class="mb-2 w-full">
                                <x-input-label for="image" value="{{ __('Product Image') }}" class="mb-3" />
                                <div class="w-35">
                                    @if ($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" />
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('productForm', () => ({
                    action: null,
                    isEdit: false,
                    dataProduct: {
                        category: '{{ old('category_id', isset($product) && $product->category_id ? $product->category_id : '') }}',
                        name: '{{ old('name', isset($product) && $product->name ? $product->name : '') }}',
                        slug: '{{ old('slug', isset($product) && $product->slug ? $product->slug : '') }}',
                        description: '{{ old('description', isset($product) && $product->description ? $product->description : '') }}',
                        short_description: '{{ old('short_description', isset($product) && $product->short_description ? $product->short_description : '') }}',
                        price: '{{ old('price', isset($product) && $product->price ? $product->price : '') }}',
                        stock: '{{ old('stock', isset($product) && $product->stock ? $product->stock : '') }}',
                        image: '{{ old('image') ?? '' }}',
                    },
                    dataDisplay: {
                        category: '{{ old('category_display') }}',
                        price: '{{ old('price_display') }}',
                        stock: '{{ old('stock_display') }}',
                    },
                    listCategory: @json($categories),
                    filteredCategories: [],

                    searchCategory() {
                        const searchTerm = this.dataDisplay.category.toLowerCase();
                        this.filteredCategories = this.listCategory.filter(category =>
                            category.name.toLowerCase().includes(searchTerm)
                        );
                    },

                    selectCategory(category) {
                        this.dataProduct.category = category.id;
                        this.dataDisplay.category = category.name;
                        this.filteredCategories = [];
                    },

                    generateSlug() {
                        this.dataProduct.slug = this.dataProduct.name
                            .toLowerCase()
                            .trim()
                            .replace(/[^a-z0-9\s-]/g, '')
                            .replace(/\s+/g, '-')
                            .replace(/-+/g, '-');
                    },

                    patternNumeric(field) {
                        const input = this.dataDisplay[field];
                        this.dataDisplay[field] = this.formatCurrency(input);

                        this.dataProduct[field] = this.reformatNumber(field);
                    },

                    formatCurrency(nominal) {
                        return nominal.replace(/[^\d]+/g, "")
                            .replace(/(\d{1,3})(?=(\d{3})+(?!\d))/g, "$1.")
                    },

                    onSubmit(event) {
                        event.preventDefault();

                        console.log('mantap');
                        return;


                        const form = this.$refs.productForm;
                        form.action = this.action;
                        form.submit();
                    },

                    reformatNumber(field) {
                        const nominal = this.dataDisplay[field].replace(/[.]/g, '');
                        return nominal ? parseInt(nominal) : '';
                    },

                    init() {
                        @if (!request()->routeIs('backoffice.product.show'))
                            @if (request()->routeIs('backoffice.product.edit') && isset($product))
                                this.action = '{{ route('backoffice.product.update', $product->id) }}';
                                this.isEdit = true;

                                this.dataDisplay = {
                                    category: '{{ $product->category->name }}',
                                    price: this.formatCurrency('{{ $product->price }}'),
                                    stock: this.formatCurrency('{{ $product->stock }}'),
                                }
                            @else
                                this.action = '{{ route('backoffice.product.store') }}';
                                this.isEdit = false;
                            @endif
                        @endif
                    },
                }));
            });
        </script>
    @endpush
</x-app-layout>

<x-app-front-layout>
    <div class="mx-auto max-w-full sm:px-6 lg:px-8">
        <div class="flex flex-wrap gap-4" x-data="cartData">
            <div class="overflow-hidden p-6 text-gray-900 bg-white shadow-sm sm:rounded-lg w-[58%]">
                <div class="flex justify-between">
                    <h4>Your cart <span class="font-bold" x-text="'( ' + cart.length + ' items )'"></span></h4>
                    <x-button.warning-button x-on:click="window.location.href = '{{ route('frontstore.homepage') }}'">
                        <i class="fa-solid fa-arrow-left me-2"></i> {{ __('Back to Shopping') }}
                    </x-button.warning-button>
                </div>
                <div class="divider"></div>
                <div class="section-product"></div>
            </div>
            <div class="w-[40%] ms-auto">
                <div class="p-6 text-gray-900 bg-white shadow-sm sm:rounded-lg max-h-fit">
                    <h1 class="font-bold text-xl uppercase">{{ __('Summary Order') }}</h1>
                    <div class="divider"></div>
                    <table class="table border-separate">
                        <tr>
                            <td>Subtotal</td>
                            <td class="text-end"><span x-text="formatRupiah(subTotal)"></span></td>
                        </tr>
                        <tr>
                            <td>Discount</td>
                            <td class="text-red-400 text-end">-<span x-text="formatRupiah(discount)"></span></td>
                        </tr>
                        <tr>
                            <td>Grand Total</td>
                            <td class="text-end text-bold text-xl">Rp. <span
                                    x-text="formatRupiah(subTotal - discount)"></span></td>
                        </tr>
                    </table>
    
                    <div class="mt-5 text-end">
                        <x-button.success-button x-on:click="window.location.href = '{{ route('frontstore.checkout') }}'">
                            {{ __('Checkout') }}
                        </x-button.success-button>
                    </div>
                </div>

                <div class="mt-5">
                    <div class="p-6 text-gray-900 bg-white shadow-sm sm:rounded-lg max-h-fit">
                        <h1 class="font-bold text-xl uppercase">{{ __('Shipping Address') }}</h1>
                        <div class="divider"></div>
                        <div x-data="addressData">
                            <x-button.info-button class="btn-sm" @click="show = true">
                                {{ __('Add Address') }}
                            </x-button.info-button>

                            <div class="mt-3 border border-gray-300 p-3 rounded-lg" x-show="show">
                                <div class="mb-2">
                                    <x-input-label for="fullname" value="{{ __('Full Name') }}" />
                                    <x-text-input id="fullname" name="fullname" type="text" class="mt-1"
                                        placeholder="{{ __('Full Name') }}" x-model="addressForm.fullname"/>
                                    {{-- <x-input-error :messages="" class="mt-2" /> --}}
                                </div>

                                <div class="mb-2">
                                    <x-input-label for="phone" value="{{ __('Phone') }}" />
                                    <x-text-input id="phone" name="phone" type="text" class="mt-1 numeric"
                                        placeholder="{{ __('Phone') }}" x-model="addressForm.phone"/>
                                    {{-- <x-input-error :messages="" class="mt-2" /> --}}
                                </div>

                                <div class="mb-2">
                                    <x-input-label for="address" value="{{ __('Address') }}" />
                                    <x-input.textarea id="address" name="address" cols="10"
                                        rows="2" class="mt-1" placeholder="{{ __('Address') }}" x-model="addressForm.address"></x-input.textarea>
                                    {{-- <x-input-error :messages="" class="mt-2" /> --}}
                                </div>

                                <div class="mb-2">
                                    <x-input-label for="markas" value="{{ __('Mark as') }}" />
                                    <div class="flex gap-3 mt-2">
                                        <div class="flex gap-1 cursor-pointer">
                                            <input type="radio" id="markas1" name="markas" class="radio radio-primary scale-75" value="0" x-model="addressForm.markas" :checked="addressForm.markas == 0 ? true : false"/>
                                            <x-input-label for="markas1" value="{{ __('Office') }}" />
                                        </div>
                                        <div class="flex gap-1 cursor-pointer">
                                            <input type="radio" id="markas2" name="markas" class="radio radio-primary scale-75" value="1" x-model="addressForm.markas" :checked="addressForm.markas == 1 ? true : false"/>
                                            <x-input-label for="markas2" value="{{ __('Home') }}" />
                                        </div>
                                    </div>
                                    {{-- <x-input-error :messages="" class="mt-2" /> --}}
                                </div>

                                <div class="mb-2">
                                    <x-input-label for="main_address" value="{{ __('Main Address') }}" />
                                    <div class="flex gap-3 mt-2">
                                        <div class="flex gap-1 cursor-pointer">
                                            <input type="radio" id="main_address1" name="main_address" class="radio radio-primary scale-75" value="0" x-model="addressForm.main_address" :checked="addressForm.main_address == 0 ? true : false"/>
                                            <x-input-label for="main_address1" value="{{ __('No') }}" />
                                        </div>
                                        <div class="flex gap-1 cursor-pointer">
                                            <input type="radio" id="main_address2" name="main_address" class="radio radio-primary scale-75" value="1" x-model="addressForm.main_address" :checked="addressForm.main_address == 1 ? true : false"/>
                                            <x-input-label for="main_address2" value="{{ __('Yes') }}" />
                                        </div>
                                    </div>
                                    {{-- <x-input-error :messages="" class="mt-2" /> --}}
                                </div>
                                <div class="mt-2 flex gap-2">
                                    <button class="btn btn-sm btn-secondary shadow" @click="clearForm()">{{ __('Close') }}</button>
                                    <button class="btn btn-sm btn-success text-white shadow" @click="onSubmit()">{{ __('Save') }}</button>
                                </div>
                            </div>

                            <div class="mt-3 section-address"></div>
                        </div>
        
                        <div class="mt-5 text-end">
                            <x-button.success-button x-on:click="window.location.href = '{{ route('frontstore.checkout') }}'">
                                {{ __('Checkout') }}
                            </x-button.success-button>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

    </div>

    @push('scripts')
        <script>
            const sectionEmptyData = (message) => {
                return `<div class="flex justify-center items-center w-full h-full">
                            <figure>
                                <img src="{{ asset('image/no-data.png') }}" class="w-30 h-24 text-center" alt="no data" />
                            </figure>
                            <h3 class="font-semibold text-center">${message}</h3>
                        </div>`
            };

            document.addEventListener('alpine:init', () => {
                Alpine.data('cartData', () => ({
                    cart: [],
                    subTotal: 0,
                    discount: 0,
                    onDisplayProduct() {
                        const sectionProduct = document.querySelector('.section-product');
                        sectionProduct.innerHTML = "";

                        if (this.cart.length > 0) {
                            const productId = this.cart.map(item => item.product_id);
                            requestAjax('{{ route('frontstore.cart.show') }}', {
                                productId
                            }, 'POST', 'JSON', (response) => {

                                let html = "";

                                if (response) {
                                    response.forEach(element => {
                                        const findCart = this.cart.find(item => item
                                            .product_id == element.id);

                                        const price = element.price;
                                        let discount = 0;
                                        let total = findCart.qty * price;
                                        if (element.discount > 0) {
                                            discount = price - (price * element
                                                .discount) / 100;

                                            total = findCart.qty * discount;
                                        }

                                        this.subTotal += total;
                                        this.discount += findCart.qty * (price * element
                                            .discount) / 100;

                                        let elementPrice =
                                            `<p>Rp. <span x-text="formatRupiah(vprice)"></span></p>`;
                                        if (element.discount > 0) {
                                            elementPrice =
                                                `<div class="flex items-center gap-2">
                                                    <s class="text-gray-500">Rp.  <span x-text="formatRupiah(vprice)"></span></s>
                                                    <p class="text-red-400" x-text="formatRupiah(vprice_discount)"></p>
                                                </div>`
                                        }

                                        html += `<div class="border border-gray-200 rounded p-3 mb-3 shadow"
                                                    x-data="{
                                                        vquantity: ${findCart.qty},
                                                        vstock: ${element.stock},
                                                        vprice: ${element.price},
                                                        vprice_discount: ${discount},
                                                        vtotal: ${total},
                                                        vdiscount: 0,
                                                        decrement(productId, quantity, price, discount) {
                                                            updateCart(productId, '-', quantity);
                                                            this.calculate(parseInt(price), parseInt(discount), '-');
                                                        },
                                                        increment(productId, quantity, price, discount) {
                                                            updateCart(productId, '+', quantity);
                                                            this.calculate(parseInt(price), parseInt(discount), '+');
                                                        },
                                                        deleted(productId) {
                                                            removeProductCart('${element.id}');

                                                            this.cart = this.cart.filter(item => item.product_id != productId);

                                                            this.calculate(parseInt(this.vprice), parseInt('${element.discount}'), '-');
                                                            $refs['product-${element.id}'].remove();
                                                            showToast('success', 'Product has been removed from the cart')

                                                            if(this.cart.length == 0){
                                                                const sectionProduct = document.querySelector('.section-product');
                                                                sectionProduct.innerHTML = sectionEmptyData('Cart is empty');
                                                            }

                                                            setLabelCarts();
                                                        },
                                                        calculate(price, discount, sperator) {
                                                            let tempPrice = price;
                                                            let tempDiscount = 0;
                                                            let tempTotal = this.vquantity * price;
                                                            if (discount > 0) {
                                                                tempPrice = price - ((price * discount) / 100);
                                                                tempDiscount = (price * discount) / 100;
                                                                tempTotal = this.vquantity * tempPrice;
                                                            }

                                                            this.vtotal = tempTotal;
                                                            this.vdiscount = tempDiscount;
                                                            if(sperator == '+'){
                                                                this.subTotal = this.subTotal + tempPrice;
                                                                this.discount = this.discount + tempDiscount;
                                                            }
                                                            if(sperator == '-'){
                                                                this.subTotal = this.subTotal - tempPrice;
                                                                this.discount = this.discount - tempDiscount;
                                                            }
                                                        }
                                                    }" x-ref="product-${element.id}">
                                                    <div class="flex justify-between w-full">
                                                        <div class="flex gap-5">
                                                            <figure class="rounded-lg border border-slate-700">
                                                                <img src="${element.image}" class="w-20 h-20 rounded-lg object-cover" alt="image">
                                                            </figure>
                                                            <div>
                                                                <h4 class="font-bold">${element.name}</h4>
                                                                <div class="flex items-center gap-4 mt-3">
                                                                    <div class="flex items-center gap-2">
                                                                        <div class="flex items-center border rounded-md shadow">
                                                                            <button
                                                                                class="btn btn-sm btn-ghost disabled:bg-transparent disabled:cursor-not-allowed"
                                                                                :disabled="vquantity <= 0"
                                                                                @click="vquantity--;decrement('${element.id}', vquantity, '${element.price}','${element.discount}')">-</button>
                                                                            <input type="text"
                                                                                @change="vquantity = this.value ;updateCart('${element.id}', 'input', vquantity);"
                                                                                x-model="vquantity"
                                                                                class="w-12 numeric text-center border-0 focus:shadow-transparent focus:outline-0 focus:outline-transparent focus:outline-none focus:outline-offset-0" />
                                                                            <button class="btn btn-sm btn-ghost" @click="vquantity++;increment('${element.id}', vquantity, '${element.price}','${element.discount}');">+</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <p class="font-semibold text-end">Price Item : </p>
                                                            ${elementPrice}
                                                        </div>
                                                    </div>
                                                    <div class="flex justify-between mt-5">
                                                        <x-button.danger-button @click="deleted('${element.id}')">{{ __('Delete') }}</x-button.danger-button>
                                                        <div>
                                                            <span class="text-gray-500">Total : </span>
                                                            <span class="text-bold">Rp. <span x-text="formatRupiah(vtotal)"></span></span>
                                                        </div>
                                                    </div>
                                                </div>`
                                    });
                                } else {
                                    html = sectionEmptyData('Cart is empty');
                                }

                                sectionProduct.innerHTML = html;
                            })
                        } else {
                            sectionProduct.innerHTML = sectionEmptyData('Cart is empty');
                        }


                    },
                    init() {
                        this.cart = getCarts();
                        this.onDisplayProduct();

                    }
                }));

                Alpine.data('addressData', () => ({
                    addressForm: {
                        id: getAddress().length + 1,
                        fullname: '',
                        phone: '',
                        address: '',
                        markas: 1,
                        main_address: 1
                    },
                    show: false,
                    displayAddress(){
                        const address = getAddress();

                        const sectionAddress = document.querySelector(".section-address");
                        sectionAddress.innerHTML = '';

                        if(address.length > 0){
                            let html = '';
                            address.forEach(item => {
                                html += `<div class="border ${item.main_address == 1 ? 'border-cyan-100 bg-cyan-100' : 'border-gray-200 bg-gray-200' } rounded p-3 mb-3 shadow"
                                            x-data="{
                                                onDelete(addressId){
                                                    removeAddress(addressId);
                                                    $refs['address-' + addressId].remove();
                                                    showToast('success', 'Address has been removed')
                                                }
                                            }"
                                            x-ref="address-${item.id}">
                                            <table class="table">
                                                <tr>
                                                    <td colspan="3" class="flex justify-end gap-3">
                                                        <button class="btn btn-xs btn-warning px-4 text-white shadow" >{{ __('Edit') }}</button>
                                                        <button class="btn btn-xs btn-error px-4 text-white shadow" @click="onDelete('${item.id}')">{{ __('Delete') }}</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="w-[20%]">Fullname</th>
                                                    <th class="w-[2%]">:</th>
                                                    <td class="w-[78%]">${item.fullname}</td>
                                                </tr>
                                                <tr>
                                                    <th>Phone</th>
                                                    <th>:</th>
                                                    <td>${item.phone}</td>
                                                </tr>
                                                <tr>
                                                    <th>Address</th>
                                                    <th>:</th>
                                                    <td>${item.address}</td>
                                                </tr>
                                                <tr>
                                                    <th>Mark as</th>
                                                    <th>:</th>
                                                    <td>${item.markas == 0 ? 'Office' : 'Home'}</td>
                                                </tr>
                                                <tr>
                                                    <th>Main Address</th>
                                                    <th>:</th>
                                                    <td>${item.main_address == 0 ? 'No' : 'Yes'}</td>
                                                </tr>
                                            </table>
                                         </div>`
                            })

                            sectionAddress.innerHTML = html;
                        } else {
                            sectionAddress.innerHTML = sectionEmptyData('Address is empty');
                        }
                    },
                    clearForm(){
                        this.addressForm = {
                            id: getAddress().length + 1,
                            fullname: '',
                            phone: '',
                            address: '',
                            markas: 1,
                            main_address: 1
                        }
                        this.show = false
                    },
                    onSubmit(){
                        addToAddress(this.addressForm);
                        this.clearForm();
                        this.displayAddress();
                        showToast('success', 'Address has been added')
                    },
                    init(){
                        this.displayAddress();
                    }
                }))
            })
        </script>
    @endpush
</x-app-front-layout>

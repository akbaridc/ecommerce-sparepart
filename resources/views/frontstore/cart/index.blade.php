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
                                        placeholder="{{ __('Full Name') }}" x-model="addressForm.fullname" />
                                    {{-- <x-input-error :messages="" class="mt-2" /> --}}
                                </div>

                                <div class="mb-2">
                                    <x-input-label for="phone" value="{{ __('Phone') }}" />
                                    <x-text-input id="phone" name="phone" type="text" class="mt-1 numeric"
                                        placeholder="{{ __('Phone') }}" x-model="addressForm.phone" />
                                    {{-- <x-input-error :messages="" class="mt-2" /> --}}
                                </div>

                                <div class="mb-2">
                                    <x-input-label for="address" value="{{ __('Address') }}" />
                                    <x-input.textarea id="address" name="address" cols="10" rows="2"
                                        class="mt-1" placeholder="{{ __('Address') }}"
                                        x-model="addressForm.address"></x-input.textarea>
                                    {{-- <x-input-error :messages="" class="mt-2" /> --}}
                                </div>

                                <div class="mb-2">
                                    <x-input-label for="markas" value="{{ __('Mark as') }}" />
                                    <div class="flex gap-3 mt-2">
                                        <x-input.radio model="addressForm.markas" name="markas" value="0"
                                            label="{{ __('Office') }}" />
                                        <x-input.radio model="addressForm.markas" name="markas" value="1"
                                            label="{{ __('Home') }}" :checked="true" />
                                    </div>
                                    {{-- <x-input-error :messages="" class="mt-2" /> --}}
                                </div>

                                <div class="mb-2">
                                    <x-input-label for="main_address" value="{{ __('Main Address') }}" />
                                    <div class="flex gap-3 mt-2">
                                        <x-input.radio model="addressForm.main_address" name="main_address"
                                            value="0" label="{{ __('No') }}" />
                                        <x-input.radio model="addressForm.main_address" name="main_address"
                                            value="1" label="{{ __('Yes') }}" :checked="true" />
                                    </div>
                                    {{-- <x-input-error :messages="" class="mt-2" /> --}}
                                </div>
                                <div class="mt-2 flex gap-2">
                                    <button class="btn btn-sm btn-secondary shadow"
                                        @click="clearForm()">{{ __('Close') }}</button>
                                    <button class="btn btn-sm btn-success text-white shadow"
                                        @click="onSubmit()">{{ __('Save') }}</button>
                                </div>
                            </div>

                            <div class="mt-3 section-address"></div>
                        </div>

                        <div class="mt-5 text-end">
                            <x-button.success-button @click="onCheckout()">
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
                    displayAddress() {
                        const address = getAddress();

                        const sectionAddress = document.querySelector(".section-address");
                        sectionAddress.innerHTML = '';

                        if (address.length > 0) {
                            let html = '';
                            address.forEach(item => {
                                html += `<div class="border ${item.main_address == 1 ? 'border-cyan-100 bg-cyan-100' : 'border-gray-50 bg-gray-50' } rounded p-3 mb-3 shadow"
                                            x-data="{
                                                address: {
                                                    id: '${item.id}',
                                                    fullname: '${item.fullname}',
                                                    phone: '${item.phone}',
                                                    address: '${item.address}',
                                                    markas: '${item.markas}',
                                                    main_address: '${item.main_address}'
                                                },
                                                edit: false,
                                                onDelete(addressId){
                                                    removeAddress(addressId);
                                                    $refs['address-' + addressId].remove();
                                                    showToast('success', 'Address has been removed')
                                                },
                                                onUpdated(){
                                                    updateAddress(this.address);
                                                    this.edit = false;
                                                    this.displayAddress();
                                                    showToast('success', 'Address has been updated')
                                                },
                                                onChangeMainAddress(){
                                                    this.address.main_address = 1;
                                                    updateAddress(this.address);
                                                    this.displayAddress();
                                                    showToast('success', 'Address has been set main address')
                                                }
                                            }"
                                            x-ref="address-${item.id}">
                                            <div class="flex mb-3 gap-3">
                                                <button class="btn btn-xs btn-warning px-4 text-white shadow" @click="edit = !edit" x-text="edit ? 'Cancel' : 'Edit'"></button>
                                                <button class="btn btn-xs btn-success px-4 text-white shadow" @click="onUpdated()" x-show="edit">{{ __('Update') }}</button>
                                                <button class="btn btn-xs btn-error px-4 text-white shadow" @click="onDelete('${item.id}')">{{ __('Delete') }}</button>
                                                <template x-if="address.main_address == 0 && !edit">
                                                    <button class="btn btn-xs btn-secondary px-4 text-white shadow" @click="onChangeMainAddress()">{{ __('Change it Main Address') }}</button>
                                                </template>
                                            </div>
                                            <table class="table w-full">
                                                <tr>
                                                    <th class="w-[20%]">Fullname</th>
                                                    <th class="w-[2%]">:</th>
                                                    <td class="w-[78%]">
                                                        <span x-show="!edit" x-text="address.fullname"></span>
                                                        <x-text-input x-show="edit" id="fullname" name="fullname" type="text" placeholder="{{ __('Fullname') }}" x-model="address.fullname" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Phone</th>
                                                    <th>:</th>
                                                    <td>
                                                        <span x-show="!edit" x-text="address.phone"></span>
                                                        <x-text-input x-show="edit" id="phone" name="phone" class="numeric" type="text" placeholder="{{ __('Phone') }}" x-model="address.phone" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Address</th>
                                                    <th>:</th>
                                                    <td>
                                                        <span x-show="!edit" x-text="address.address"></span>
                                                        <x-text-input x-show="edit" id="address" name="address" type="text" placeholder="{{ __('Address') }}" x-model="address.address" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Mark as</th>
                                                    <th>:</th>
                                                    <td>
                                                        <span x-show="!edit" x-text="address.markas == 0 ? 'Office' : 'Home'"></span>
                                                        <div class="flex gap-3 mt-2" x-show="edit">
                                                            <x-input.radio name="markas"
                                                                value="0" label="{{ __('Office') }}" model="address.markas" checked="address.markas == 0 ? true : false" counter="${item.id}"/>
                                                            <x-input.radio  name="markas"
                                                                value="1" label="{{ __('Home') }}" model="address.markas" checked="address.markas == 0 ? true : false" counter="${item.id}"/>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Main Address</th>
                                                    <th>:</th>
                                                    <td>
                                                        <span x-show="!edit" x-text="address.main_address == 0 ? 'No' : 'Yes'"></span>
                                                        <div class="flex gap-3 mt-2" x-show="edit">
                                                            <x-input.radio model="address.main_address" name="main_address"
                                                                value="0" label="{{ __('No') }}" checked="address.main_address == 0 ? true : false" counter="${item.id}"/>
                                                            <x-input.radio model="address.main_address" name="main_address"
                                                                value="1" label="{{ __('Yes') }}" checked="address.main_address == 1 ? true : false" counter="${item.id}"/>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                         </div>`
                            })

                            sectionAddress.innerHTML = html;
                        } else {
                            sectionAddress.innerHTML = sectionEmptyData('Address is empty');
                        }
                    },
                    clearForm() {
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
                    onSubmit() {
                        addToAddress(this.addressForm);
                        this.clearForm();
                        this.displayAddress();
                        showToast('success', 'Address has been added')
                    },
                    init() {
                        this.displayAddress();
                    }
                }))
            })

            const onCheckout = () => {
                const carts = getCarts();
                const address = getAddress();

                if (carts.length == 0) return showToast('error', 'Your cart is empty, please add product first');
                if (address.length == 0) return showToast('error', 'Your address is empty, please add address first');

                const mainAddress = address.find(item => item.main_address == 1);

                if (!mainAddress) return showToast('error', 'Your main address is empty, please add main address first');

                const codeTransaction = '{{ codeTransaction() }}';

                let message = "";
                message += `Order Product *${codeTransaction}*\n\n`;

                let total = 0;
                carts.forEach((item, index) => {
                    const price = item.price - ((item.price * item.discount) / 100);
                    total += price * item.qty;
                    message += `${index + 1}. ${item.product} ${item.qty} x ${formatRupiah(price)}\n`;
                })

                message += '------------------------------------------\n'
                message += `*Total: Rp. ${formatRupiah(total)}*\n\n`;

                message += 'Address\n\n';

                message += `*Name*: ${mainAddress.fullname}\n`;
                // message += `*Phone*: ${mainAddress.phone}\n`;
                message += `*Address*: ${mainAddress.address}\n`;

                window.open(`https://wa.me/{{ formatPhoneNumber(site()->phone) }}?text=${encodeURI(message)}`, 'blank');

                requestAjax('{{ route('frontstore.checkout.store') }}', {
                    carts,
                    mainAddress,
                    codeTransaction
                }, 'POST', function(response) {});

                removeProductCart();
                showToast('success', 'Order has been sent');
                setTimeout(() => window.location.href = '{{ route('frontstore.homepage') }}', 2000);

            }
        </script>
    @endpush
</x-app-front-layout>

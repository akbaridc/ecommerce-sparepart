<x-app-front-layout>
    <div class="mx-auto max-w-full sm:px-6 lg:px-8">
        <div class="flex flex-wrap gap-4" x-data="cartData">
            <div class="overflow-hidden p-6 text-gray-900 bg-white shadow-sm sm:rounded-lg w-[57%]">
                <div class="flex justify-between">
                    <h4>Shipping Address <span class="font-bold" x-text="'( ' + cart.length + ' items )'"></span></h4>
                    <x-button.warning-button >
                        <i class="fa-solid fa-plus me-2"></i> {{ __('Add Address') }}
                    </x-button.warning-button>
                </div>
                <div class="divider"></div>
                <div class="section-address"></div>
            </div>
            <div class="p-6 text-gray-900 bg-white shadow-sm sm:rounded-lg w-[40%] max-h-fit">
                <h1 class="font-bold text-xl uppercase">{{ __('Summary Order') }}</h1>
                <div class="divider"></div>
                <table class="table border-separate">
                    <tr>
                        <td>Subtotal</td>
                        <td class="text-end"><span></span></td>
                    </tr>
                    <tr>
                        <td>Discount</td>
                        <td class="text-red-400 text-end">-<span></span></td>
                    </tr>
                    <tr>
                        <td>Grand Total</td>
                        <td class="text-end text-bold text-xl">Rp. <span></span></td>
                    </tr>
                </table>

                <div class="mt-5 text-end">
                    <x-button.success-button x-on:click="window.location.href = '{{ route('frontstore.checkout') }}'">
                        {{ __('Checkout') }}
                    </x-button.success-button>
                </div>
            </div>
        </div>

    </div>
</x-app-front-layout>

<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="card bg-white p-5">
                <div class="card-title">
                    <h3 class="text-slate-900">Detail Transaction</h3>
                    <x-button.secondary-button x-data=""
                        x-on:click="window.location.href = '{{ route('backoffice.transaction.index') }}'"
                        class="ml-auto">{{ __('Back') }}</x-button.secondary-button>
                </div>
                <div class="card-body">
                    <div x-data="orderForm">
                        <div class="flex flex-wrap gap-2">

                            <div class="mb-2 w-[20%]">
                                <x-input-label for="code" value="{{ __('Code') }}" />
                                <p class="mt-1" x-text="order.code"></p>
                            </div>

                            <div class="mb-2 w-[40%]">
                                <x-input-label for="name" value="{{ __('Customer') }}" />
                                <p class="mt-1" x-text="order.name"></p>
                            </div>

                            <div class="mb-2 w-[30%]">
                                <x-input-label for="phone" value="{{ __('Phone') }}" />
                                <p class="mt-1" x-text="order.phone"></p>
                            </div>

                            <div class="mb-2 w-full">
                                <x-input-label for="address" value="{{ __('Address') }}" />
                                <p class="mt-1" x-text="order.address"></p>
                            </div>

                            <table class="table w-full">
                                <thead>
                                    <tr>
                                        <th>{{ __('Product') }}</th>
                                        <th>{{ __('Price') }}</th>
                                        <th>{{ __('Discount') }}</th>
                                        <th>{{ __('Qty') }}</th>
                                        <th>{{ __('Total') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->order_detail as $orderItem)
                                        @php
                                            $priceDiscount =
                                                $orderItem->price - ($orderItem->price * $orderItem->discount) / 100;
                                        @endphp
                                        <tr>
                                            <td>{{ $orderItem->product->name }}</td>
                                            <td>
                                                @if ($orderItem->discount > 0)
                                                    <div class="flex gap-2">
                                                        <s>{{ formatRupiah($orderItem->price) }}</s>
                                                        <p class="text-red-500">{{ formatRupiah($priceDiscount) }}</p>
                                                    </div>
                                                @else
                                                    {{ formatRupiah($orderItem->price) }}
                                                @endif
                                            </td>
                                            <td>{{ $orderItem->discount }}</td>
                                            <td>{{ $orderItem->qty }}</td>
                                            <td>{{ formatRupiah(($orderItem->discount > 0 ? $priceDiscount : $orderItem->price) * $orderItem->qty) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener("alpine:init", () => {
                Alpine.data("orderForm", () => ({
                    order: {
                        code: "{{ old('code', $order->code) }}",
                        name: "{{ old('name', $order->name) }}",
                        phone: "{{ old('phone', $order->phone) }}",
                        address: "{{ old('address', $order->address) }}",
                    }
                }))
            })
        </script>
    @endpush
</x-app-layout>

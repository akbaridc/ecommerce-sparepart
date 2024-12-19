<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="card bg-white p-5">
                <div class="card-title">
                    <h3 class="text-slate-900">Edit Transaction</h3>
                    <x-button.secondary-button x-data=""
                        x-on:click="window.location.href = '{{ route('backoffice.transaction.index') }}'"
                        class="ml-auto">{{ __('Back') }}</x-button.secondary-button>
                </div>
                <div class="card-body">
                    <div x-data="orderForm">
                        <form method="post" action="{{ route('backoffice.transaction.update', $order->id) }}"
                            enctype="multipart/form-data" class="p-6" x-ref="orderForm">
                            @csrf
                            @method('PUT')

                            <div class="flex flex-wrap gap-2">

                                <div class="mb-2 w-[20%]">
                                    <x-input-label for="code" value="{{ __('Code') }}" />
                                    <x-text-input id="code" name="code" type="text" class="mt-1"
                                        placeholder="{{ __('Auto Generated') }}" disabled="true" x-model="order.code" />
                                </div>

                                <div class="mb-2 w-[40%]">
                                    <x-input-label for="name" value="{{ __('Customer') }}" />
                                    <x-text-input id="name" name="name" type="text" class="mt-1"
                                        placeholder="{{ __('Customer') }}" x-model="order.name" />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div class="mb-2 w-[30%]">
                                    <x-input-label for="phone" value="{{ __('Phone') }}" />
                                    <x-text-input id="phone" name="phone" type="text" class="mt-1 numeric"
                                        placeholder="{{ __('Phone') }}" x-model="order.phone" />
                                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                                </div>

                                <div class="mb-2 w-full">
                                    <x-input-label for="address" value="{{ __('Address') }}" />
                                    <x-input.textarea id="address" name="address" cols="10" rows="1"
                                        class="mt-1" placeholder="{{ __('Address') }}"
                                        x-model="order.address"></x-input.textarea>
                                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
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
                                            <tr>
                                                <td>{{ $orderItem->product->name }}</td>
                                                <td>{{ $orderItem->price }}</td>
                                                <td>{{ $orderItem->discount }}</td>
                                                <td>{{ $orderItem->qty }}</td>
                                                <td>{{ $orderItem->total }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3 flex justify-end">
                                <x-button.success-button type="submit" class="ms-3">
                                    {{ __('Submit') }}
                                </x-button.success-button>
                            </div>
                        </form>
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

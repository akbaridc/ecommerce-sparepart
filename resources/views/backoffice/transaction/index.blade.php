<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="card bg-white p-5">
                <div class="card-title justify-between">
                    <h3 class="text-slate-900">History Transaction</h3>
                </div>
                <div class="card-body">
                    <div class="overflow-x-auto">
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Code</th>
                                    <th>Customer</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Total</th>
                                    <th>Order At</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transactions as $index => $transaction)
                                    <tr>
                                        <td class="text-center">
                                            {{ $loop->iteration + ($transactions->currentPage() - 1) * $transactions->perPage() }}
                                        </td>
                                        <td>{{ $transaction->code }}</td>
                                        <td>{{ $transaction->name }}</td>
                                        <td>{{ $transaction->phone }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($transaction->address, 50) }}</td>
                                        <td>
                                            {{ formatRupiah(
                                                $transaction->order_detail->map(function ($detail) {
                                                        $price = $detail->price - ($detail->price * $detail->discount) / 100;
                                                        return $price * $detail->qty;
                                                    })->sum(),
                                            ) }}
                                        </td>
                                        <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <div class="flex gap-2 justify-center">
                                                <x-button.info-button x-data=""
                                                    x-on:click="window.location.href = '{{ route('backoffice.transaction.show', $transaction->id) }}'">
                                                    {{ __('Detail') }}
                                                </x-button.info-button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-slate-500">No transaction found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

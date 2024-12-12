<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="card bg-white p-5">
                <div class="card-title">
                    <h3 class="text-slate-900">Product</h3>
                    <x-button.success-button x-data=""
                        x-on:click="window.location.href = '{{ route('backoffice.product.create') }}'"
                        class="ml-auto">{{ __('Add New') }}</x-button.success-button>
                </div>
                <div class="card-body">
                    <div class="overflow-x-auto">
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Category</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Image</th>
                                    <th>Updated At</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $index => $product)
                                    <tr>
                                        <td class="text-center">
                                            {{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}
                                        </td>
                                        <td>{{ $product->category->name }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($product->description, 50) }}</td>
                                        <td>{{ number_format($product->price, 0, ',', '.') }}</td>
                                        <td>{{ number_format($product->stock, 0, ',', '.') }}</td>
                                        <td class="text-center">
                                            @if (!empty($product->image))
                                                <div class="avatar">
                                                    <div class="w-24 rounded">
                                                        <img src="{{ asset('storage/' . $product->image) }}" />
                                                    </div>
                                                </div>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $product->updated_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <div class="flex gap-2 justify-center">
                                                <x-button.info-button x-data=""
                                                    x-on:click="window.location.href = '{{ route('backoffice.product.show', $product->id) }}'">
                                                    {{ __('View') }}
                                                </x-button.info-button>
                                                <x-button.warning-button x-data=""
                                                    x-on:click="window.location.href = '{{ route('backoffice.product.edit', $product->id) }}'">
                                                    {{ __('Edit') }}
                                                </x-button.warning-button>
                                                <x-button.danger-button x-data=""
                                                    x-on:click.prevent="
                                                            $dispatch('open-modal', 'confirm-delete');
                                                            $dispatch('set-delete-action', '{{ route('backoffice.product.destroy', $product->id) }}');
                                                        ">
                                                    {{ __('Delete') }}
                                                </x-button.danger-button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-slate-500">No products found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

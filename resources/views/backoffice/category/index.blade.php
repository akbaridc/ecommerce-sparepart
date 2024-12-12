<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="card bg-white p-5">
                <div class="card-title">
                    <h3 class="text-slate-900">Category</h3>
                    <x-button.success-button x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'form-category')"
                        class="ml-auto">{{ __('Add New') }}</x-button.success-button>
                </div>
                <div class="card-body">
                    <div class="overflow-x-auto">
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Updated At</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $index => $category)
                                    <tr>
                                        <td class="text-center">
                                            {{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}
                                        </td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->updated_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <div class="flex gap-2 justify-center">
                                                <x-button.warning-button x-data=""
                                                    x-on:click.prevent="
                                                            $dispatch('open-modal', 'form-category');
                                                            $dispatch('set-edit-data', {
                                                                actionUrl: '{{ route('category.update', $category->id) }}',
                                                                name: '{{ $category->name }}'
                                                            });
                                                        ">
                                                    {{ __('Edit') }}
                                                </x-button.warning-button>
                                                <x-button.danger-button x-data=""
                                                    x-on:click.prevent="
                                                            $dispatch('open-modal', 'confirm-delete');
                                                            $dispatch('set-delete-action', '{{ route('category.destroy', $category->id) }}');
                                                        ">
                                                    {{ __('Delete') }}
                                                </x-button.danger-button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-slate-500">No categories found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-modal.modal name="form-category" maxWidth="lg" :show="$errors->isNotEmpty()" focusable>
        <div x-data="{
            formAction: '{{ route('category.store') }}',
            categoryName: '',
            isEdit: false,
            setEditData(actionUrl, name) {
                this.formAction = actionUrl;
                this.categoryName = name;
                this.isEdit = true;
            },
            resetForm() {
                this.formAction = '{{ route('category.store') }}';
                this.categoryName = '';
                this.isEdit = false;
            },
            init() {
                window.addEventListener('set-edit-data', (event) => {
                    const { actionUrl, name } = event.detail;
                    this.setEditData(actionUrl, name);
                });
        
                window.addEventListener('close-modal', () => {
                    this.resetForm();
                });
            }
        }" x-init="init()">
            <form method="post" :action="formAction" class="p-6">
                @csrf
                <template x-if="isEdit">
                    @method('PUT')
                </template>

                <h2 class="text-lg font-medium text-gray-900">
                    <span x-show="!isEdit">{{ __('Add New Category') }}</span>
                    <span x-show="isEdit">{{ __('Edit Category') }}</span>
                </h2>

                <div class="mt-6">
                    <x-input-label for="name" value="{{ __('Category Name') }}" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-3/4"
                        placeholder="{{ __('Category Name') }}" x-model="categoryName" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <x-button.secondary-button x-on:click="$dispatch('close-modal'); resetForm()">
                        {{ __('Cancel') }}
                    </x-button.secondary-button>

                    <x-button.success-button type="submit" class="ms-3">
                        {{ __('Submit') }}
                    </x-button.success-button>
                </div>
            </form>
        </div>
    </x-modal.modal>
</x-app-layout>

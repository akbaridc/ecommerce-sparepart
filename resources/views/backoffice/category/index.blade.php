<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="card bg-white p-5">
                <div class="card-title justify-between">
                    <h3 class="text-slate-900">Category</h3>
                    <div class="flex gap-2">
                        <form action="{{ route('backoffice.category.restore') }}" method="POST" class="inline">
                            @csrf
                            <x-button.primary-button x-data=""
                                type="submit">{{ __('Restore Deleted') }}</x-button.primary-button>
                        </form>

                        <x-button.success-button x-data=""
                            x-on:click.prevent="$dispatch('open-modal', 'form-category');$dispatch('reset-form');"
                            class="ml-auto">{{ __('Add New') }}</x-button.success-button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="overflow-x-auto">
                        <table class="table w-full">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Name</th>
                                    <th class="text-center">Icon</th>
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
                                        <td class="text-center">
                                            @if (!empty($category->icon))
                                                <div class="avatar">
                                                    <div class="w-24 rounded">
                                                        <img src="{{ asset('storage/' . $category->icon) }}" />
                                                    </div>
                                                </div>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $category->updated_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <div class="flex gap-2 justify-center">
                                                <x-button.warning-button x-data=""
                                                    x-on:click.prevent="
                                                            $dispatch('open-modal', 'form-category');
                                                            $dispatch('reset-form')
                                                            $dispatch('set-edit-data', {
                                                                actionUrl: '{{ route('backoffice.category.update', $category->id) }}',
                                                                name: '{{ $category->name }}',
                                                                slug: '{{ $category->slug }}',
                                                            });
                                                        ">
                                                    {{ __('Edit') }}
                                                </x-button.warning-button>
                                                <x-button.danger-button x-data=""
                                                    x-on:click.prevent="
                                                            $dispatch('open-modal', 'confirm-delete');
                                                            $dispatch('set-delete-action', '{{ route('backoffice.category.destroy', $category->id) }}');
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

    <x-modal.modal name="form-category" maxWidth="md" :show="$errors->isNotEmpty()" focusable>
        <div x-data="categoryForm" x-init="init()">
            <form method="post" :action="formAction" class="p-6" enctype="multipart/form-data">
                @csrf
                <template x-if="isEdit">
                    @method('PUT')
                </template>

                <h2 class="text-lg font-medium text-gray-900">
                    <span x-show="!isEdit">{{ __('Add New Category') }}</span>
                    <span x-show="isEdit">{{ __('Edit Category') }}</span>
                </h2>

                <div class="mt-6">
                    <x-input-label for="name" value="{{ __('Name') }}" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                        placeholder="{{ __('Category Name') }}" x-model="category.value" x-on:keyup="generateSlug()" />
                    <x-input-error x-show="category.error" :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mt-2">
                    <x-input-label for="slug">
                        {{ __('Slug') }} <small
                            class="text-xs text-gray-500">{{ __('Auto Generated from Category Name') }}</small>
                    </x-input-label>
                    <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full"
                        placeholder="{{ __('Auto Generated from Category Name') }}" x-model="slug.value"
                        :readonly="true" />
                    <x-input-error x-show="slug.error" :messages="$errors->get('slug')" class="mt-2" />
                </div>

                <div class="mt-2">
                    <x-input-label for="icon">
                        {{ __('Icon') }} <small x-show="isEdit"
                            class="text-xs text-gray-500">{{ __('Ignore if not changed') }}</small>
                    </x-input-label>
                    <x-input.file-input id="icon" name="icon" class="mt-1 block " accept="image/*"
                        placeholder="{{ __('Icon') }}" x-model="icon.value" />
                    <x-input-error x-show="icon.error" :messages="$errors->get('icon')" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <x-button.secondary-button x-on:click="$dispatch('close-modal', 'form-category'); resetForm()">
                        {{ __('Cancel') }}
                    </x-button.secondary-button>

                    <x-button.success-button type="submit" class="ms-3">
                        {{ __('Submit') }}
                    </x-button.success-button>
                </div>
            </form>
        </div>
    </x-modal.modal>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('categoryForm', () => ({
                    formAction: '{{ route('backoffice.category.store') }}',
                    category: {
                        value: '{{ old('name') ?? '' }}',
                        error: {{ $errors->get('name') ? 'true' : 'false' }},
                    },
                    slug: {
                        value: '{{ old('slug') ?? '' }}',
                        error: {{ $errors->get('slug') ? 'true' : 'false' }},
                    },
                    icon: {
                        value: '{{ old('icon') ?? '' }}',
                        error: {{ $errors->get('icon') ? 'true' : 'false' }},
                    },
                    isEdit: false,

                    setEditData(actionUrl, name, slug) {
                        this.formAction = actionUrl;
                        this.category.value = name;
                        this.slug.value = slug;
                        this.isEdit = true;
                    },

                    resetForm() {
                        this.formAction = '{{ route('backoffice.category.store') }}';
                        this.category.value = '';
                        this.slug.value = '';
                        this.isEdit = false;
                        this.category.error = false;
                        this.slug.error = false;
                        this.icon.error = false;
                    },

                    generateSlug() {
                        this.slug.value = this.category.value
                            .toLowerCase()
                            .trim()
                            .replace(/[^a-z0-9\s-]/g, '')
                            .replace(/\s+/g, '-')
                            .replace(/-+/g, '-');
                    },

                    init() {
                        window.addEventListener('reset-form', () => {
                            this.resetForm();
                        });

                        window.addEventListener('set-edit-data', (event) => {
                            const {
                                actionUrl,
                                name,
                                slug
                            } = event.detail;
                            this.setEditData(actionUrl, name, slug);
                        });
                    },
                }));
            });
        </script>
    @endpush
</x-app-layout>

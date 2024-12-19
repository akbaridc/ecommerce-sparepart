<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="card bg-white p-5" x-data="siteForm">
                <div class="card-title justify-between">
                    <h3 class="text-slate-900">Setting</h3>
                    <div class="flex gap-2">
                        <x-button.warning-button @click="edit = !edit"
                            x-text="edit ? 'Cancel' : 'Edit'"></x-button.warning-button>

                        <x-button.success-button x-show="edit" @click="onUpdated()">Update</x-button.success-button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="flex flex-wrap gap-3">
                        <div class="w-[30%] mb-3">
                            <label for="application" class="label font-bold">Application Name</label>
                            <span x-show="!edit" class="text-sm text-gray-400" x-text="site.name"></span>
                            <x-text-input x-show="edit" id="application" name="application" type="text"
                                placeholder="{{ __('Application Name') }}" x-model="site.name" />
                        </div>

                        <div class="w-[20%] mb-3">
                            <label for="phone" class="label font-bold">Phone (Whatsapp)</label>
                            <span x-show="!edit" class="text-sm text-gray-400" x-text="site.phone"></span>
                            <x-text-input x-show="edit" id="phone" name="phone" class="numeric" type="text"
                                placeholder="{{ __('Phone (Whatsapp)') }}" x-model="site.phone" />
                        </div>

                        <div class="w-[48%] mb-3">
                            <label for="logo" class="label font-bold justify-center">Logo</label>
                            @if (site()->logo)
                                <figure x-show="!edit">
                                    <img src="{{ asset('storage/' . site()->logo) }}" alt="">
                                </figure>
                            @endif

                            <x-input.file-input x-show="edit" id="logo" name="logo" class="mt-1 block w-full"
                                x-ref="field-logo" accept="image/*" placeholder="{{ __('Logo') }}"
                                x-model="site.logo" />
                        </div>

                        <div class="w-[48%] mb-3">
                            <label for="favicon" class="label font-bold justify-center">Favicon</label>
                            @if (site()->favicon)
                                <figure x-show="!edit">
                                    <img src="{{ asset('storage/' . site()->favicon) }}" alt="">
                                </figure>
                            @endif

                            <x-input.file-input x-show="edit" id="favicon" name="favicon" class="mt-1 block w-full"
                                x-ref="field-favicon" accept="image/*" placeholder="{{ __('Favicon') }}"
                                x-model="site.favicon" />
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener("alpine:init", () => {
                Alpine.data("siteForm", () => ({
                    edit: false,
                    site: {
                        name: '{{ site()->name }}',
                        phone: '{{ site()->phone }}',
                        logo: null,
                        favicon: null
                    },
                    onUpdated() {
                        if (!this.site.name) return showToast('error', 'Application Name is required')
                        if (!this.site.phone) return showToast('error', 'Phone is required')

                        // Siapkan FormData
                        const formData = new FormData();
                        formData.append('name', this.site.name);
                        formData.append('phone', this.site.phone);

                        // Tambahkan file logo jika ada
                        const logoInput = this.$refs['field-logo'];
                        if (logoInput?.files?.length) {
                            formData.append('logo', logoInput.files[0]);
                        }

                        // Tambahkan file favicon jika ada
                        const faviconInput = this.$refs['field-favicon'];
                        if (faviconInput?.files?.length) {
                            formData.append('favicon', faviconInput.files[0]);
                        }

                        fetch('{{ route('backoffice.site.update') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData
                        }).then(response => response.json()).then((data) => {
                            this.edit = false;
                            showToast('success', 'Updated Successfully');
                            setTimeout(() => window.location.reload(), 1000);
                        });
                    }
                }))
            })
        </script>
    @endpush
</x-app-layout>

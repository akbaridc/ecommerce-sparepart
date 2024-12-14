<x-app-layout>

    @push('link')
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    @endpush

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="card bg-white p-5">
                <div class="card-title">
                    <h3 class="text-slate-900">Banner</h3>
                </div>
                <div class="card-body">
                    <div>
                        <form action="{{ route('backoffice.banner.store') }}" method="POST"
                            enctype="multipart/form-data" class="border-dashed border-2 dropzone" id="image-upload"
                            style="border: 2px rgba(0,0,0,0.3) dashed !important">
                            @csrf
                        </form>
                    </div>
                    <div class="divider"></div>
                    <div>
                        <div class="flex justify-between">
                            <span class="text-muted">Draggable card to change position image</span>
                            <x-button.danger-button x-data=""
                                x-on:click.prevent="
                                    $dispatch('open-modal', 'confirm-delete');
                                    $dispatch('set-delete-action', '{{ route('backoffice.banner.destroyAll') }}');
                                ">
                                {{ __('Delete All') }}
                            </x-button.danger-button>
                        </div>
                        <div class="mt-6 flex flex-wrap items-center justify-center gap-3 banner-section"
                            x-data="{ url: null }"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                listBanner();
            })

            Dropzone.options.imageUpload = {
                maxFilesize: 1,
                acceptedFiles: ".jpeg,.jpg,.png",
                dictDefaultMessage: `<div class="mb-3"><i class="text-xl text-gary-400 fa-regular fa-image"></i></div>
                                 <h5>Upload image or drag and drop</h5>
                                 <h6 class="text-muted">JPG or PNG up to 1 MB</h6>`,
                init: function() {
                    this.on("success", function(file) {
                        if (file.status === "success") {
                            setTimeout(() => {
                                this.removeFile(file)
                                setTimeout(() => listBanner(), 1500);
                            }, 1200);
                        }
                    });
                    this.on("addedfile", function(file) {
                        if (file.size > this.options.maxFilesize * 1024 * 1024) {
                            var errorMessage = "The file is too large. The maximum size is " + this.options
                                .maxFilesize + " MB.";
                            file.previewElement.querySelector(".dz-error-message").textContent = errorMessage;
                        }
                    });
                }
            };

            const listBanner = () => {
                let bannerSection = document.querySelector('.banner-section');
                bannerSection.innerHTML =
                    '<div class="skeleton h-50 w-full"></div><div class="skeleton h-50 w-full"></div>';

                setTimeout(() => {
                    fetch('{{ route('backoffice.banner.show') }}')
                        .then(response => response.json())
                        .then(data => {
                            bannerSection.innerHTML = '';

                            let dataHtml = '';
                            if (data.length > 0) {
                                data.forEach(element => {
                                    const urlDestroy = "{{ route('backoffice.banner.destroy', ':id') }}"
                                        .replace(
                                            ':id', element.id);
                                    dataHtml += `
                                    <div class="w-full relative mb-3 banner-card cursor-pointer" data-id="${element.id}">
                                        <figure class="w-full h-50 shadow-lg border border-gray-500 rounded-md">
                                            <span class="absolute -top-3 -right-1 cursor-pointer bg-red-400 text-white rounded-full w-8 h-8 flex justify-center items-center"
                                                x-on:click.prevent="
                                                    url= '${urlDestroy}';
                                                    $dispatch('open-modal', 'confirm-delete');
                                                    $dispatch('set-delete-action', url);
                                                ">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </span>
                                            <img src="{{ asset('storage/${element.patch}') }}" alt="${element.order}" />
                                        </figure>
                                    </div>
                                    `;
                                });
                            } else {
                                dataHtml = `
                                    <div class="w-full flex flex-col justify-center items-center">
                                        <figure>
                                            <img src="{{ asset('image/no-data.png') }}" class="w-30 h-24 text-center" alt="no data" />
                                        </figure>
                                        <h3 class="font-semibold text-center">Banner Tidak Tersedia</h3>
                                    </div>
                                    `;
                            }

                            document.querySelector('.banner-section').innerHTML = dataHtml;
                        })
                }, 1000)

                // Initialize SortableJS
                const sortable = new Sortable(document.querySelector('.banner-section'), {
                    animation: 150,
                    onEnd: function(evt) {
                        const items = Array.from(document.querySelectorAll('.banner-card'));
                        const orders = items.map((item, index) => {
                            return {
                                id: parseInt(item.getAttribute('data-id')),
                                order: index + 1
                            };
                        });

                        fetch('{{ route('backoffice.banner.update') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(orders)
                        })
                    },
                });
            }
        </script>
    @endpush
</x-app-layout>

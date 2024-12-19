<script>
    document.addEventListener("DOMContentLoaded", function() {

        document.addEventListener("input", function(event) {
            if (event.target.classList.contains("numeric")) {
                event.target.value = event.target.value.replace(/[^\d.]+/g, "");
            }
        });
    })

    const showToast = (type, message) => {
        const toastContainer = document.createElement('div');
        toastContainer.innerHTML = `
            <div class="toast toast-top toast-center z-[99999999]"
                x-data="{ show: true, timeout: null }"
                x-show="show"
                x-init="timeout = setTimeout(() => show = false, 2500);
                         $el.addEventListener('mouseenter', () => clearTimeout(timeout));
                         $el.addEventListener('mouseleave', () => timeout = setTimeout(() => show = false, 2500));"
                x-transition:enter="transition transform ease-out duration-400"
                x-transition:enter-start="translate-y-[-100%]"
                x-transition:enter-end="translate-y-0"
                x-transition:leave="transition transform ease-in duration-300"
                x-transition:leave-start="translate-y-0"
                x-transition:leave-end="translate-y-[-100%]">
                <div class="alert alert-${type} flex justify-between items-center p-4 rounded shadow-lg text-white">
                    <span>${message}</span>
                    <button @click="show = false" class="ml-4 text-lg font-bold text-white hover:text-gray-200">
                        &times;
                    </button>
                </div>
            </div>`;

        // Ambil elemen hasil innerHTML
        const toastElement = toastContainer.firstElementChild;

        // Tambahkan toast ke dalam body
        document.body.appendChild(toastElement);

        // Inisialisasi Alpine.js untuk elemen baru
        if (typeof Alpine !== 'undefined' && Alpine.initTree) {
            Alpine.initTree(toastElement);
        }
    }

    const requestAjax = (urlRequest, dataRequet = {}, typePost, typeOutput, callbackSuccess, multipartFormdata =
        "") => {

        if (typePost == "GET") {

            fetch(urlRequest, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(result => result.json()).then(response => callbackSuccess(response));
        }

        if (typePost == "POST" || typePost == 'PUT' || typePost === "DELETE") {
            if (multipartFormdata === "") {

                fetch(urlRequest, {
                    method: typePost,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(dataRequet)
                }).then(result => result.json()).then(response => callbackSuccess(response));
            }

            if (multipartFormdata === "multipart-formdata") {

                fetch(urlRequest, {
                    method: typePost,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: dataRequet
                }).then(result => result.json()).then(response => callbackSuccess(response));
            }

            if (multipartFormdata !== "" && multipartFormdata !== "multipart-formdata") {
                showToast("error",
                    'If you upload file, parameter the last must be <strong>multipart-formdata</strong>');
                return false;
            }
        }
    }

    const formatRupiah = (number) => {
        return new Intl.NumberFormat("id-ID", {
            currency: "IDR"
        }).format(number);
    }
</script>

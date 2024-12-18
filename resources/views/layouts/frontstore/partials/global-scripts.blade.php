<script>
    document.addEventListener("DOMContentLoaded", function() {
        setLabelCarts()

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

    const getCarts = () => {
        return localStorage.getItem('carts') ? JSON.parse(localStorage.getItem('carts')) : [];
    }

    const setLabelCarts = () => {
        const carts = getCarts().length;

        let labelCarts = document.querySelector('.shopping-cart');
        let shoppingCartItem = document.querySelector('.shopping-cart-item');

        if (shoppingCartItem) shoppingCartItem.remove();

        if (carts > 0) {
            const childLabel = document.createElement('span');
            childLabel.className = 'shopping-cart-item indicator-item badge badge-secondary text-xs';
            childLabel.textContent = carts > 99 ? '99+' : carts;

            labelCarts.appendChild(childLabel);
        }
    };


    const addToCart = (id, product, price, discount, qty = 1) => {
        let carts = getCarts();

        const productIndex = carts.findIndex(item => item.product_id == id);

        if (productIndex !== -1) {
            carts[productIndex].qty += parseInt(qty);
        } else {
            carts.push({
                product_id: id,
                product: product,
                price: parseInt(price),
                discount: parseInt(discount),
                qty: parseInt(qty)
            });
        }

        localStorage.setItem('carts', JSON.stringify(carts));
    };

    const updateCart = (id, separator = '+', qty, element = null) => {

        let carts = getCarts();

        const productIndex = carts.findIndex(item => item.product_id == id);

        if (productIndex !== -1) {
            if (separator === '+') carts[productIndex].qty++;
            if (separator === '-') carts[productIndex].qty--;
            if (separator === 'input') carts[productIndex].qty = parseInt(qty);
            if (separator === 'button') carts[productIndex].qty += parseInt(qty);
        } else {
            if (element) {
                carts.push({
                    product_id: id,
                    product: element.name,
                    price: parseInt(element.price),
                    discount: parseInt(element.discount),
                    qty: parseInt(qty)
                })
            }

        }


        localStorage.setItem('carts', JSON.stringify(carts));

    }


    const removeProductCart = (id = null) => {
        let carts = getCarts();

        if (id == null) return localStorage.removeItem('carts');

        let newCart = carts.filter((item) => item.product_id != id);
        localStorage.setItem('carts', JSON.stringify(newCart));
    }

    const requestAjax = (urlRequest, dataRequet = {}, typePost, typeOutput, callbackSuccess, multipartFormdata =
        "") => {

        let headers = {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }

        if (typePost == "GET") {

            fetch(urlRequest, {
                method: 'GET',
                headers: headers
            }).then(result => result.json()).then(response => callbackSuccess(response));
        }

        if (typePost == "POST" || typePost == 'PUT' || typePost === "DELETE") {
            if (multipartFormdata === "") {

                fetch(urlRequest, {
                    method: typePost,
                    headers: headers,
                    body: JSON.stringify(dataRequet)
                }).then(result => result.json()).then(response => callbackSuccess(response));
            }

            if (multipartFormdata === "multipart-formdata") {

                fetch(urlRequest, {
                    method: typePost,
                    headers: headers,
                    body: multipartFormdata === "multipart-formdata" ? dataRequet.dataForm : JSON.stringify(
                        dataRequet)
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

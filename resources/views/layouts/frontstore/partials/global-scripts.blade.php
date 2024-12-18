<script>
    document.addEventListener("DOMContentLoaded", function() {
        setLabelCarts()
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


    const addToCart = (id, price, discount, qty = 1) => {
        let carts = getCarts();

        const productIndex = carts.findIndex(item => item.product_id == id);

        if (productIndex !== -1) {
            carts[productIndex].qty += parseInt(qty);
        } else {
            carts.push({
                product_id: id,
                price: parseInt(price),
                discount: parseInt(discount),
                qty: parseInt(qty)
            });
        }

        localStorage.setItem('carts', JSON.stringify(carts));
    };


    const removeProductCart = (id = null) => {
        let carts = getCarts();

        if (id == null) return localStorage.removeItem('carts');

        let newCart = carts.filter((item) => item.product_id != id);
        localStorage.setItem('carts', JSON.stringify(newCart));
    }
</script>

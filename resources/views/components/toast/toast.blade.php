<div class="toast toast-top toast-center z-[99999999]" x-data="{ show: true, timeout: null }" x-show="show" x-init="timeout = setTimeout(() => show = false, 3000);
$el.addEventListener('mouseenter', () => clearTimeout(timeout));
$el.addEventListener('mouseleave', () => timeout = setTimeout(() => show = false, 3000));"
    x-transition:enter="transition transform ease-out duration-400" x-transition:enter-start="translate-y-[-100%]"
    x-transition:enter-end="translate-y-0" x-transition:leave="transition transform ease-in duration-300"
    x-transition:leave-start="translate-y-0" x-transition:leave-end="translate-y-[-100%]">

    <div class="alert alert-{{ session('type') }} flex justify-between items-center p-4 rounded shadow-lg text-white">
        <span>{{ session('message') }}</span>
        <button @click="show = false" class="ml-4 text-lg font-bold text-white hover:text-gray-200">
            &times;
        </button>
    </div>
</div>

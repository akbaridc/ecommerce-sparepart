<button
    {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-4 py-2 bg-primary-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-600 focus:bg-primary-400 active:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-400 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>

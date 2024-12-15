@props(['image', 'message', 'page'])

<div class="flex flex-col justify-center items-center w-full h-full top-1/2">
    <figure>
        <img src="{{ $image }}" class="w-40 h-40" alt="image">
    </figure>
    <h4 class="font-bold">{{ $message }}</h4>

    <div class="mt-3 flex flex-col justify-center items-center mx-auto">
        <p>Masuk ke akun untuk melihat {{ $page ?? '' }}</p>
        <x-button.primary-button class="min-w-fit max-w-fit mt-3 shadow-lg py-3 px-4 mx-auto"
            @click="window.location.href = '{{ route('frontstore.akun') }}'">Masuk ke
            Akun</x-button.primary-button>
    </div>
</div>

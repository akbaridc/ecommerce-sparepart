<x-app-front-layout>
    <div class="mx-auto max-w-full px-3">
        <div class="py-2 rounded-md">
            @if (count($banners) > 0)
                <div x-data="{
                    currentIndex: 0,
                    totalSlides: {{ count($banners) }},
                    interval: null,
                    startAutoSlide() {
                        this.interval = setInterval(() => {
                            this.currentIndex = (this.currentIndex + 1) % this.totalSlides;
                        }, 3000);
                    },
                    stopAutoSlide() {
                        clearInterval(this.interval);
                        this.interval = null;
                    }
                }" x-init="startAutoSlide()" @mouseenter="stopAutoSlide()"
                    @mouseleave="startAutoSlide()"
                    class="relative w-full mx-auto overflow-hidden rounded-lg mb-7 bg-white">
                    <!-- Slider Container -->
                    <div class="flex transition-transform duration-500 ease-out"
                        :style="'transform: translateX(-' + currentIndex * 100 + '%)'">
                        @foreach ($banners as $banner)
                            <!-- Individual Slide -->
                            <div class="w-full flex-shrink-0">
                                <figure class="w-full bg-auto bg-center bg-no-repeat rounded-lg">
                                    <img src="{{ asset('storage/' . $banner->patch) }}"
                                        class="w-full h-56 object-cover object-center" alt="{{ $banner->patch }}">
                                </figure>
                            </div>
                        @endforeach
                    </div>

                    <!-- Navigation Arrows -->
                    <button x-show="totalSlides > 1"
                        class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-gray-800 bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75"
                        @click="currentIndex = (currentIndex > 0) ? currentIndex - 1 : totalSlides - 1">
                        &#10094; <!-- Left Arrow -->
                    </button>

                    <button x-show="totalSlides > 1"
                        class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-gray-800 bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-75"
                        @click="currentIndex = (currentIndex + 1) % totalSlides">
                        &#10095; <!-- Right Arrow -->
                    </button>

                    <!-- Dots Indicators -->
                    <div class="absolute bottom-2 left-0 right-0 flex justify-center space-x-2">
                        @foreach ($banners as $index => $banner)
                            <button @click="currentIndex = {{ $index }}" class="w-3 h-3 rounded-full"
                                :class="currentIndex === {{ $index }} ? 'bg-green-700' : 'bg-gray-300'">
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            <x-frontstore.list-product :categoriesProducts="$categoriesProducts" />
        </div>
    </div>
</x-app-front-layout>

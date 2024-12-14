<span x-show="!show" class="btn btn-sm btn-secondary btn-circle sticky left-0 top-1/2 z-40"
    @click="show = !show">&#10095;</span>

<aside x-show="show"
    class="w-[17%] min-h-screen bg-gray-200 text-primary px-4 py-2 flex flex-col fixed top-15 left-0 h-full">
    <span x-show="show" class="btn btn-sm btn-secondary btn-circle sticky ml-auto top-1/2 z-40"
        @click="show = !show">&#10094;</span>

    <div>
        <h1 class="font-bold text-xl">Pilih Kategori Barang</h1>
        <div class="divider"></div>
    </div>
    <!-- Navigation Menu -->
    <nav class="flex-1 overflow-y-auto h-full pb-14">
        <ul class="space-y-2">
            @forelse ($categories as $category)
                <li>
                    <a href="{{ route('frontstore.category', $category->slug) }}"
                        class="nav-item {{ request()->slug == $category->slug ? 'active' : '' }}">
                        <span>{{ $category->name }}</span>
                    </a>
                </li>
            @empty
                <li>
                    <h5>Kategori Tidak Tersedia</h5>
                </li>
            @endforelse
        </ul>
    </nav>
</aside>

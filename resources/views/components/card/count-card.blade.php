@props(['color', 'title', 'count', 'icon'])

<div class="card shadow-md bg-white rounded-md">
    <div class="card-body p-4">
        <div class="flex items-center gap-3">
            <div class="flex items-center justify-center rounded-full w-11 h-11 p-3 bg-{{ $color }}-300">
                <i class="{{ $icon }} text-lg"></i>
            </div>
            <div>
                <h3 class="text-gray-400 uppercase font-extrabold tracking-wider">{{ $title }}</h3>
                <h4 class="text-slate-500 font-semibold text-xl">{{ $count }}</h4>
            </div>
        </div>
    </div>
</div>

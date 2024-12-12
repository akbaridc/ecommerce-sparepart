<span x-show="!show" class="btn btn-md btn-secondary btn-circle absolute left-0 top-1/2 z-40" @click="show = !show">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-base">
        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
    </svg>
</span>
<span x-show="show" class="btn btn-md btn-secondary btn-circle absolute left-[23rem] top-1/2 z-40" @click="console.log('oke')">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="text-base">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
    </svg>
</span>

<aside x-show="show" class="w-[23%] min-h-screen bg-gray-200 text-primary p-4 flex flex-col fixed top-15 left-0 h-full">
    <div class="text-center">
        <h1 class="font-bold text-2xl">Pilih Kategori</h1>
        <div class="divider"></div>
    </div>
    <!-- Navigation Menu -->
    <nav class="flex-1 overflow-y-auto h-full p-4 pb-14">
        <ul class="space-y-2">
            <li>
                <a href="#dashboard" class="nav-item active">
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#profile" class="nav-item">
                    <span>Profile</span>
                </a>
            </li>
            <li>
                <a href="#settings" class="nav-item">
                    <span>Settings</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>

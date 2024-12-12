@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        <div class="flex justify-center flex-1 sm:hidden">
            <div class="join">
                {{-- Tombol Previous --}}
                @if ($paginator->onFirstPage())
                    <button class="join-item btn btn-outline" disabled>Previous</button>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" class="join-item btn btn-outline">Previous</a>
                @endif

                {{-- Halaman saat ini --}}
                <details class="join-item dropdown dropdown-top">
                    <summary class="btn bg-white text-slate-800">Page {{ $paginator->currentPage() }}</summary>
                    <ul class="dropdown-content menu bg-base-100 z-10 w-52 p-2 shadow-none">
                        @foreach (range(1, $paginator->lastPage()) as $page)
                            <li>
                                <a href="{{ $paginator->url($page) }}"
                                    class="{{ $page == $paginator->currentPage() ? 'active text-slate-800 font-bold' : '' }}">
                                    Page {{ $page }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </details>

                {{-- Tombol Next --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" class="join-item btn btn-outline">Next</a>
                @else
                    <button class="join-item btn btn-outline" disabled>Next</button>
                @endif
            </div>
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700 leading-5">
                    {!! __('Showing') !!}
                    @if ($paginator->firstItem())
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        {!! __('to') !!}
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    {!! __('of') !!}
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex rtl:flex-row-reverse shadow-sm rounded-md">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span
                                class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-slate-600 bg-gray-300 border border-gray-300 cursor-not-allowed rounded-l-md leading-5 "
                                aria-hidden="true">
                                Previous
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                            class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md leading-5 hover:text-slate-600 hover:bg-sky-200 focus:z-10 focus:outline-none focus:ring ring-sky-300 focus:border-blue-300 active:bg-gray-300 active:text-white transition ease-in-out duration-150 "
                            aria-label="{{ __('pagination.previous') }}">
                            Previous
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span
                                    class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5 ">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span
                                            class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-white bg-sky-500 border border-gray-300 cursor-not-allowed leading-5 ">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}"
                                        class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-white hover:bg-sky-300 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-sky-500 active:text-white transition ease-in-out duration-150 "
                                        aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                            class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-slate-600 hover:bg-sky-200 focus:z-10 focus:outline-none focus:ring ring-sky-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 "
                            aria-label="{{ __('pagination.next') }}">
                            Next
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span
                                class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-slate-600 bg-gray-300 border border-gray-300 cursor-not-allowed rounded-r-md leading-5 "
                                aria-hidden="true">
                                Next
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif

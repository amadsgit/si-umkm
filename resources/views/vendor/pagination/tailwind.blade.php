@if ($paginator->hasPages())
<nav role="navigation" aria-label="Pagination" class="flex items-center justify-between mt-4">
    <div class="flex-1 flex justify-between sm:hidden">
        {{-- Tombol Prev (Mobile) --}}
        @if ($paginator->onFirstPage())
        <span class="px-3 py-2 rounded-lg bg-gray-200 text-gray-400 text-sm">‹ Prev</span>
        @else
        <a href="{{ $paginator->previousPageUrl() }}"
            class="px-3 py-2 rounded-lg bg-sky-600 text-white hover:bg-sky-700 text-sm">‹ Prev</a>
        @endif

        {{-- Tombol Next (Mobile) --}}
        @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}"
            class="ml-3 px-3 py-2 rounded-lg bg-sky-600 text-white hover:bg-sky-700 text-sm">Next ›</a>
        @else
        <span class="ml-3 px-3 py-2 rounded-lg bg-gray-200 text-gray-400 text-sm">Next ›</span>
        @endif
    </div>

    {{-- Desktop --}}
    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
        <div>
            <p class="text-sm text-gray-600">
                Menampilkan
                <span class="font-medium">{{ $paginator->firstItem() }}</span>
                sampai
                <span class="font-medium">{{ $paginator->lastItem() }}</span>
                dari
                <span class="font-medium">{{ $paginator->total() }}</span>
                data
            </p>
        </div>

        <div>
            <ul class="inline-flex items-center space-x-1">
                {{-- Tombol Prev --}}
                @if ($paginator->onFirstPage())
                <li><span class="px-3 py-2 rounded-lg bg-gray-200 text-gray-400">‹</span></li>
                @else
                <li><a href="{{ $paginator->previousPageUrl() }}"
                        class="px-3 py-2 rounded-lg bg-sky-600 text-white hover:bg-sky-700">‹</a></li>
                @endif

                {{-- Nomor Halaman --}}
                @foreach ($elements as $element)
                @if (is_string($element))
                <li><span class="px-3 py-2 rounded-lg bg-gray-100 text-gray-600">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                <li><span class="px-3 py-2 rounded-lg bg-sky-600 text-white">{{ $page }}</span></li>
                @else
                <li><a href="{{ $url }}"
                        class="px-3 py-2 rounded-lg bg-white border text-sky-600 hover:bg-sky-50">{{ $page
                        }}</a></li>
                @endif
                @endforeach
                @endif
                @endforeach

                {{-- Tombol Next --}}
                @if ($paginator->hasMorePages())
                <li><a href="{{ $paginator->nextPageUrl() }}"
                        class="px-3 py-2 rounded-lg bg-sky-600 text-white hover:bg-sky-700">›</a></li>
                @else
                <li><span class="px-3 py-2 rounded-lg bg-gray-200 text-gray-400">›</span></li>
                @endif
            </ul>
        </div>
    </div>
</nav>
@endif
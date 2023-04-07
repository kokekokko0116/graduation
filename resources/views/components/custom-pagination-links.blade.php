@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        <div class="flex justify-center">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">{{ __('previous') }}</span>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500" aria-label="{{ __('pagination.previous') }}">{{ __('previous') }}</a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span aria-disabled="true"><span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-semibold text-gray-700 bg-white border border-gray-300 cursor-default leading-5 rounded-md">{{ $element }}</span></span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span aria-current="page"><span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-semibold text-gray-500 bg-gray-200 border border-gray-300 cursor-default leading-5 rounded-md">{{ $page }}</span></span>
                        @else
                            <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-semibold text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 hover:bg-gray-50" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-semibold text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 hover:bg-gray-50" aria-label="{{ __('pagination.next') }}">{{ __('next') }}</a>
            @else
                <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                    <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-semibold text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">{{ __('next') }}</span>
                </span>
            @endif
        </div>
    </nav>
@endif

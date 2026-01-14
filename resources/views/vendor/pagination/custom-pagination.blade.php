@if ($paginator->hasPages())
    <nav class="flex flex-col md:flex-row items-center justify-between p-3 gap-3" aria-label="Table navigation">
        <span class="text-sm font-normal text-gray-500 block w-full md:inline md:w-auto text-center md:text-start">
            Menampilkan <span class="font-semibold text-gray-900">{{ $paginator->firstItem() }}-{{ $paginator->lastItem() }}</span>
            dari <span class="font-semibold text-gray-900">{{ $paginator->total() }}</span>
        </span>
        <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg cursor-not-allowed">@lang('pagination.previous')</span>
                </li>
            @else
                <li>
                    <button type="button" wire:click="previousPage" wire:loading.attr="disabled"
                        class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700" rel="prev">@lang('pagination.previous')</button>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li aria-disabled="true"><span class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 cursor-not-allowed">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li aria-current="page"><span class="flex items-center justify-center px-3 h-8 leading-tight text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700">{{ $page }}</span></li>
                        @else
                            <li><button type="button" wire:click="gotoPage({{ $page }})" wire:loading.attr="disabled"
                                class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">{{ $page }}</button></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <button type="button" wire:click="nextPage" wire:loading.attr="disabled"
                        class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700" rel="next">@lang('pagination.next')</button>
                </li>
            @else
                <li aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg cursor-not-allowed">@lang('pagination.next')</span>
                </li>
            @endif
        </ul>
    </nav>
@endif

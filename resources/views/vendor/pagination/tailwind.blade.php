@if ($paginator->hasPages())
    <div class="intro-y flex flex-wrap sm:flex-row sm:flex-nowrap items-center mt-3" aria-label="{{ __('Pagination Navigation') }}" >
        <nav class="w-full sm:w-auto sm:mr-auto">
            <ul class="pagination">
{{--                Previous page--}}
                <li class="page-item">
                    <a class="page-link" href="{{ !$paginator->onFirstPage() ? $paginator->previousPageUrl() : 'javascript:;'}}">
                        <i class="w-4 h-4" data-lucide="chevron-left"></i>
                    </a>
                </li>
                    {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="page-item">
                            <a class="page-link" href="javascript:;">...</a>
                        </li>
                    @endif
                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active">
                                    <a class="page-link" href="javascript:;">{{ $page }}</a>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

{{--                    Next page--}}
                <li class="page-item">
                    <a class="page-link" href="{{$paginator->hasMorePages() ? $paginator->nextPageUrl() : 'javascript:;' }}">
                        <i class="w-4 h-4" data-lucide="chevron-right"></i>
                    </a>
                </li>
            </ul>
        </nav>

{{--        Showing how many?--}}
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
    </div>
@endif

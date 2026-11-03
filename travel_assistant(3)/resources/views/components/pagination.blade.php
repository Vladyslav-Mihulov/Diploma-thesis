@if ($paginator->hasPages())
    <nav class="filter-tabs pagination" aria-label="Pagination">
        @if ($paginator->onFirstPage())
            <span class="filter-tab disabled">←</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="filter-tab" rel="prev">←</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="filter-tab disabled">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="filter-tab active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="filter-tab">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="filter-tab" rel="next">→</a>
        @else
            <span class="filter-tab disabled">→</span>
        @endif
    </nav>
@endif

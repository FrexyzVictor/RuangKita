@if ($paginator->hasPages())
<nav style="display:flex;align-items:center;justify-content:center;gap:4px" role="navigation" aria-label="Pagination">

    {{-- Previous --}}
    @if ($paginator->onFirstPage())
        <span class="btn btn-sm btn-ghost" style="opacity:.4;cursor:not-allowed">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
        </span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-sm btn-ghost">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
        </a>
    @endif

    {{-- Page Numbers --}}
    @foreach ($elements as $element)
        @if (is_string($element))
            <span class="btn btn-sm btn-ghost" style="opacity:.5">{{ $element }}</span>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="btn btn-sm btn-primary" style="min-width:34px">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="btn btn-sm btn-ghost" style="min-width:34px">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-sm btn-ghost">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                <polyline points="9 18 15 12 9 6"/>
            </svg>
        </a>
    @else
        <span class="btn btn-sm btn-ghost" style="opacity:.4;cursor:not-allowed">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14">
                <polyline points="9 18 15 12 9 6"/>
            </svg>
        </span>
    @endif

</nav>
@endif
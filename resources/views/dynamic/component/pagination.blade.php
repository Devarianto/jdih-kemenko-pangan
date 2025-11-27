@if($paginator->hasPages())
<div class="pagination">
    {{-- Previous Page Link --}}
    @if($paginator->onFirstPage())
    <!-- <a href="javascript:void(0);" class="arr prev disabled"></a> -->
    @else
    <a href="{{ $paginator->previousPageUrl() }}" class="arr prev"></a>
    @endif

    @foreach ($elements as $element)

        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                <a href="{{ $url }}" class="active">{{ $page }}</a>
                @else                        
                <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next Page Link --}}
    @if($paginator->hasMorePages())
    <a href="{{ $paginator->nextPageUrl() }}" class="arr next"></a>
    @else
    <!-- <a href="javascript:void(0);" class="arr next disabled"></a> -->
    @endif
</div>
@endif
<div class="card-footer clearfix">
    <span class="text-light-blue">Found <b>{{ $paginator->total() }}</b> entries</span>
    @if ($paginator->hasPages())
    <ul class="pagination pagination m-0 float-right mt-3">
        @if (!$paginator->onFirstPage())
        <li class="page-item">
            <a class="page-link" href="{{ $paginator->previousPageUrl() }}">«</a>
        </li>
        @endif
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item disabled" aria-disabled="true">{{ $element }}</li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><a class="page-link page-active">{{ $page }}</a></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach
        @if ($paginator->hasMorePages())
       <li class="page-item">
            <a class="page-link" href="{{ $paginator->nextPageUrl() }}">»</a>
        </li>
        @endif
    </ul>
    @endif
</div>
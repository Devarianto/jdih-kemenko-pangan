@if ($paginator->hasPages())
    <nav style="display: flex; align-items: center; gap: 6px; flex-wrap: wrap; justify-content: center;">

        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span class="page-btn page-btn-disabled">‹ Sebelumnya</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="page-btn">‹ Sebelumnya</a>
        @endif

        {{-- Page numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="page-btn page-btn-dots">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="page-btn page-btn-active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="page-btn">Selanjutnya ›</a>
        @else
            <span class="page-btn page-btn-disabled">Selanjutnya ›</span>
        @endif

    </nav>

    <style>
        .page-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 34px;
            height: 34px;
            padding: 0 10px;
            border-radius: 7px;
            border: 1px solid #dadfe8;
            background: #fff;
            color: #2d3a55;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.15s ease, transform 0.1s ease;
        }
        .page-btn:hover {
            background: #f0f3fb;
            transform: translateY(-1px);
        }
        .page-btn-active {
            background: #0d1b3e;
            color: #fff;
            border-color: #0d1b3e;
        }
        .page-btn-disabled {
            color: #c3c8d4;
            cursor: not-allowed;
            background: #f7f8fa;
        }
        .page-btn-dots {
            border: none;
            background: transparent;
            color: #9aa1b1;
        }
    </style>
@endif

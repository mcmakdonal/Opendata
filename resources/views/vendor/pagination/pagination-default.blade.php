<div class="fl" style="margin: 20px 0;">
    จำนวนทั้งหมด {{ $paginator->total() }}
</div>

<div class="fr">
    @if ($paginator->hasPages())
    <ul class="pagination" role="navigation">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled" aria-disabled="true">
                <a aria-hidden="true">ก่อนหน้า</a>
            </li>
        @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev">ก่อนหน้า</a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled" aria-disabled="true"><a>{{ $element }}</a></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active" aria-current="page"><a>{{ $page }}</a></li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}" rel="next">ถัดไป</a>
            </li>
        @else
            <li class="disabled" aria-disabled="true">
                <a aria-hidden="true">ถัดไป</a>
            </li>
        @endif
    </ul>
@endif
</div>


@if ($paginator->hasPages())
<nav style="display:flex;align-items:center;gap:5px;flex-wrap:wrap;">
    @if ($paginator->onFirstPage())
        <span style="display:inline-flex;align-items:center;padding:6px 11px;border:1.5px solid #e2e8f0;border-radius:7px;font-size:13px;color:#94a3b8;cursor:default;">← Prev</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" style="display:inline-flex;align-items:center;padding:6px 11px;border:1.5px solid #e2e8f0;border-radius:7px;font-size:13px;color:#4f46e5;text-decoration:none;transition:all .15s;">← Prev</a>
    @endif

    @foreach ($elements as $element)
        @if (is_string($element))
            <span style="padding:6px 4px;color:#94a3b8;font-size:13px;">{{ $element }}</span>
        @endif
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span style="display:inline-flex;align-items:center;padding:6px 11px;background:#4f46e5;border:1.5px solid #4f46e5;border-radius:7px;font-size:13px;font-weight:600;color:#fff;">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" style="display:inline-flex;align-items:center;padding:6px 11px;border:1.5px solid #e2e8f0;border-radius:7px;font-size:13px;color:#0f172a;text-decoration:none;transition:all .15s;">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" style="display:inline-flex;align-items:center;padding:6px 11px;border:1.5px solid #e2e8f0;border-radius:7px;font-size:13px;color:#4f46e5;text-decoration:none;transition:all .15s;">Next →</a>
    @else
        <span style="display:inline-flex;align-items:center;padding:6px 11px;border:1.5px solid #e2e8f0;border-radius:7px;font-size:13px;color:#94a3b8;cursor:default;">Next →</span>
    @endif

    <span style="margin-left:6px;font-size:12px;color:#94a3b8;">
        {{ $paginator->firstItem() }}-{{ $paginator->lastItem() }} dari {{ $paginator->total() }}
    </span>
</nav>
@endif

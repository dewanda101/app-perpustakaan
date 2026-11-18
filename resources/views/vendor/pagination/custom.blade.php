@if ($paginator->hasPages())
<nav style="display:flex;align-items:center;gap:6px;flex-wrap:wrap;" aria-label="Navigasi Halaman">
    @if ($paginator->onFirstPage())
        <span style="display:inline-flex;align-items:center;padding:5px 10px;border:1px solid var(--border);border-radius:var(--radius);font-size:12.5px;color:var(--text-light);cursor:default;">Sebelumnya</span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" style="display:inline-flex;align-items:center;padding:5px 10px;border:1px solid var(--border);border-radius:var(--radius);font-size:12.5px;color:var(--text);text-decoration:none;transition:background .15s ease;">Sebelumnya</a>
    @endif

    @foreach ($elements as $element)
        @if (is_string($element))
            <span style="padding:5px 4px;color:var(--text-light);font-size:12.5px;">{{ $element }}</span>
        @endif
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span style="display:inline-flex;align-items:center;padding:5px 10px;background:var(--primary);border:1px solid var(--primary);border-radius:var(--radius);font-size:12.5px;font-weight:600;color:#fff;font-variant-numeric:tabular-nums;">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" style="display:inline-flex;align-items:center;padding:5px 10px;border:1px solid var(--border);border-radius:var(--radius);font-size:12.5px;color:var(--text);text-decoration:none;transition:background .15s ease;font-variant-numeric:tabular-nums;">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" style="display:inline-flex;align-items:center;padding:5px 10px;border:1px solid var(--border);border-radius:var(--radius);font-size:12.5px;color:var(--text);text-decoration:none;transition:background .15s ease;">Berikutnya</a>
    @else
        <span style="display:inline-flex;align-items:center;padding:5px 10px;border:1px solid var(--border);border-radius:var(--radius);font-size:12.5px;color:var(--text-light);cursor:default;">Berikutnya</span>
    @endif

    <span style="margin-left:8px;font-size:12px;color:var(--text-muted);font-variant-numeric:tabular-nums;">
        {{ $paginator->firstItem() }}&ndash;{{ $paginator->lastItem() }} dari {{ $paginator->total() }}
    </span>
</nav>
@endif

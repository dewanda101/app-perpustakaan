@extends('layouts.app')
@section('title', 'Dashboard - Perpustakaan Digital Kampus')
@section('page_title', 'Dashboard')
@section('content')

{{-- ── Stats Cards ──────────────────────────────────────────── --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-ic ic-blue">📚</div>
        <div>
            <div class="stat-val" data-count="{{ $stats['total_buku'] }}">0</div>
            <div class="stat-lbl">Total Buku</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-ic ic-grn">👥</div>
        <div>
            <div class="stat-val" data-count="{{ $stats['total_anggota'] }}">0</div>
            <div class="stat-lbl">Total Anggota</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-ic ic-org">📋</div>
        <div>
            <div class="stat-val" data-count="{{ $stats['peminjaman_aktif'] }}">0</div>
            <div class="stat-lbl">Peminjaman Aktif</div>
        </div>
    </div>
    @if($overdue_count > 0)
    <div class="stat-card" style="border-left:3px solid #ef4444;">
        <div class="stat-ic" style="background:rgba(239,68,68,0.1);color:#ef4444;">⚠️</div>
        <div>
            <div class="stat-val" data-count="{{ $overdue_count }}" style="color:#ef4444;">0</div>
            <div class="stat-lbl" style="color:#ef4444;">Terlambat</div>
        </div>
    </div>
    @endif
</div>

{{-- ── Quick Access ─────────────────────────────────────────── --}}
<div style="margin-top:8px;display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:14px;">
    <a href="{{ route('books.index') }}" class="stat-card" style="text-decoration:none;">
        <div class="stat-ic ic-blue">📖</div>
        <div><div style="font-size:14px;font-weight:600;color:var(--text);">Kelola Buku</div><div style="font-size:12px;color:var(--text-muted);margin-top:2px;">Tambah, edit, hapus data buku</div></div>
    </a>
    <a href="{{ route('members.index') }}" class="stat-card" style="text-decoration:none;">
        <div class="stat-ic ic-grn">👤</div>
        <div><div style="font-size:14px;font-weight:600;color:var(--text);">Kelola Anggota</div><div style="font-size:12px;color:var(--text-muted);margin-top:2px;">Data mahasiswa peminjam</div></div>
    </a>
    <a href="{{ route('loans.create') }}" class="stat-card" style="text-decoration:none;">
        <div class="stat-ic ic-org">➕</div>
        <div><div style="font-size:14px;font-weight:600;color:var(--text);">Transaksi Baru</div><div style="font-size:12px;color:var(--text-muted);margin-top:2px;">Catat peminjaman buku</div></div>
    </a>
    <a href="{{ route('loans.report') }}" class="stat-card" style="text-decoration:none;">
        <div class="stat-ic ic-pur">📊</div>
        <div><div style="font-size:14px;font-weight:600;color:var(--text);">Laporan</div><div style="font-size:12px;color:var(--text-muted);margin-top:2px;">Riwayat seluruh peminjaman</div></div>
    </a>
</div>

{{-- ── Charts Row ───────────────────────────────────────────── --}}
<div style="display:grid;grid-template-columns:1fr 1.8fr;gap:18px;margin-top:22px;">

    {{-- Donut Chart: Status Distribusi --}}
    <div class="card">
        <div class="card-hd"><h2>📊 Status Peminjaman</h2></div>
        <div class="card-bd" style="display:flex;flex-direction:column;align-items:center;gap:20px;">
            @if($total_loans > 0)
            {{-- Donut wrapper --}}
            <div style="position:relative;width:200px;height:200px;">
                <canvas id="donutChart" width="200" height="200"></canvas>
                <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;pointer-events:none;">
                    <div style="font-size:28px;font-weight:700;color:var(--text);">{{ $total_loans }}</div>
                    <div style="font-size:11px;color:var(--text-muted);font-weight:500;">Total</div>
                </div>
            </div>
            {{-- Legend --}}
            <div style="width:100%;display:flex;flex-direction:column;gap:10px;">
                <div style="display:flex;align-items:center;justify-content:space-between;padding:8px 12px;background:#dbeafe;border-radius:8px;">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <div style="width:10px;height:10px;border-radius:50%;background:#3b82f6;"></div>
                        <span style="font-size:13px;font-weight:500;color:#1e40af;">Dipinjam</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;">
                        <span style="font-size:14px;font-weight:700;color:#1e40af;">{{ $dipinjam }}</span>
                        <span style="font-size:11px;color:#3b82f6;background:#bfdbfe;padding:2px 6px;border-radius:20px;">{{ $total_loans > 0 ? round($dipinjam/$total_loans*100) : 0 }}%</span>
                    </div>
                </div>
                <div style="display:flex;align-items:center;justify-content:space-between;padding:8px 12px;background:#dcfce7;border-radius:8px;">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <div style="width:10px;height:10px;border-radius:50%;background:#22c55e;"></div>
                        <span style="font-size:13px;font-weight:500;color:#15803d;">Dikembalikan</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;">
                        <span style="font-size:14px;font-weight:700;color:#15803d;">{{ $dikembalikan }}</span>
                        <span style="font-size:11px;color:#16a34a;background:#bbf7d0;padding:2px 6px;border-radius:20px;">{{ $total_loans > 0 ? round($dikembalikan/$total_loans*100) : 0 }}%</span>
                    </div>
                </div>
                <div style="display:flex;align-items:center;justify-content:space-between;padding:8px 12px;background:#fee2e2;border-radius:8px;">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <div style="width:10px;height:10px;border-radius:50%;background:#ef4444;"></div>
                        <span style="font-size:13px;font-weight:500;color:#b91c1c;">Terlambat</span>
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;">
                        <span style="font-size:14px;font-weight:700;color:#b91c1c;">{{ $terlambat }}</span>
                        <span style="font-size:11px;color:#dc2626;background:#fecaca;padding:2px 6px;border-radius:20px;">{{ $total_loans > 0 ? round($terlambat/$total_loans*100) : 0 }}%</span>
                    </div>
                </div>
            </div>
            @else
            <div style="text-align:center;color:var(--text-muted);padding:40px 0;">
                <div style="font-size:40px;margin-bottom:10px;">📋</div>
                <div style="font-size:14px;">Belum ada data peminjaman</div>
            </div>
            @endif
        </div>
    </div>

    {{-- Bar Chart: Peminjaman per Bulan --}}
    <div class="card">
        <div class="card-hd">
            <h2>📈 Tren Peminjaman</h2>
            <span style="font-size:12px;color:var(--text-muted);font-weight:400;">6 bulan terakhir</span>
        </div>
        <div class="card-bd" style="position:relative;height:280px;">
            <canvas id="barChart"></canvas>
        </div>
    </div>

</div>

{{-- ── Circular Progress Indicators ───────────────────────────── --}}
@if($total_loans > 0)
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-top:18px;">
    @php
        $items = [
            ['label'=>'Dipinjam',     'value'=>$dipinjam,     'pct'=>round($dipinjam/$total_loans*100),     'color'=>'#3b82f6','bg'=>'#dbeafe','txt'=>'#1e40af'],
            ['label'=>'Dikembalikan', 'value'=>$dikembalikan, 'pct'=>round($dikembalikan/$total_loans*100), 'color'=>'#22c55e','bg'=>'#dcfce7','txt'=>'#15803d'],
            ['label'=>'Terlambat',    'value'=>$terlambat,    'pct'=>round($terlambat/$total_loans*100),    'color'=>'#ef4444','bg'=>'#fee2e2','txt'=>'#b91c1c'],
        ];
    @endphp
    @foreach($items as $item)
    <div class="card" style="text-align:center;">
        <div class="card-bd" style="display:flex;flex-direction:column;align-items:center;gap:14px;padding:24px 16px;">
            {{-- SVG Ring --}}
            <div style="position:relative;width:110px;height:110px;">
                <svg width="110" height="110" viewBox="0 0 110 110" style="transform:rotate(-90deg)">
                    <circle cx="55" cy="55" r="45" fill="none" stroke="{{ $item['bg'] }}" stroke-width="10"/>
                    <circle cx="55" cy="55" r="45" fill="none"
                        stroke="{{ $item['color'] }}" stroke-width="10"
                        stroke-dasharray="{{ round(2 * 3.14159 * 45) }}"
                        stroke-dashoffset="{{ round(2 * 3.14159 * 45 * (1 - $item['pct']/100)) }}"
                        stroke-linecap="round"
                        style="transition: stroke-dashoffset 1.2s ease;"/>
                </svg>
                <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;">
                    <div style="font-size:20px;font-weight:700;color:{{ $item['txt'] }};">{{ $item['pct'] }}%</div>
                </div>
            </div>
            <div>
                <div style="font-size:22px;font-weight:700;color:{{ $item['txt'] }};">{{ $item['value'] }}</div>
                <div style="font-size:13px;color:var(--text-muted);margin-top:2px;">{{ $item['label'] }}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

{{-- ── Peminjaman Terbaru ───────────────────────────────────── --}}
@if($recent_loans->count() > 0)
<div class="card" style="margin-top:18px;">
    <div class="card-hd">
        <h2>🕐 Peminjaman Terbaru</h2>
        <a href="{{ route('loans.index') }}" class="btn btn-sm btn-out">Lihat Semua →</a>
    </div>
    <div class="tbl-wrap">
        <table>
            <thead>
                <tr><th>Anggota</th><th>Buku</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Status</th></tr>
            </thead>
            <tbody>
            @foreach($recent_loans as $loan)
            <tr data-due="{{ $loan->tanggal_kembali }}" data-status="{{ $loan->status }}">
                <td style="font-weight:500;">{{ $loan->member->nama }}</td>
                <td style="max-width:200px;">
                    @foreach($loan->loanItems as $item)
                    <span style="display:inline-block;background:#f1f5f9;border-radius:4px;padding:2px 7px;font-size:11.5px;margin:1px;">{{ $item->book->judul }}</span>
                    @endforeach
                </td>
                <td style="font-size:13px;color:var(--text-muted);">{{ $loan->tanggal_pinjam }}</td>
                <td data-due-cell style="font-size:13px;">{{ $loan->tanggal_kembali }}</td>
                <td><span class="badge badge-{{ $loan->status }}">{{ ucfirst($loan->status) }}</span></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- ── Chart.js CDN + init ──────────────────────────────────── --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {

    // ── Helpers for dark mode aware colors ──
    const isDark = () => document.getElementById('html-root').classList.contains('dark');
    const textColor   = () => isDark() ? '#94a3b8' : '#64748b';
    const gridColor   = () => isDark() ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';
    const surfaceColor= () => isDark() ? '#1e293b' : '#ffffff';

    // ── Donut Chart ──────────────────────────────────────────
    @if($total_loans > 0)
    const donutCtx = document.getElementById('donutChart');
    if (donutCtx) {
        new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                labels: ['Dipinjam', 'Dikembalikan', 'Terlambat'],
                datasets: [{
                    data: [{{ $dipinjam }}, {{ $dikembalikan }}, {{ $terlambat }}],
                    backgroundColor: ['#3b82f6', '#22c55e', '#ef4444'],
                    borderColor: surfaceColor(),
                    borderWidth: 3,
                    hoverOffset: 6,
                }]
            },
            options: {
                cutout: '72%',
                responsive: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: ctx => ` ${ctx.label}: ${ctx.raw} (${Math.round(ctx.raw/{{ $total_loans }}*100)}%)`
                        }
                    }
                },
                animation: { animateRotate: true, duration: 1000 }
            }
        });
    }
    @endif

    // ── Bar Chart ────────────────────────────────────────────
    const barCtx = document.getElementById('barChart');
    if (barCtx) {
        const labels = @json(array_values($bulan_labels));
        const data   = @json(array_values($bulan_data));

        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: 'Peminjaman',
                    data,
                    backgroundColor: 'rgba(79,70,229,0.75)',
                    borderColor: '#4f46e5',
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: textColor(), font: { size: 12, family: 'Inter' } },
                        border: { display: false }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: textColor(),
                            font: { size: 12, family: 'Inter' },
                            stepSize: 1,
                            precision: 0
                        },
                        grid: { color: gridColor() },
                        border: { display: false }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e1b4b',
                        titleColor: '#c7d2fe',
                        bodyColor: '#fff',
                        padding: 12,
                        cornerRadius: 10,
                        callbacks: {
                            label: ctx => ` ${ctx.raw} peminjaman`
                        }
                    }
                },
                animation: { duration: 900, easing: 'easeOutQuart' }
            }
        });
    }

});
</script>

@endsection

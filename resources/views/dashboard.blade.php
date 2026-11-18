@extends('layouts.app')
@section('title', 'Dashboard - Perpustakaan Digital Kampus PENS')
@section('page_title', 'Dashboard')
@section('content')

{{-- ── Ringkasan Statistik ────────────────────────────────── --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-ic ic-blue" aria-hidden="true">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/>
                <path d="M6 6h10"/>
                <path d="M6 10h10"/>
            </svg>
        </div>
        <div>
            <div class="stat-val" data-count="{{ $stats['total_buku'] }}">{{ $stats['total_buku'] }}</div>
            <div class="stat-lbl">Total Judul Buku</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-ic ic-grn" aria-hidden="true">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
        </div>
        <div>
            <div class="stat-val" data-count="{{ $stats['total_anggota'] }}">{{ $stats['total_anggota'] }}</div>
            <div class="stat-lbl">Anggota Terdaftar</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-ic ic-org" aria-hidden="true">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/>
                <rect x="8" y="2" width="8" height="4" rx="1" ry="1"/>
                <path d="M9 14h6"/>
                <path d="M9 18h6"/>
                <path d="M9 10h6"/>
            </svg>
        </div>
        <div>
            <div class="stat-val" data-count="{{ $stats['peminjaman_aktif'] }}">{{ $stats['peminjaman_aktif'] }}</div>
            <div class="stat-lbl">Peminjaman Aktif</div>
        </div>
    </div>

    @if($overdue_count > 0)
    <div class="stat-card" style="border-left:3px solid var(--danger);">
        <div class="stat-ic ic-red" aria-hidden="true">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
        </div>
        <div>
            <div class="stat-val" data-count="{{ $overdue_count }}" style="color:var(--danger);">{{ $overdue_count }}</div>
            <div class="stat-lbl" style="color:var(--danger);font-weight:600;">Jatuh Tempo</div>
        </div>
    </div>
    @endif
</div>

{{-- ── Aksi Cepat ─────────────────────────────────────────── --}}
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(210px,1fr));gap:14px;margin-bottom:20px;">
    <a href="{{ route('books.index') }}" class="stat-card" style="text-decoration:none;">
        <div class="stat-ic ic-blue" aria-hidden="true">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/>
                <path d="M6 6h10"/>
                <path d="M6 10h10"/>
            </svg>
        </div>
        <div>
            <div style="font-size:13.5px;font-weight:600;color:var(--text);">Katalog Buku</div>
            <div style="font-size:12px;color:var(--text-muted);margin-top:2px;">Kelola koleksi pustaka</div>
        </div>
    </a>
    <a href="{{ route('members.index') }}" class="stat-card" style="text-decoration:none;">
        <div class="stat-ic ic-grn" aria-hidden="true">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
            </svg>
        </div>
        <div>
            <div style="font-size:13.5px;font-weight:600;color:var(--text);">Data Anggota</div>
            <div style="font-size:12px;color:var(--text-muted);margin-top:2px;">Data mahasiswa peminjam</div>
        </div>
    </a>
    <a href="{{ route('loans.create') }}" class="stat-card" style="text-decoration:none;">
        <div class="stat-ic ic-org" aria-hidden="true">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
        </div>
        <div>
            <div style="font-size:13.5px;font-weight:600;color:var(--text);">Catat Peminjaman</div>
            <div style="font-size:12px;color:var(--text-muted);margin-top:2px;">Transaksi sirkulasi baru</div>
        </div>
    </a>
    <a href="{{ route('loans.report') }}" class="stat-card" style="text-decoration:none;">
        <div class="stat-ic ic-blue" aria-hidden="true">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="20" x2="12" y2="10"/>
                <line x1="18" y1="20" x2="18" y2="4"/>
                <line x1="6" y1="20" x2="6" y2="16"/>
            </svg>
        </div>
        <div>
            <div style="font-size:13.5px;font-weight:600;color:var(--text);">Laporan Sirkulasi</div>
            <div style="font-size:12px;color:var(--text-muted);margin-top:2px;">Rekapitulasi riwayat transaksi</div>
        </div>
    </a>
</div>

{{-- ── Grafik dan Distribusi Status ───────────────────────── --}}
<div style="display:grid;grid-template-columns:1fr 1.6fr;gap:18px;margin-bottom:20px;">

    {{-- Donut Chart: Status Distribusi --}}
    <div class="card" style="margin-bottom:0;">
        <div class="card-hd">
            <h2>Distribusi Status Sirkulasi</h2>
        </div>
        <div class="card-bd" style="display:flex;flex-direction:column;align-items:center;gap:18px;">
            @if($total_loans > 0)
            <div style="position:relative;width:190px;height:190px;">
                <canvas id="donutChart" width="190" height="190"></canvas>
                <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;pointer-events:none;">
                    <div style="font-size:24px;font-weight:700;color:var(--text);font-variant-numeric:tabular-nums;">{{ $total_loans }}</div>
                    <div style="font-size:11px;color:var(--text-muted);font-weight:500;">Total Transaksi</div>
                </div>
            </div>

            {{-- Legend List --}}
            <div style="width:100%;display:flex;flex-direction:column;gap:8px;">
                <div style="display:flex;align-items:center;justify-content:space-between;padding:8px 12px;background:var(--primary-light);border-radius:4px;">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <span style="width:8px;height:8px;border-radius:2px;background:#1d4ed8;"></span>
                        <span style="font-size:13px;font-weight:500;color:var(--text);">Dipinjam</span>
                    </div>
                    <div style="font-size:13px;font-weight:600;color:var(--text);font-variant-numeric:tabular-nums;">
                        {{ $dipinjam }} ({{ $total_loans > 0 ? round($dipinjam/$total_loans*100) : 0 }}%)
                    </div>
                </div>

                <div style="display:flex;align-items:center;justify-content:space-between;padding:8px 12px;background:var(--success-light);border-radius:4px;">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <span style="width:8px;height:8px;border-radius:2px;background:#15803d;"></span>
                        <span style="font-size:13px;font-weight:500;color:var(--text);">Dikembalikan</span>
                    </div>
                    <div style="font-size:13px;font-weight:600;color:var(--text);font-variant-numeric:tabular-nums;">
                        {{ $dikembalikan }} ({{ $total_loans > 0 ? round($dikembalikan/$total_loans*100) : 0 }}%)
                    </div>
                </div>

                <div style="display:flex;align-items:center;justify-content:space-between;padding:8px 12px;background:var(--danger-light);border-radius:4px;">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <span style="width:8px;height:8px;border-radius:2px;background:#b91c1c;"></span>
                        <span style="font-size:13px;font-weight:500;color:var(--text);">Jatuh Tempo</span>
                    </div>
                    <div style="font-size:13px;font-weight:600;color:var(--text);font-variant-numeric:tabular-nums;">
                        {{ $terlambat }} ({{ $total_loans > 0 ? round($terlambat/$total_loans*100) : 0 }}%)
                    </div>
                </div>
            </div>
            @else
            <div style="text-align:center;padding:36px 12px;color:var(--text-muted);">
                <p style="font-size:13.5px;margin-bottom:12px;">Belum ada data sirkulasi peminjaman.</p>
                <a href="{{ route('loans.create') }}" class="btn btn-sm">Catat Transaksi Pertama</a>
            </div>
            @endif
        </div>
    </div>

    {{-- Bar Chart: Peminjaman per Bulan --}}
    <div class="card" style="margin-bottom:0;">
        <div class="card-hd">
            <h2>Grafik Frekuensi Peminjaman</h2>
            <span style="font-size:12px;color:var(--text-muted);">6 bulan terakhir</span>
        </div>
        <div class="card-bd" style="position:relative;height:290px;">
            <canvas id="barChart"></canvas>
        </div>
    </div>

</div>

{{-- ── Persentase Sirkulasi ────────────────────────────────── --}}
@if($total_loans > 0)
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:20px;">
    @php
        $progressItems = [
            ['label'=>'Sedang Dipinjam', 'value'=>$dipinjam,     'pct'=>round($dipinjam/$total_loans*100),     'color'=>'#1d4ed8','bg'=>'#e2e8f0'],
            ['label'=>'Selesai Kembali', 'value'=>$dikembalikan, 'pct'=>round($dikembalikan/$total_loans*100), 'color'=>'#15803d','bg'=>'#e2e8f0'],
            ['label'=>'Jatuh Tempo',     'value'=>$terlambat,    'pct'=>round($terlambat/$total_loans*100),    'color'=>'#b91c1c','bg'=>'#e2e8f0'],
        ];
    @endphp
    @foreach($progressItems as $item)
    <div class="card" style="text-align:center;margin-bottom:0;">
        <div class="card-bd" style="display:flex;flex-direction:column;align-items:center;gap:12px;padding:20px 14px;">
            <div style="position:relative;width:96px;height:96px;">
                <svg width="96" height="96" viewBox="0 0 96 96" style="transform:rotate(-90deg)" aria-hidden="true">
                    <circle cx="48" cy="48" r="40" fill="none" stroke="{{ $item['bg'] }}" stroke-width="8"/>
                    <circle cx="48" cy="48" r="40" fill="none"
                        stroke="{{ $item['color'] }}" stroke-width="8"
                        stroke-dasharray="{{ round(2 * 3.14159 * 40) }}"
                        stroke-dashoffset="{{ round(2 * 3.14159 * 40 * (1 - $item['pct']/100)) }}"
                        stroke-linecap="round"/>
                </svg>
                <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;">
                    <div style="font-size:18px;font-weight:700;color:var(--text);font-variant-numeric:tabular-nums;">{{ $item['pct'] }}%</div>
                </div>
            </div>
            <div>
                <div style="font-size:20px;font-weight:700;color:var(--text);font-variant-numeric:tabular-nums;">{{ $item['value'] }}</div>
                <div style="font-size:12.5px;color:var(--text-muted);margin-top:2px;">{{ $item['label'] }}</div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

{{-- ── Peminjaman Terbaru ───────────────────────────────────── --}}
@if($recent_loans->count() > 0)
<div class="card">
    <div class="card-hd">
        <h2>Transaksi Peminjaman Terbaru</h2>
        <a href="{{ route('loans.index') }}" class="btn btn-sm btn-out">Semua Transaksi</a>
    </div>
    <div class="tbl-wrap">
        <table>
            <thead>
                <tr>
                    <th>Peminjam</th>
                    <th>Judul Buku</th>
                    <th>Tanggal Pinjam</th>
                    <th>Batas Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            @foreach($recent_loans as $loan)
            <tr data-due="{{ $loan->tanggal_kembali }}" data-status="{{ $loan->status }}">
                <td style="font-weight:500;">{{ $loan->member->nama }}</td>
                <td style="max-width:240px;">
                    @foreach($loan->loanItems as $item)
                    <span style="display:inline-block;background:var(--bg);border:1px solid var(--border);border-radius:4px;padding:2px 7px;font-size:12px;margin:1px;">
                        {{ $item->book->judul }}
                    </span>
                    @endforeach
                </td>
                <td style="font-size:13px;color:var(--text-muted);font-variant-numeric:tabular-nums;">{{ $loan->tanggal_pinjam }}</td>
                <td data-due-cell style="font-size:13px;font-variant-numeric:tabular-nums;">{{ $loan->tanggal_kembali }}</td>
                <td><span class="badge badge-{{ $loan->status }}">{{ ucfirst($loan->status) }}</span></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- ── Chart.js Script ─────────────────────────────────────── --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const isDark = () => document.getElementById('html-root').classList.contains('dark');
    const textColor = () => isDark() ? '#94a3b8' : '#475569';
    const gridColor = () => isDark() ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';
    const surfaceColor = () => isDark() ? '#131d31' : '#ffffff';

    @if($total_loans > 0)
    const donutCtx = document.getElementById('donutChart');
    if (donutCtx) {
        new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                labels: ['Dipinjam', 'Dikembalikan', 'Jatuh Tempo'],
                datasets: [{
                    data: [{{ $dipinjam }}, {{ $dikembalikan }}, {{ $terlambat }}],
                    backgroundColor: ['#1d4ed8', '#15803d', '#b91c1c'],
                    borderColor: surfaceColor(),
                    borderWidth: 2,
                    hoverOffset: 4,
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
                animation: { duration: 600 }
            }
        });
    }
    @endif

    const barCtx = document.getElementById('barChart');
    if (barCtx) {
        const labels = @json(array_values($bulan_labels));
        const data   = @json(array_values($bulan_data));

        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: 'Transaksi',
                    data,
                    backgroundColor: '#1d4ed8',
                    borderRadius: 4,
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
                        backgroundColor: '#0f294a',
                        titleColor: '#e2e8f0',
                        bodyColor: '#fff',
                        padding: 10,
                        cornerRadius: 6,
                        callbacks: {
                            label: ctx => ` ${ctx.raw} transaksi peminjaman`
                        }
                    }
                },
                animation: { duration: 500 }
            }
        });
    }
});
</script>

@endsection

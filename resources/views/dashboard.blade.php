@extends('layouts.app')
@section('title', 'Dashboard - Perpustakaan Digital Kampus PENS')
@section('page_title', 'Dashboard')
@section('content')

{{-- ── 1. Top Header & Meta Information ─────────────────────── --}}
<div class="ph" style="margin-bottom:20px;">
    <div>
        <h1 style="font-size:22px;font-weight:700;color:var(--text);letter-spacing:-0.01em;">Dashboard Perpustakaan</h1>
        <div class="sub" style="font-size:13px;color:var(--text-muted);margin-top:2px;">
            Sistem Informasi Sirkulasi & Koleksi Digital Kampus PENS &bull; {{ now()->translatedFormat('l, d F Y') }}
        </div>
    </div>
    <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
        <a href="{{ route('loans.create') }}" class="btn">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            <span>Transaksi Baru</span>
        </a>
        <a href="{{ route('reports.index') }}" class="btn btn-out">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <line x1="18" y1="20" x2="18" y2="10"/>
                <line x1="12" y1="20" x2="12" y2="4"/>
                <line x1="6" y1="20" x2="6" y2="14"/>
            </svg>
            <span>Laporan Sirkulasi</span>
        </a>
    </div>
</div>

{{-- ── 2. Ringkasan Metrik Statistik Utama (Stat Cards) ──────── --}}
<div class="stats-grid" style="margin-bottom:22px;">
    <div class="stat-card">
        <div class="stat-ic ic-blue" aria-hidden="true">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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

    <div class="stat-card" style="{{ $overdue_count > 0 ? 'border-left:3px solid var(--danger);' : '' }}">
        <div class="stat-ic ic-red" aria-hidden="true">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
        </div>
        <div>
            <div class="stat-val" data-count="{{ $overdue_count }}" style="{{ $overdue_count > 0 ? 'color:var(--danger);' : '' }}">
                {{ $overdue_count }}
            </div>
            <div class="stat-lbl" style="{{ $overdue_count > 0 ? 'color:var(--danger);font-weight:600;' : '' }}">
                Telat Mengembalikan
            </div>
        </div>
    </div>
</div>

{{-- ── 3. Row 1: Grafik Bulanan & 5 Mahasiswa Telat ───────────── --}}
<div class="dash-grid-top" style="display:grid;grid-template-columns:1.35fr 1fr;gap:20px;margin-bottom:22px;align-items:start;">

    {{-- Kiri: Jumlah Buku Yang Dipinjam Dalam Setiap Bulan --}}
    <div class="card" style="margin-bottom:0;">
        <div class="card-hd" style="display:flex;justify-content:space-between;align-items:center;">
            <div>
                <h2 style="font-size:15px;font-weight:700;color:var(--text);">Jumlah Buku Yang Dipinjam</h2>
                <div style="font-size:12px;color:var(--text-muted);margin-top:2px;">Dalam Setiap Bulan (Tahun {{ now()->year }})</div>
            </div>
            <div style="display:inline-flex;align-items:center;gap:6px;background:var(--primary-light);padding:4px 10px;border-radius:4px;font-size:11.5px;font-weight:600;color:var(--primary);">
                <span style="width:8px;height:8px;border-radius:50%;background:var(--primary);display:inline-block;"></span>
                <span>Jumlah Buku</span>
            </div>
        </div>
        <div class="card-bd" style="padding:16px 20px 20px;">
            <div style="position:relative;height:290px;width:100%;">
                <canvas id="monthlyBookChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Kanan: 5 Data Mahasiswa Telat Mengembalikan Buku --}}
    <div class="card" style="margin-bottom:0;">
        <div class="card-hd" style="display:flex;justify-content:space-between;align-items:center;">
            <div>
                <h2 style="font-size:15px;font-weight:700;color:var(--text);">5 Data Mahasiswa Telat Mengembalikan</h2>
                <div style="font-size:12px;color:var(--text-muted);margin-top:2px;">Peminjaman melewati tanggal jatuh tempo</div>
            </div>
            <a href="{{ route('reports.index', ['status' => 'proses']) }}" class="btn btn-sm btn-out" style="font-size:11.5px;padding:3px 8px;">
                Lihat Semua
            </a>
        </div>
        <div class="tbl-wrap">
            <table style="width:100%;font-size:12.5px;">
                <thead>
                    <tr>
                        <th style="width:36px;text-align:center;">No</th>
                        <th>Nama Peminjam</th>
                        <th>NIM</th>
                        <th style="text-align:center;">Buku</th>
                        <th style="text-align:right;">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($late_students as $idx => $lateLoan)
                @php
                    $dueDate = \Carbon\Carbon::parse($lateLoan->tanggal_kembali)->startOfDay();
                    $today   = \Carbon\Carbon::now()->startOfDay();
                    $days    = $today->gt($dueDate) ? $dueDate->diffInDays($today) : 0;
                    $bukuCount = $lateLoan->loanItems->count();
                @endphp
                <tr>
                    <td style="text-align:center;color:var(--text-muted);font-variant-numeric:tabular-nums;">{{ $idx + 1 }}</td>
                    <td>
                        <div style="font-weight:600;color:var(--text);">{{ $lateLoan->member->nama }}</div>
                        <div style="font-size:11px;color:var(--danger);font-variant-numeric:tabular-nums;">
                            @if($days > 0)
                                Terlambat {{ $days }} hari
                            @else
                                Batas hari ini
                            @endif
                        </div>
                    </td>
                    <td style="font-variant-numeric:tabular-nums;color:var(--text-muted);font-size:12px;">
                        {{ $lateLoan->member->nim }}
                    </td>
                    <td style="text-align:center;">
                        <span style="display:inline-block;padding:2px 8px;border-radius:4px;font-size:11px;font-weight:700;background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;font-variant-numeric:tabular-nums;">
                            {{ $bukuCount }} buku
                        </span>
                    </td>
                    <td style="text-align:right;">
                        <a href="{{ route('reports.create', ['loan_id' => $lateLoan->id]) }}"
                           class="btn-hapus"
                           title="Buat Berita Acara Insiden / Denda"
                           style="padding:3px 7px;font-size:11.5px;text-decoration:none;display:inline-flex;align-items:center;gap:3px;">
                            <span>Lapor</span>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:36px 16px;color:var(--text-muted);">
                        <div style="font-size:13px;font-weight:500;color:var(--success);">
                            Semua sirkulasi tepat waktu
                        </div>
                        <div style="font-size:12px;margin-top:2px;">
                            Tidak ada mahasiswa yang terlambat mengembalikan buku saat ini.
                        </div>
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- ── 4. Row 2: 5 Data Buku Yang Sering Dipinjam (Hits Teratas) --}}
<div class="card" style="margin-bottom:22px;">
    <div class="card-hd" style="display:flex;justify-content:space-between;align-items:center;">
        <div>
            <h2 style="font-size:15px;font-weight:700;color:var(--text);">5 Data Buku Yang Sering Dipinjam</h2>
            <div style="font-size:12px;color:var(--text-muted);margin-top:2px;">Daftar buku dengan frekuensi sirkulasi peminjaman tertinggi (*hits*)</div>
        </div>
        <a href="{{ route('books.index') }}" class="btn btn-sm btn-out" style="font-size:12px;">
            Katalog Buku Lengkap
        </a>
    </div>
    <div class="tbl-wrap">
        <table style="width:100%;font-size:13px;">
            <thead>
                <tr>
                    <th style="width:40px;text-align:center;">No</th>
                    <th style="width:60px;text-align:center;">Gambar</th>
                    <th>Nama Buku / Judul</th>
                    <th>Pengarang</th>
                    <th>Penerbit</th>
                    <th>ISBN</th>
                    <th style="width:140px;text-align:right;">Hits / Sirkulasi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($top_books as $bIdx => $book)
            <tr>
                <td style="text-align:center;color:var(--text-muted);font-variant-numeric:tabular-nums;font-weight:600;">
                    {{ $bIdx + 1 }}
                </td>
                <td style="text-align:center;">
                    @if($book->sampul)
                        <img src="{{ asset('storage/' . $book->sampul) }}" alt="Sampul {{ $book->judul }}"
                             style="width:34px;height:46px;object-fit:cover;border-radius:4px;border:1px solid var(--border);box-shadow:0 1px 2px rgba(0,0,0,0.06);">
                    @else
                        <div style="width:34px;height:46px;margin:0 auto;background:var(--bg);border:1px solid var(--border);border-radius:4px;display:flex;align-items:center;justify-content:center;color:var(--text-muted);" aria-hidden="true">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75">
                                <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/>
                            </svg>
                        </div>
                    @endif
                </td>
                <td>
                    <div style="font-weight:600;color:var(--text);">{{ $book->judul }}</div>
                    @if($book->category)
                        <span style="display:inline-block;margin-top:2px;font-size:11px;padding:1px 6px;border-radius:3px;background:var(--bg);border:1px solid var(--border);color:var(--text-muted);">
                            {{ $book->category->nama_kategori }}
                        </span>
                    @endif
                </td>
                <td style="color:var(--text-muted);">{{ $book->penulis }}</td>
                <td>
                    <div style="color:var(--text);">{{ $book->penerbit }}</div>
                    <div style="font-size:11.5px;color:var(--text-muted);font-variant-numeric:tabular-nums;">Tahun: {{ $book->tahun_terbit }}</div>
                </td>
                <td style="font-variant-numeric:tabular-nums;color:var(--text-muted);font-size:12.5px;">
                    {{ $book->isbn }}
                </td>
                <td style="text-align:right;">
                    <span style="display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:4px;font-size:12px;font-weight:700;background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;font-variant-numeric:tabular-nums;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M2 12h20"/>
                            <path d="M20 12l-4-4"/>
                            <path d="M20 12l-4 4"/>
                        </svg>
                        <span>{{ $book->loan_items_count }}x peminjaman</span>
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;padding:36px 16px;color:var(--text-muted);">
                    Belum ada data koleksi buku yang dipinjam.
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ── 5. Row 3: Distribusi Status & Transaksi Peminjaman Terkini ── --}}
<div class="dash-grid-bottom" style="display:grid;grid-template-columns:1fr 1.6fr;gap:20px;margin-bottom:20px;">

    {{-- Kiri: Distribusi Status Sirkulasi (Donut & Presentase Bulat) --}}
    <div class="card" style="margin-bottom:0;">
        <div class="card-hd">
            <h2 style="font-size:15px;font-weight:700;color:var(--text);">Distribusi Status Sirkulasi</h2>
        </div>
        <div class="card-bd" style="display:flex;flex-direction:column;align-items:center;gap:18px;">
            @if($total_loans > 0)
            <div style="position:relative;width:170px;height:170px;">
                <canvas id="donutChart" width="170" height="170"></canvas>
                <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);text-align:center;pointer-events:none;">
                    <div style="font-size:22px;font-weight:700;color:var(--text);font-variant-numeric:tabular-nums;">{{ $total_loans }}</div>
                    <div style="font-size:10.5px;color:var(--text-muted);font-weight:500;">Total Transaksi</div>
                </div>
            </div>

            {{-- Legend List --}}
            <div style="width:100%;display:flex;flex-direction:column;gap:8px;">
                <div style="display:flex;align-items:center;justify-content:space-between;padding:7px 12px;background:var(--primary-light);border-radius:4px;">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <span style="width:8px;height:8px;border-radius:2px;background:#1d4ed8;"></span>
                        <span style="font-size:12.5px;font-weight:500;color:var(--text);">Sedang Dipinjam</span>
                    </div>
                    <div style="font-size:12.5px;font-weight:700;color:var(--text);font-variant-numeric:tabular-nums;">
                        {{ $dipinjam }} ({{ $total_loans > 0 ? round($dipinjam/$total_loans*100) : 0 }}%)
                    </div>
                </div>

                <div style="display:flex;align-items:center;justify-content:space-between;padding:7px 12px;background:var(--success-light);border-radius:4px;">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <span style="width:8px;height:8px;border-radius:2px;background:#15803d;"></span>
                        <span style="font-size:12.5px;font-weight:500;color:var(--text);">Selesai Dikembalikan</span>
                    </div>
                    <div style="font-size:12.5px;font-weight:700;color:var(--text);font-variant-numeric:tabular-nums;">
                        {{ $dikembalikan }} ({{ $total_loans > 0 ? round($dikembalikan/$total_loans*100) : 0 }}%)
                    </div>
                </div>

                <div style="display:flex;align-items:center;justify-content:space-between;padding:7px 12px;background:var(--danger-light);border-radius:4px;">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <span style="width:8px;height:8px;border-radius:2px;background:#b91c1c;"></span>
                        <span style="font-size:12.5px;font-weight:500;color:var(--text);">Jatuh Tempo / Terlambat</span>
                    </div>
                    <div style="font-size:12.5px;font-weight:700;color:var(--text);font-variant-numeric:tabular-nums;">
                        {{ $terlambat }} ({{ $total_loans > 0 ? round($terlambat/$total_loans*100) : 0 }}%)
                    </div>
                </div>
            </div>
            @else
            <div style="text-align:center;padding:36px 12px;color:var(--text-muted);">
                <p style="font-size:13px;margin-bottom:12px;">Belum ada data sirkulasi peminjaman.</p>
                <a href="{{ route('loans.create') }}" class="btn btn-sm">Catat Transaksi Pertama</a>
            </div>
            @endif
        </div>
    </div>

    {{-- Kanan: Transaksi Peminjaman Terbaru --}}
    <div class="card" style="margin-bottom:0;">
        <div class="card-hd" style="display:flex;justify-content:space-between;align-items:center;">
            <div>
                <h2 style="font-size:15px;font-weight:700;color:var(--text);">Transaksi Peminjaman Terbaru</h2>
                <div style="font-size:12px;color:var(--text-muted);margin-top:2px;">Riwayat peminjaman koleksi terkini</div>
            </div>
            <a href="{{ route('loans.index') }}" class="btn btn-sm btn-out" style="font-size:12px;">
                Semua Transaksi
            </a>
        </div>
        <div class="tbl-wrap">
            <table style="width:100%;font-size:12.5px;">
                <thead>
                    <tr>
                        <th>Peminjam</th>
                        <th>Koleksi Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Batas Kembali</th>
                        <th style="text-align:center;">Status</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($recent_loans as $loan)
                <tr data-due="{{ $loan->tanggal_kembali }}" data-status="{{ $loan->status }}">
                    <td style="font-weight:600;color:var(--text);">
                        {{ $loan->member->nama }}
                        <div style="font-size:11px;color:var(--text-muted);font-variant-numeric:tabular-nums;">NIM: {{ $loan->member->nim }}</div>
                    </td>
                    <td style="max-width:210px;">
                        @foreach($loan->loanItems as $item)
                        <span style="display:inline-block;background:var(--bg);border:1px solid var(--border);border-radius:3px;padding:2px 6px;font-size:11.5px;margin:1px;">
                            {{ $item->book->judul }}
                        </span>
                        @endforeach
                    </td>
                    <td style="font-variant-numeric:tabular-nums;color:var(--text-muted);">{{ $loan->tanggal_pinjam }}</td>
                    <td data-due-cell style="font-variant-numeric:tabular-nums;font-weight:600;color:var(--text);">{{ $loan->tanggal_kembali }}</td>
                    <td style="text-align:center;">
                        <span class="badge badge-{{ $loan->status }}">{{ ucfirst($loan->status) }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;padding:36px 16px;color:var(--text-muted);">
                        Belum ada riwayat transaksi peminjaman.
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- ── 6. Responsive Query untuk Dashboard Grid ──────────────── --}}
<style>
@media (max-width: 960px) {
    .dash-grid-top, .dash-grid-bottom {
        grid-template-columns: 1fr !important;
    }
}
</style>

{{-- ── 7. Chart.js Script ────────────────────────────────────── --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const isDark = () => document.getElementById('html-root') && document.getElementById('html-root').classList.contains('dark');
    const textColor = () => isDark() ? '#94a3b8' : '#475569';
    const gridColor = () => isDark() ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';
    const surfaceColor = () => isDark() ? '#131d31' : '#ffffff';

    // ── 1. Area Line Chart: Jumlah Buku Yang Dipinjam Dalam Setiap Bulan ──
    const monthlyCtx = document.getElementById('monthlyBookChart');
    if (monthlyCtx) {
        const labels = @json($monthly_labels);
        const data   = @json($monthly_data);

        const ctx = monthlyCtx.getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 270);
        gradient.addColorStop(0, 'rgba(29, 78, 216, 0.35)');
        gradient.addColorStop(1, 'rgba(29, 78, 216, 0.00)');

        new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Buku',
                    data: data,
                    borderColor: '#1d4ed8',
                    borderWidth: 2.5,
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.35,
                    pointBackgroundColor: '#1d4ed8',
                    pointBorderColor: surfaceColor(),
                    pointBorderWidth: 2,
                    pointRadius: 4.5,
                    pointHoverRadius: 6.5,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: {
                            color: textColor(),
                            font: { size: 11, family: 'Inter', weight: 500 }
                        },
                        border: { display: false }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: textColor(),
                            font: { size: 11, family: 'Inter' },
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
                        bodyColor: '#ffffff',
                        padding: 10,
                        cornerRadius: 6,
                        displayColors: false,
                        callbacks: {
                            label: ctx => ` Jumlah Buku: ${ctx.raw} buku dipinjam`
                        }
                    }
                },
                animation: { duration: 600 }
            }
        });
    }

    // ── 2. Donut Chart: Status Distribusi ──
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
});
</script>

@endsection

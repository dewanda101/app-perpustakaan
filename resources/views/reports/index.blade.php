@extends('layouts.app')
@section('title', 'Laporan Sirkulasi & Insiden - Perpustakaan Digital Kampus PENS')
@section('page_title', 'Laporan Sirkulasi & Insiden')
@section('content')

{{-- ── Header & Aksi Utama ────────────────────────────────── --}}
<div class="ph">
    <div>
        <h1>Laporan Sirkulasi & Masalah Buku</h1>
        <div class="sub">Pencatatan insiden keterlambatan, buku rusak, atau hilang beserta berita acara</div>
    </div>
    <div style="display:flex;gap:10px;flex-wrap:wrap;">
        <a href="{{ route('reports.create') }}" class="btn">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <line x1="12" y1="5" x2="12" y2="19"/>
                <line x1="5" y1="12" x2="19" y2="12"/>
            </svg>
            <span>Tambah Laporan Baru</span>
        </a>
        <a href="{{ route('reports.print', request()->query()) }}" target="_blank" class="btn btn-out" style="background:var(--surface);">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <polyline points="6 9 6 2 18 2 18 9"/>
                <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
                <rect x="6" y="14" width="12" height="8"/>
            </svg>
            <span>Cetak Rekapitulasi</span>
        </a>
    </div>
</div>

{{-- ── Ringkasan Metrik Laporan ────────────────────────────── --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-ic ic-blue" aria-hidden="true">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <line x1="16" y1="13" x2="8" y2="13"/>
                <line x1="16" y1="17" x2="8" y2="17"/>
            </svg>
        </div>
        <div>
            <div class="stat-val">{{ $stats['total_laporan'] }}</div>
            <div class="stat-lbl">Total Laporan Tercatat</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-ic ic-org" aria-hidden="true">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <polyline points="12 6 12 12 16 14"/>
            </svg>
        </div>
        <div>
            <div class="stat-val">{{ $stats['total_terlambat'] }}</div>
            <div class="stat-lbl">Kasus Keterlambatan</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-ic ic-red" aria-hidden="true">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                <line x1="12" y1="9" x2="12" y2="13"/>
                <line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
        </div>
        <div>
            <div class="stat-val">{{ $stats['total_rusak_hilang'] }}</div>
            <div class="stat-lbl">Buku Rusak / Hilang</div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-ic ic-grn" aria-hidden="true">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="4" width="20" height="16" rx="2"/>
                <line x1="12" y1="8" x2="12" y2="16"/>
                <line x1="8" y1="12" x2="16" y2="12"/>
            </svg>
        </div>
        <div>
            <div class="stat-val" style="font-size:20px;">Rp {{ number_format($stats['total_denda'], 0, ',', '.') }}</div>
            <div class="stat-lbl">Total Denda / Ganti Rugi</div>
        </div>
    </div>
</div>

{{-- ── Peringatan Real-Time Peminjaman Jatuh Tempo ─────────── --}}
@if($realtime_overdue_loans->count() > 0)
<div class="card" style="border-left:3px solid var(--danger);margin-bottom:18px;">
    <div class="card-hd" style="background:var(--danger-light);">
        <h2 style="color:var(--danger);font-size:14px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <span>Deteksi Real-Time: Peminjaman Melewati Batas Waktu</span>
        </h2>
        <span style="font-size:12px;color:var(--danger);font-weight:600;">Perlu Penanganan</span>
    </div>
    <div class="tbl-wrap">
        <table>
            <thead>
                <tr>
                    <th>Peminjam</th>
                    <th>Judul Buku</th>
                    <th>Batas Pengembalian</th>
                    <th>Status Hari Ini</th>
                    <th style="text-align:right;">Tindakan Cepat</th>
                </tr>
            </thead>
            <tbody>
            @foreach($realtime_overdue_loans as $ovLoan)
            @php
                $dueDate = \Carbon\Carbon::parse($ovLoan->tanggal_kembali)->startOfDay();
                $today   = \Carbon\Carbon::now()->startOfDay();
                $diff    = $today->diffInDays($dueDate);
            @endphp
            <tr>
                <td style="font-weight:500;">
                    {{ $ovLoan->member->nama }}
                    <span style="color:var(--text-muted);font-size:12px;display:block;">NIM: {{ $ovLoan->member->nim }}</span>
                </td>
                <td style="max-width:260px;">
                    @foreach($ovLoan->loanItems as $item)
                    <span style="display:inline-block;background:var(--bg);border:1px solid var(--border);border-radius:4px;padding:2px 6px;font-size:12px;margin:1px;">
                        {{ $item->book->judul }}
                    </span>
                    @endforeach
                </td>
                <td style="font-variant-numeric:tabular-nums;color:var(--danger);font-weight:600;">
                    {{ $ovLoan->tanggal_kembali }}
                </td>
                <td>
                    <span class="badge badge-terlambat">
                        Terlambat {{ $diff }} hari
                    </span>
                </td>
                <td style="text-align:right;">
                    <a href="{{ route('reports.create', ['loan_id' => $ovLoan->id]) }}" class="btn btn-sm" style="font-size:12px;padding:4px 10px;">
                        Buat Berita Acara
                    </a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- ── Filter & Pencarian Laporan ──────────────────────────── --}}
<div class="card" style="padding:14px 18px;margin-bottom:16px;">
    <form method="GET" action="{{ route('reports.index') }}" style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
        <div style="flex:1;min-width:220px;">
            <input type="text" name="search" value="{{ $search ?? '' }}"
                   placeholder="Cari nomor laporan, nama peminjam, atau judul buku..."
                   aria-label="Cari laporan"
                   style="width:100%;padding:7px 11px;font-size:13px;">
        </div>

        <div style="width:170px;">
            <select name="jenis" onchange="this.form.submit()" aria-label="Filter jenis kejadian" style="padding:7px 10px;font-size:13px;">
                <option value="">Semua Jenis Kejadian</option>
                <option value="terlambat" @selected($jenis === 'terlambat')>Keterlambatan</option>
                <option value="rusak_ringan" @selected($jenis === 'rusak_ringan')>Buku Rusak Ringan</option>
                <option value="rusak_berat" @selected($jenis === 'rusak_berat')>Buku Rusak Berat</option>
                <option value="hilang" @selected($jenis === 'hilang')>Buku Hilang</option>
                <option value="lainnya" @selected($jenis === 'lainnya')>Kasus Lainnya</option>
            </select>
        </div>

        <div style="width:160px;">
            <select name="status" onchange="this.form.submit()" aria-label="Filter status penyelesaian" style="padding:7px 10px;font-size:13px;">
                <option value="">Semua Status</option>
                <option value="proses" @selected($status === 'proses')>Dalam Proses</option>
                <option value="selesai" @selected($status === 'selesai')>Selesai / Lunas</option>
                <option value="bebas_denda" @selected($status === 'bebas_denda')>Bebas Denda</option>
            </select>
        </div>

        <button type="submit" class="btn btn-sm">Filter</button>
        @if($search || $jenis || $status)
        <a href="{{ route('reports.index') }}" class="btn btn-sm btn-out">Reset</a>
        @endif
    </form>
</div>

{{-- ── Tabel Data Laporan (CRUD) ───────────────────────────── --}}
<div class="card">
    <div class="tbl-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width:48px;">No</th>
                    <th>Nomor Laporan</th>
                    <th>Peminjam</th>
                    <th>Judul Buku</th>
                    <th>Jenis Kejadian</th>
                    <th>Kondisi & Keterangan</th>
                    <th>Denda / Ganti Rugi</th>
                    <th>Status</th>
                    <th style="width:190px;text-align:right;">Tindakan</th>
                </tr>
            </thead>
            <tbody>
            @forelse($reports as $rep)
            <tr>
                <td style="color:var(--text-light);font-size:12px;font-variant-numeric:tabular-nums;">
                    {{ $loop->iteration + ($reports->currentPage() - 1) * $reports->perPage() }}
                </td>
                <td>
                    <a href="{{ route('reports.show', $rep->id) }}" style="font-weight:600;color:var(--primary);text-decoration:none;font-variant-numeric:tabular-nums;">
                        {{ $rep->nomor_laporan }}
                    </a>
                    <div style="font-size:11.5px;color:var(--text-muted);font-variant-numeric:tabular-nums;">{{ $rep->tanggal_laporan->format('d/m/Y') }}</div>
                </td>
                <td>
                    <div style="font-weight:500;">{{ $rep->loan->member->nama ?? 'Anggota dihapus' }}</div>
                    <div style="font-size:12px;color:var(--text-muted);font-variant-numeric:tabular-nums;">NIM: {{ $rep->loan->member->nim ?? '-' }}</div>
                </td>
                <td style="max-width:200px;">
                    @if($rep->loan)
                        @foreach($rep->loan->loanItems as $item)
                        <span style="display:inline-block;background:var(--bg);border:1px solid var(--border);border-radius:4px;padding:2px 6px;font-size:11.5px;margin:1px;">
                            {{ $item->book->judul }}
                        </span>
                        @endforeach
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if($rep->jenis_kejadian === 'terlambat')
                        <span class="badge badge-terlambat">Keterlambatan</span>
                    @elseif($rep->jenis_kejadian === 'hilang')
                        <span class="badge" style="background:#7f1d1d;color:#fee2e2;">Buku Hilang</span>
                    @elseif(str_starts_with($rep->jenis_kejadian, 'rusak'))
                        <span class="badge" style="background:#ea580c;color:#fff;">Buku Rusak</span>
                    @else
                        <span class="badge badge-nonaktif">{{ ucfirst($rep->jenis_kejadian) }}</span>
                    @endif
                </td>
                <td style="max-width:220px;font-size:12.5px;">
                    <div style="font-weight:500;color:var(--text);">{{ $rep->kondisi_buku }}</div>
                    <div style="color:var(--text-muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;" title="{{ $rep->alasan_keterangan }}">
                        {{ $rep->alasan_keterangan }}
                    </div>
                </td>
                <td style="font-variant-numeric:tabular-nums;font-weight:600;">
                    @if($rep->total_denda > 0)
                        Rp {{ number_format($rep->total_denda, 0, ',', '.') }}
                    @else
                        <span style="color:var(--text-muted);font-weight:400;">Rp 0</span>
                    @endif
                </td>
                <td>
                    @if($rep->status_penyelesaian === 'selesai')
                        <span class="badge badge-dikembalikan">Selesai / Lunas</span>
                    @elseif($rep->status_penyelesaian === 'bebas_denda')
                        <span class="badge badge-aktif">Bebas Denda</span>
                    @else
                        <span class="badge badge-terlambat">Dalam Proses</span>
                    @endif
                </td>
                <td>
                    <div class="aksi-wrap" style="justify-content:flex-end;">
                        <a href="{{ route('reports.show', $rep->id) }}" class="btn-detail" title="Lihat Berita Acara & Cetak">
                            Lihat & Cetak
                        </a>
                        <a href="{{ route('reports.edit', $rep->id) }}" class="btn-edit" title="Ubah status laporan">
                            Edit
                        </a>
                        <form class="inline" action="{{ route('reports.destroy', $rep->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-hapus" title="Hapus laporan">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align:center;padding:48px 16px;">
                    @if($search || $jenis || $status)
                        <div style="color:var(--text-muted);font-size:14px;margin-bottom:12px;">
                            Tidak ditemukan laporan yang sesuai dengan kriteria filter Anda.
                        </div>
                        <a href="{{ route('reports.index') }}" class="btn btn-sm btn-out">Reset Filter</a>
                    @else
                        <div style="color:var(--text-muted);font-size:14px;margin-bottom:12px;">
                            Belum ada laporan insiden buku atau keterlambatan yang tercatat.
                        </div>
                        <a href="{{ route('reports.create') }}" class="btn btn-sm">Buat Laporan Baru</a>
                    @endif
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="pg-wrap">{{ $reports->links() }}</div>
</div>

@endsection

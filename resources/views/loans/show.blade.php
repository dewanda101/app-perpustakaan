@extends('layouts.app')
@section('title', 'Rincian Transaksi Peminjaman - Perpustakaan Digital Kampus PENS')
@section('page_title', 'Rincian Peminjaman')
@section('content')
<a href="{{ route('loans.index') }}" class="back-lnk">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <line x1="19" y1="12" x2="5" y2="12"/>
        <polyline points="12 19 5 12 12 5"/>
    </svg>
    <span>Kembali ke daftar peminjaman</span>
</a>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;align-items:start;">
    <div class="card">
        <div class="card-hd">
            <h2>Informasi Transaksi Sirkulasi</h2>
        </div>
        <div class="card-bd">
            <table class="dtbl">
                <tr>
                    <th>Peminjam</th>
                    <td>
                        <strong>{{ $loan['member']['nama'] }}</strong><br>
                        <span style="font-size:12px;color:var(--text-muted);font-variant-numeric:tabular-nums;">NIM: {{ $loan['member']['nim'] }}</span>
                    </td>
                </tr>
                <tr>
                    <th>Petugas Pencatat</th>
                    <td>{{ $loan['user']['name'] }}</td>
                </tr>
                <tr>
                    <th>Tanggal Pinjam</th>
                    <td style="font-variant-numeric:tabular-nums;">{{ $loan['tanggal_pinjam'] }}</td>
                </tr>
                <tr>
                    <th>Batas Kembali</th>
                    <td style="font-variant-numeric:tabular-nums;">{{ $loan['tanggal_kembali'] }}</td>
                </tr>
                <tr>
                    <th>Tgl Pengembalian</th>
                    <td style="font-variant-numeric:tabular-nums;">{{ $loan['tanggal_dikembalikan'] ?: 'Belum dikembalikan' }}</td>
                </tr>
                <tr>
                    <th>Status Saat Ini</th>
                    <td><span class="badge badge-{{ $loan['status'] }}">{{ ucfirst($loan['status']) }}</span></td>
                </tr>
            </table>

            <div style="margin-top:18px;display:flex;gap:8px;flex-wrap:wrap;padding-top:14px;border-top:1px solid var(--border);">
                <a href="{{ route('loans.edit', $loan['id']) }}" class="btn btn-sm btn-out">
                    Ubah Status
                </a>
                <a href="{{ route('reports.create', ['loan_id' => $loan['id']]) }}" class="btn btn-sm" style="background:#b91c1c;border-color:#b91c1c;color:#ffffff;">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                        <line x1="12" y1="9" x2="12" y2="13"/>
                        <line x1="12" y1="17" x2="12.01" y2="17"/>
                    </svg>
                    <span>Lapor Insiden / Denda</span>
                </a>
                @if($loan['status'] === 'dipinjam')
                <form class="inline" action="{{ route('loans.kembalikan', $loan['id']) }}" method="POST" onsubmit="return confirm('Konfirmasi pengembalian koleksi buku ini?')">
                    @csrf @method('PUT')
                    <button type="submit" class="btn btn-sm btn-ok">
                        Konfirmasi Pengembalian
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>

    <div style="display:flex;flex-direction:column;gap:18px;">
        <div class="card">
            <div class="card-hd">
                <h2>Koleksi Buku yang Dipinjam</h2>
            </div>
            <div class="tbl-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Judul Buku</th>
                            <th>Penulis</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($loan['loanItems'] as $item)
                    <tr>
                        <td style="font-weight:500;">{{ $item['book']['judul'] }}</td>
                        <td style="color:var(--text-muted);">{{ $item['book']['penulis'] }}</td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if(isset($loan->reports) && $loan->reports->isNotEmpty())
        <div class="card">
            <div class="card-hd">
                <h2>Riwayat Berita Acara & Laporan Terkait</h2>
            </div>
            <div class="tbl-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No. Laporan</th>
                            <th>Masalah</th>
                            <th>Total Beban</th>
                            <th>Status</th>
                            <th style="text-align:right;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($loan->reports as $rep)
                    <tr>
                        <td style="font-weight:600;font-variant-numeric:tabular-nums;">{{ $rep->nomor_laporan }}</td>
                        <td>
                            <span style="font-weight:600;text-transform:capitalize;">{{ str_replace('_', ' ', $rep->jenis_kejadian) }}</span><br>
                            <span style="font-size:11.5px;color:var(--text-muted);">{{ $rep->kondisi_buku }}</span>
                        </td>
                        <td style="font-variant-numeric:tabular-nums;font-weight:600;">
                            Rp {{ number_format($rep->total_denda, 0, ',', '.') }}
                        </td>
                        <td>
                            <span class="badge badge-{{ $rep->status_penyelesaian === 'selesai' ? 'dikembalikan' : ($rep->status_penyelesaian === 'bebas_denda' ? 'dipinjam' : 'terlambat') }}">
                                {{ ucfirst($rep->status_penyelesaian) }}
                            </span>
                        </td>
                        <td style="text-align:right;">
                            <a href="{{ route('reports.show', $rep->id) }}" class="btn-detail" title="Lihat Berita Acara">
                                Berita Acara
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

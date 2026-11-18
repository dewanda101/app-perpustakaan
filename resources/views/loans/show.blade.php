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
</div>
@endsection

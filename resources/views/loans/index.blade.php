@extends('layouts.app')
@section('title', 'Transaksi Peminjaman - Perpustakaan Digital Kampus PENS')
@section('page_title', 'Transaksi Peminjaman')
@section('content')
<div class="ph">
    <div>
        <h1>Daftar Transaksi Peminjaman</h1>
        <div class="sub">Pencatatan sirkulasi peminjaman dan pengembalian buku</div>
    </div>
    <a href="{{ route('loans.create') }}" class="btn">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        <span>Tambah Peminjaman</span>
    </a>
</div>

<div class="card">
    <div class="tbl-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width:48px;">No</th>
                    <th>Nama Anggota</th>
                    <th>Petugas</th>
                    <th>Buku Dipinjam</th>
                    <th>Tgl Pinjam</th>
                    <th>Batas Kembali</th>
                    <th>Status</th>
                    <th style="width:210px;text-align:right;">Tindakan</th>
                </tr>
            </thead>
            <tbody>
            @forelse($loans as $loan)
            <tr data-due="{{ $loan['tanggal_kembali'] }}" data-status="{{ $loan['status'] }}">
                <td style="color:var(--text-light);font-size:12px;font-variant-numeric:tabular-nums;">{{ $loop->iteration + ($loans->currentPage() - 1) * $loans->perPage() }}</td>
                <td style="font-weight:500;">{{ $loan['member']['nama'] }}</td>
                <td style="color:var(--text-muted);font-size:13px;">{{ $loan['user']['name'] }}</td>
                <td style="max-width:200px;">
                    @foreach($loan['loanItems'] as $item)
                    <span style="display:inline-block;background:var(--bg);border:1px solid var(--border);border-radius:4px;padding:2px 6px;font-size:12px;margin:1px;">
                        {{ $item['book']['judul'] }}
                    </span>
                    @endforeach
                </td>
                <td style="font-size:13px;font-variant-numeric:tabular-nums;">{{ $loan['tanggal_pinjam'] }}</td>
                <td data-due-cell style="font-size:13px;font-variant-numeric:tabular-nums;">{{ $loan['tanggal_kembali'] }}</td>
                <td><span class="badge badge-{{ $loan['status'] }}">{{ ucfirst($loan['status']) }}</span></td>
                <td>
                    <div class="aksi-wrap" style="justify-content:flex-end;">
                        <a href="{{ route('loans.show', $loan['id']) }}" class="btn-detail" title="Rincian peminjaman">
                            Detail
                        </a>
                        <a href="{{ route('loans.edit', $loan['id']) }}" class="btn-edit" title="Ubah status transaksi">
                            Edit
                        </a>
                        <form class="inline" action="{{ route('loans.destroy', $loan['id']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan transaksi ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-hapus" title="Hapus transaksi">
                                Hapus
                            </button>
                        </form>
                        @if($loan['status'] === 'dipinjam')
                        <form class="inline" action="{{ route('loans.kembalikan', $loan['id']) }}" method="POST" onsubmit="return confirm('Konfirmasi pengembalian buku?')">
                            @csrf @method('PUT')
                            <button type="submit" class="btn-kembali" title="Tandai buku telah dikembalikan">
                                Kembalikan
                            </button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center;padding:48px 16px;">
                    <div style="color:var(--text-muted);font-size:14px;margin-bottom:12px;">
                        Belum ada riwayat transaksi peminjaman buku dalam sistem.
                    </div>
                    <a href="{{ route('loans.create') }}" class="btn btn-sm">Catat Transaksi Pertama</a>
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="pg-wrap">{{ $loans->links() }}</div>
</div>
@endsection

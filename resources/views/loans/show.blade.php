@extends('layouts.app')
@section('title','Detail Peminjaman')
@section('page_title','Detail Peminjaman')
@section('content')
<a href="{{ route('loans.index') }}" class="back-lnk">← Kembali ke daftar peminjaman</a>
<div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;align-items:start;">
    <div class="card">
        <div class="card-hd"><h2>📋 Info Transaksi</h2></div>
        <div class="card-bd">
            <table class="dtbl">
                <tr>
                    <th>Anggota</th>
                    <td>
                        <strong>{{ $loan['member']['nama'] }}</strong><br>
                        <span style="font-size:12px;color:#64748b;">{{ $loan['member']['nim'] }}</span>
                    </td>
                </tr>
                <tr><th>Petugas</th><td>{{ $loan['user']['name'] }}</td></tr>
                <tr><th>Tgl Pinjam</th><td>{{ $loan['tanggal_pinjam'] }}</td></tr>
                <tr><th>Tgl Kembali</th><td>{{ $loan['tanggal_kembali'] }}</td></tr>
                <tr><th>Dikembalikan</th><td>{{ $loan['tanggal_dikembalikan'] ?? '-' }}</td></tr>
                <tr><th>Status</th><td><span class="badge badge-{{ $loan['status'] }}">{{ ucfirst($loan['status']) }}</span></td></tr>
            </table>
            <div style="margin-top:18px;display:flex;gap:8px;flex-wrap:wrap;">
                <a href="{{ route('loans.edit',$loan['id']) }}" class="btn btn-sm">✏️ Edit</a>
                @if($loan['status']==='dipinjam')
                <form class="inline" action="{{ route('loans.kembalikan',$loan['id']) }}" method="POST" onsubmit="return confirm('Konfirmasi pengembalian buku?')">
                    @csrf @method('PUT')
                    <button type="submit" class="btn btn-sm btn-ok">✅ Kembalikan</button>
                </form>
                @endif
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-hd"><h2>📚 Buku Dipinjam</h2></div>
        <div class="tbl-wrap">
            <table>
                <thead>
                    <tr><th>Judul</th><th>Penulis</th></tr>
                </thead>
                <tbody>
                @foreach($loan['loanItems'] as $item)
                <tr>
                    <td style="font-weight:500;">{{ $item['book']['judul'] }}</td>
                    <td style="color:#64748b;">{{ $item['book']['penulis'] }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

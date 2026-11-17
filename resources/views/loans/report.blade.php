@extends('layouts.app')
@section('title','Laporan Peminjaman')
@section('page_title','Laporan')
@section('content')
<div class="ph">
    <div>
        <h1>Laporan Peminjaman</h1>
        <div class="sub">Data dari <code style="background:#f1f5f9;padding:2px 6px;border-radius:4px;font-size:12px;">GET /api/loans</code></div>
    </div>
</div>
<div class="card">
    <div class="tbl-wrap">
        <table>
            <thead>
                <tr><th>#</th><th>Anggota</th><th>Petugas</th><th>Buku</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Status</th></tr>
            </thead>
            <tbody>
            @forelse($loans as $loan)
            <tr>
                <td style="color:#94a3b8;font-size:12px;">{{ $loan['id'] }}</td>
                <td style="font-weight:500;">{{ $loan['member']['nama'] }}</td>
                <td style="color:#64748b;">{{ $loan['petugas']['name'] }}</td>
                <td>
                    @foreach($loan['books'] as $book)
                    {{ $book['judul'] }}@if(!$loop->last), @endif
                    @endforeach
                </td>
                <td>{{ $loan['tanggal_pinjam'] }}</td>
                <td>{{ $loan['tanggal_kembali'] }}</td>
                <td><span class="badge badge-{{ $loan['status'] }}">{{ ucfirst($loan['status']) }}</span></td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;color:#94a3b8;padding:32px;">Belum ada data atau server API tidak terhubung.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($meta && $meta['last_page'] > 1)
    <div class="pg-wrap" style="justify-content:space-between;">
        <span style="font-size:13px;color:#64748b;">Halaman {{ $meta['current_page'] }} dari {{ $meta['last_page'] }}</span>
        <div style="display:flex;gap:8px;">
            @if($meta['current_page'] > 1)
            <a href="{{ route('loans.report',['page'=>$meta['current_page']-1]) }}" class="btn btn-sm btn-out">← Prev</a>
            @endif
            @if($meta['current_page'] < $meta['last_page'])
            <a href="{{ route('loans.report',['page'=>$meta['current_page']+1]) }}" class="btn btn-sm">Next →</a>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection

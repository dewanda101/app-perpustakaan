@extends('layouts.app')
@section('title','Daftar Peminjaman')
@section('page_title','Peminjaman')
@section('content')
<div class="ph">
    <div>
        <h1>Daftar Peminjaman</h1>
        <div class="sub">Kelola transaksi peminjaman buku</div>
    </div>
    <a href="{{ route('loans.create') }}" class="btn">➕ Tambah Peminjaman</a>
</div>
<div class="card">
    <div class="tbl-wrap">
        <table>
            <thead>
                <tr><th>#</th><th>Anggota</th><th>Petugas</th><th>Buku</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
            @forelse($loans as $loan)
            <tr>
                <td style="color:#94a3b8;font-size:12px;">{{ $loan['id'] }}</td>
                <td style="font-weight:500;">{{ $loan['member']['nama'] }}</td>
                <td style="color:#64748b;font-size:13px;">{{ $loan['user']['name'] }}</td>
                <td style="max-width:180px;">
                    @foreach($loan['loanItems'] as $item)
                    <span style="display:inline-block;background:#f1f5f9;border-radius:4px;padding:2px 7px;font-size:11.5px;margin:1px;">{{ $item['book']['judul'] }}</span>
                    @endforeach
                </td>
                <td>{{ $loan['tanggal_pinjam'] }}</td>
                <td>{{ $loan['tanggal_kembali'] }}</td>
                <td><span class="badge badge-{{ $loan['status'] }}">{{ ucfirst($loan['status']) }}</span></td>
                <td>
                    <div class="aksi-wrap">
                        <a href="{{ route('loans.show',$loan['id']) }}" class="btn-detail">🔍</a>
                        <a href="{{ route('loans.edit',$loan['id']) }}" class="btn-edit">✏️</a>
                        <form class="inline" action="{{ route('loans.destroy',$loan['id']) }}" method="POST" onsubmit="return confirm('Yakin hapus peminjaman ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-hapus">🗑️</button>
                        </form>
                        @if($loan['status']==='dipinjam')
                        <form class="inline" action="{{ route('loans.kembalikan',$loan['id']) }}" method="POST" onsubmit="return confirm('Konfirmasi pengembalian buku?')">
                            @csrf @method('PUT')
                            <button type="submit" class="btn-kembali">✅ Kembalikan</button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center;color:#94a3b8;padding:32px;">Belum ada data peminjaman.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="pg-wrap">{{ $loans->links() }}</div>
</div>
@endsection

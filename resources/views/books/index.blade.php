@extends('layouts.app')
@section('title','Daftar Buku')
@section('page_title','Buku')
@section('content')
<div class="ph">
    <div>
        <h1>Daftar Buku</h1>
        <div class="sub">
            @if($search)
                Hasil pencarian "<strong>{{ $search }}</strong>" — {{ $books->total() }} buku ditemukan
            @else
                Total {{ $books->total() }} buku terdaftar
            @endif
        </div>
    </div>
    <a href="{{ route('books.create') }}" class="btn">➕ Tambah Buku</a>
</div>

{{-- Search Bar --}}
<div class="card" style="padding:16px 20px;margin-bottom:4px;">
    <form method="GET" action="{{ route('books.index') }}" style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
        <input type="text" name="search" value="{{ $search ?? '' }}"
               placeholder="🔍  Cari judul, penulis, atau ISBN..."
               style="flex:1;min-width:220px;padding:9px 14px;font-size:14px;">
        <button type="submit" class="btn" style="white-space:nowrap;">Cari</button>
        @if($search)
        <a href="{{ route('books.index') }}" class="btn btn-out" style="white-space:nowrap;">✕ Reset</a>
        @endif
    </form>
</div>

<div class="card">
    <div class="tbl-wrap">
        <table>
            <thead>
                <tr><th>#</th><th>Judul</th><th>Penulis</th><th>Penerbit</th><th>Tahun</th><th>Stok</th><th>Kategori</th><th>Aksi</th></tr>
            </thead>
            <tbody>
            @forelse($books as $book)
            <tr>
                <td style="color:#94a3b8;font-size:12px;">{{ $book['id'] }}</td>
                <td style="font-weight:500;">{{ $book['judul'] }}</td>
                <td>{{ $book['penulis'] }}</td>
                <td style="color:#64748b;">{{ $book['penerbit'] }}</td>
                <td>{{ $book['tahun_terbit'] }}</td>
                <td>
                    <span style="font-weight:600;color:{{ $book['stok']>0?'#15803d':'#b91c1c' }};">
                        {{ $book['stok'] }}
                    </span>
                    @if($book['stok'] == 0)
                    <span class="badge badge-terlambat" style="font-size:10px;padding:2px 6px;margin-left:4px;">Habis</span>
                    @endif
                </td>
                <td><span class="badge badge-aktif" style="font-size:11px;">{{ $book['category']['nama_kategori'] }}</span></td>
                <td>
                    <div class="aksi-wrap">
                        <a href="{{ route('books.show',$book['id']) }}" class="btn-detail">🔍 Detail</a>
                        <a href="{{ route('books.edit',$book['id']) }}" class="btn-edit">✏️ Edit</a>
                        <form class="inline" action="{{ route('books.destroy',$book['id']) }}" method="POST" onsubmit="return confirm('Yakin hapus buku ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-hapus">🗑️ Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center;color:#94a3b8;padding:40px;">
                    @if($search)
                        😕 Tidak ada buku dengan kata kunci "<strong>{{ $search }}</strong>"
                    @else
                        Belum ada data buku.
                    @endif
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="pg-wrap">{{ $books->links() }}</div>
</div>
@endsection

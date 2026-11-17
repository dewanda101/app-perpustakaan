@extends('layouts.app')
@section('title','Daftar Buku')
@section('page_title','Buku')
@section('content')
<div class="ph">
    <div>
        <h1>Daftar Buku</h1>
        <div class="sub">Total {{ $books->total() }} buku terdaftar</div>
    </div>
    <a href="{{ route('books.create') }}" class="btn">➕ Tambah Buku</a>
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
                <td><span style="font-weight:600;color:{{ $book['stok']>0?'#15803d':'#b91c1c' }};">{{ $book['stok'] }}</span></td>
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
            <tr><td colspan="8" style="text-align:center;color:#94a3b8;padding:32px;">Belum ada data buku.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="pg-wrap">{{ $books->links() }}</div>
</div>
@endsection

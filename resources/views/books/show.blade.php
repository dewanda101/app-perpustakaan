@extends('layouts.app')
@section('title','Detail Buku')
@section('page_title','Detail Buku')
@section('content')
<a href="{{ route('books.index') }}" class="back-lnk">← Kembali ke daftar buku</a>
<div class="card" style="max-width:600px;">
    <div class="card-hd" style="display:flex;align-items:center;justify-content:space-between;gap:12px;">
        <h2 style="margin:0;">📖 {{ $book['judul'] }}</h2>
        <span class="badge badge-aktif">{{ $book['category']['nama_kategori'] }}</span>
    </div>
    <div class="card-bd">
        <table class="dtbl">
            <tr><th>Penulis</th><td>{{ $book['penulis'] }}</td></tr>
            <tr><th>Penerbit</th><td>{{ $book['penerbit'] }}</td></tr>
            <tr><th>Tahun Terbit</th><td>{{ $book['tahun_terbit'] }}</td></tr>
            <tr><th>ISBN</th><td>{{ $book['isbn'] ?? '-' }}</td></tr>
            <tr><th>Stok</th><td><strong style="color:{{ $book['stok']>0?'#15803d':'#b91c1c' }};">{{ $book['stok'] }}</strong></td></tr>
            <tr><th>Kategori</th><td>{{ $book['category']['nama_kategori'] }}</td></tr>
        </table>
        <div style="margin-top:18px;display:flex;gap:10px;">
            <a href="{{ route('books.edit',$book['id']) }}" class="btn btn-sm">✏️ Edit</a>
            <form class="inline" action="{{ route('books.destroy',$book['id']) }}" method="POST" onsubmit="return confirm('Yakin hapus buku ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-err">🗑️ Hapus</button>
            </form>
        </div>
    </div>
</div>
@endsection

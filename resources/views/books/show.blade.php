@extends('layouts.app')
@section('title', 'Rincian Buku - Perpustakaan Digital Kampus PENS')
@section('page_title', 'Rincian Buku')
@section('content')
<a href="{{ route('books.index') }}" class="back-lnk">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <line x1="19" y1="12" x2="5" y2="12"/>
        <polyline points="12 19 5 12 12 5"/>
    </svg>
    <span>Kembali ke katalog buku</span>
</a>

<div class="card" style="max-width:640px;">
    <div class="card-hd">
        <h2 style="margin:0;">{{ $book['judul'] }}</h2>
        <span class="badge badge-aktif">{{ $book['category']['nama_kategori'] }}</span>
    </div>
    <div class="card-bd">
        <table class="dtbl">
            <tr>
                <th>Penulis</th>
                <td>{{ $book['penulis'] }}</td>
            </tr>
            <tr>
                <th>Penerbit</th>
                <td>{{ $book['penerbit'] }}</td>
            </tr>
            <tr>
                <th>Tahun Terbit</th>
                <td style="font-variant-numeric:tabular-nums;">{{ $book['tahun_terbit'] }}</td>
            </tr>
            <tr>
                <th>Nomor ISBN</th>
                <td style="font-variant-numeric:tabular-nums;">{{ $book['isbn'] ?: 'Tidak tercantum' }}</td>
            </tr>
            <tr>
                <th>Ketersediaan Stok</th>
                <td>
                    <span style="font-weight:600;font-variant-numeric:tabular-nums;color:{{ $book['stok'] > 0 ? 'var(--success)' : 'var(--danger)' }};">
                        {{ $book['stok'] }} eksemplar
                    </span>
                    @if($book['stok'] == 0)
                    <span class="badge badge-terlambat" style="font-size:10px;margin-left:6px;">Habis dipinjam</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Kategori</th>
                <td>{{ $book['category']['nama_kategori'] }}</td>
            </tr>
        </table>

        <div style="margin-top:20px;display:flex;gap:10px;padding-top:14px;border-top:1px solid var(--border);">
            <a href="{{ route('books.edit', $book['id']) }}" class="btn btn-sm">
                Edit Informasi
            </a>
            <form class="inline" action="{{ route('books.destroy', $book['id']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-sm btn-err">
                    Hapus Buku
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

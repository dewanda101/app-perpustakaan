@extends('layouts.app')
@section('title', 'Katalog Buku - Perpustakaan Digital Kampus PENS')
@section('page_title', 'Katalog Buku')
@section('content')
<div class="ph">
    <div>
        <h1>Daftar Buku</h1>
        <div class="sub">
            @if($search)
                Hasil pencarian "{{ $search }}": {{ $books->total() }} buku ditemukan
            @else
                Total {{ $books->total() }} judul buku terdaftar dalam sistem
            @endif
        </div>
    </div>
    <a href="{{ route('books.create') }}" class="btn">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        <span>Tambah Buku</span>
    </a>
</div>

{{-- Search Filter --}}
<div class="card" style="padding:14px 18px;margin-bottom:16px;">
    <form method="GET" action="{{ route('books.index') }}" style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
        <div style="flex:1;min-width:240px;position:relative;">
            <input type="text" name="search" value="{{ $search ?? '' }}"
                   placeholder="Cari berdasarkan judul, penulis, atau ISBN..."
                   aria-label="Cari buku"
                   style="width:100%;padding:8px 12px;font-size:13.5px;">
        </div>
        <button type="submit" class="btn btn-sm">Cari</button>
        @if($search)
        <a href="{{ route('books.index') }}" class="btn btn-sm btn-out">Reset Pencarian</a>
        @endif
    </form>
</div>

<div class="card">
    <div class="tbl-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width:48px;">No</th>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Tahun</th>
                    <th>Stok</th>
                    <th>Kategori</th>
                    <th style="width:160px;text-align:right;">Tindakan</th>
                </tr>
            </thead>
            <tbody>
            @forelse($books as $book)
            <tr>
                <td style="color:var(--text-light);font-size:12px;font-variant-numeric:tabular-nums;">{{ $loop->iteration + ($books->currentPage() - 1) * $books->perPage() }}</td>
                <td style="font-weight:500;">{{ $book['judul'] }}</td>
                <td>{{ $book['penulis'] }}</td>
                <td style="color:var(--text-muted);">{{ $book['penerbit'] }}</td>
                <td style="font-variant-numeric:tabular-nums;">{{ $book['tahun_terbit'] }}</td>
                <td>
                    <span style="font-weight:600;font-variant-numeric:tabular-nums;color:{{ $book['stok'] > 0 ? 'var(--success)' : 'var(--danger)' }};">
                        {{ $book['stok'] }}
                    </span>
                    @if($book['stok'] == 0)
                    <span class="badge badge-terlambat" style="font-size:10px;margin-left:4px;">Habis</span>
                    @endif
                </td>
                <td><span class="badge badge-aktif">{{ $book['category']['nama_kategori'] }}</span></td>
                <td>
                    <div class="aksi-wrap" style="justify-content:flex-end;">
                        <a href="{{ route('books.show',$book['id']) }}" class="btn-detail" title="Lihat rincian buku">
                            Detail
                        </a>
                        <a href="{{ route('books.edit',$book['id']) }}" class="btn-edit" title="Ubah data buku">
                            Edit
                        </a>
                        <form class="inline" action="{{ route('books.destroy',$book['id']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-hapus" title="Hapus buku">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align:center;padding:48px 16px;">
                    @if($search)
                        <div style="color:var(--text-muted);font-size:14px;margin-bottom:12px;">
                            Tidak ditemukan buku yang cocok dengan kata kunci "<strong>{{ $search }}</strong>".
                        </div>
                        <a href="{{ route('books.index') }}" class="btn btn-sm btn-out">Tampilkan Semua Buku</a>
                    @else
                        <div style="color:var(--text-muted);font-size:14px;margin-bottom:12px;">
                            Belum ada koleksi buku yang tersimpan dalam sistem.
                        </div>
                        <a href="{{ route('books.create') }}" class="btn btn-sm">Tambah Koleksi Pertama</a>
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

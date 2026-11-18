@extends('layouts.app')
@section('title', 'Kategori Koleksi - Perpustakaan Digital Kampus PENS')
@section('page_title', 'Kategori Koleksi')
@section('content')
<div class="ph">
    <div>
        <h1>Daftar Kategori Buku</h1>
        <div class="sub">Klasifikasi dan penataan koleksi pustaka kampus</div>
    </div>
    <a href="{{ route('categories.create') }}" class="btn">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        <span>Tambah Kategori</span>
    </a>
</div>

<div class="card">
    <div class="tbl-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width:48px;">No</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th style="width:140px;text-align:right;">Tindakan</th>
                </tr>
            </thead>
            <tbody>
            @forelse($categories as $cat)
            <tr>
                <td style="color:var(--text-light);font-size:12px;font-variant-numeric:tabular-nums;">{{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}</td>
                <td><span class="badge badge-aktif">{{ $cat['nama_kategori'] }}</span></td>
                <td style="color:var(--text-muted);">{{ $cat['deskripsi'] ?: 'Tidak ada keterangan tambahan' }}</td>
                <td>
                    <div class="aksi-wrap" style="justify-content:flex-end;">
                        <a href="{{ route('categories.edit', $cat['id']) }}" class="btn-edit" title="Ubah nama kategori">
                            Edit
                        </a>
                        <form class="inline" action="{{ route('categories.destroy', $cat['id']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-hapus" title="Hapus kategori">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align:center;padding:48px 16px;">
                    <div style="color:var(--text-muted);font-size:14px;margin-bottom:12px;">
                        Belum ada kategori buku yang dibuat.
                    </div>
                    <a href="{{ route('categories.create') }}" class="btn btn-sm">Tambah Kategori Baru</a>
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="pg-wrap">{{ $categories->links() }}</div>
</div>
@endsection

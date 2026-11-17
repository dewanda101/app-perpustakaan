@extends('layouts.app')
@section('title','Daftar Kategori')
@section('page_title','Kategori')
@section('content')
<div class="ph">
    <div>
        <h1>Daftar Kategori</h1>
        <div class="sub">Kelola kategori buku perpustakaan</div>
    </div>
    <a href="{{ route('categories.create') }}" class="btn">➕ Tambah Kategori</a>
</div>
<div class="card">
    <div class="tbl-wrap">
        <table>
            <thead>
                <tr><th>#</th><th>Nama Kategori</th><th>Deskripsi</th><th>Aksi</th></tr>
            </thead>
            <tbody>
            @forelse($categories as $cat)
            <tr>
                <td style="color:#94a3b8;font-size:12px;">{{ $cat['id'] }}</td>
                <td><span class="badge badge-aktif">{{ $cat['nama_kategori'] }}</span></td>
                <td style="color:#64748b;">{{ $cat['deskripsi'] ?? '-' }}</td>
                <td>
                    <div class="aksi-wrap">
                        <a href="{{ route('categories.edit',$cat['id']) }}" class="btn-edit">✏️ Edit</a>
                        <form class="inline" action="{{ route('categories.destroy',$cat['id']) }}" method="POST" onsubmit="return confirm('Yakin hapus kategori ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-hapus">🗑️ Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" style="text-align:center;color:#94a3b8;padding:32px;">Belum ada data kategori.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="pg-wrap">{{ $categories->links() }}</div>
</div>
@endsection

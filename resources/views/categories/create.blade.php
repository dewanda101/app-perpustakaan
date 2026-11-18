@extends('layouts.app')
@section('title', 'Tambah Kategori - Perpustakaan Digital Kampus PENS')
@section('page_title', 'Tambah Kategori')
@section('content')
<a href="{{ route('categories.index') }}" class="back-lnk">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <line x1="19" y1="12" x2="5" y2="12"/>
        <polyline points="12 19 5 12 12 5"/>
    </svg>
    <span>Kembali ke daftar kategori</span>
</a>

<div class="card" style="max-width:540px;">
    <div class="card-hd">
        <h2>Formulir Kategori Baru</h2>
    </div>
    <div class="card-bd">
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="form-grp" style="margin-bottom:14px;">
                <label for="nama_kategori">Nama Kategori Koleksi</label>
                <input type="text" name="nama_kategori" id="nama_kategori" value="{{ old('nama_kategori') }}" placeholder="Contoh: Jaringan Komputer, Robotika, Sains Terapan" required>
                @error('nama_kategori')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="form-grp" style="margin-bottom:16px;">
                <label for="deskripsi">Deskripsi Kategori <span style="font-weight:400;color:var(--text-muted);">(opsional)</span></label>
                <textarea name="deskripsi" id="deskripsi" placeholder="Keterangan singkat mengenai lingkup buku dalam kategori ini...">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div style="display:flex;gap:10px;margin-top:16px;padding-top:12px;border-top:1px solid var(--border);">
                <button type="submit" class="btn">Simpan Kategori</button>
                <a href="{{ route('categories.index') }}" class="btn btn-out">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

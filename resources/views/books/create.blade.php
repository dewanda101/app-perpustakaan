@extends('layouts.app')
@section('title', 'Tambah Buku Baru - Perpustakaan Digital Kampus PENS')
@section('page_title', 'Tambah Buku Baru')
@section('content')
<a href="{{ route('books.index') }}" class="back-lnk">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <line x1="19" y1="12" x2="5" y2="12"/>
        <polyline points="12 19 5 12 12 5"/>
    </svg>
    <span>Kembali ke katalog buku</span>
</a>

<div class="card">
    <div class="card-hd">
        <h2>Formulir Data Buku Baru</h2>
    </div>
    <div class="card-bd">
        <form action="{{ route('books.store') }}" method="POST" class="form-wrap">
            @csrf
            <div class="form-grid">
                <div class="form-grp full">
                    <label for="judul">Judul Lengkap Buku</label>
                    <input type="text" name="judul" id="judul" value="{{ old('judul') }}" placeholder="Contoh: Pemrograman Web dengan Framework Laravel" required>
                    @error('judul')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp">
                    <label for="penulis">Nama Penulis</label>
                    <input type="text" name="penulis" id="penulis" value="{{ old('penulis') }}" placeholder="Nama pengarang atau penulis utama" required>
                    @error('penulis')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp">
                    <label for="penerbit">Penerbit</label>
                    <input type="text" name="penerbit" id="penerbit" value="{{ old('penerbit') }}" placeholder="Nama penerbit buku" required>
                    @error('penerbit')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp">
                    <label for="tahun_terbit">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" id="tahun_terbit" value="{{ old('tahun_terbit', date('Y')) }}" min="1900" max="2099" required>
                    @error('tahun_terbit')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp">
                    <label for="isbn">Nomor ISBN <span style="font-weight:400;color:var(--text-muted);">(opsional)</span></label>
                    <input type="text" name="isbn" id="isbn" value="{{ old('isbn') }}" placeholder="978-602-xxxx-xx-x">
                    @error('isbn')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp">
                    <label for="stok">Jumlah Eksemplar (Stok)</label>
                    <input type="number" name="stok" id="stok" value="{{ old('stok', 1) }}" min="0" required>
                    @error('stok')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp full">
                    <label for="category_id">Kategori Koleksi</label>
                    <select name="category_id" id="category_id" required>
                        <option value="">Pilih Kategori Buku</option>
                        @foreach($categories as $c)
                        <option value="{{ $c['id'] }}" @selected(old('category_id') == $c['id'])>{{ $c['nama_kategori'] }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<div class="error">{{ $message }}</div>@enderror
                </div>
            </div>
            <div style="display:flex;gap:10px;margin-top:12px;">
                <button type="submit" class="btn">Simpan Buku</button>
                <a href="{{ route('books.index') }}" class="btn btn-out">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

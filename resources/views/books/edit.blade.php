@extends('layouts.app')
@section('title', 'Perbarui Data Buku - Perpustakaan Digital Kampus PENS')
@section('page_title', 'Perbarui Data Buku')
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
        <h2>Perbarui Informasi Buku</h2>
    </div>
    <div class="card-bd">
        <form action="{{ route('books.update', $book['id']) }}" method="POST" class="form-wrap">
            @csrf @method('PUT')
            <div class="form-grid">
                <div class="form-grp full">
                    <label for="judul">Judul Lengkap Buku</label>
                    <input type="text" name="judul" id="judul" value="{{ old('judul', $book['judul']) }}" required>
                    @error('judul')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp">
                    <label for="penulis">Nama Penulis</label>
                    <input type="text" name="penulis" id="penulis" value="{{ old('penulis', $book['penulis']) }}" required>
                    @error('penulis')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp">
                    <label for="penerbit">Penerbit</label>
                    <input type="text" name="penerbit" id="penerbit" value="{{ old('penerbit', $book['penerbit']) }}" required>
                    @error('penerbit')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp">
                    <label for="tahun_terbit">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" id="tahun_terbit" value="{{ old('tahun_terbit', $book['tahun_terbit']) }}" min="1900" max="2099" required>
                    @error('tahun_terbit')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp">
                    <label for="isbn">Nomor ISBN <span style="font-weight:400;color:var(--text-muted);">(opsional)</span></label>
                    <input type="text" name="isbn" id="isbn" value="{{ old('isbn', $book['isbn']) }}">
                    @error('isbn')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp">
                    <label for="stok">Jumlah Eksemplar (Stok)</label>
                    <input type="number" name="stok" id="stok" value="{{ old('stok', $book['stok']) }}" min="0" required>
                    @error('stok')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp full">
                    <label for="category_id">Kategori Koleksi</label>
                    <select name="category_id" id="category_id" required>
                        <option value="">Pilih Kategori Buku</option>
                        @foreach($categories as $c)
                        <option value="{{ $c['id'] }}" @selected(old('category_id', $book['category_id']) == $c['id'])>{{ $c['nama_kategori'] }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<div class="error">{{ $message }}</div>@enderror
                </div>
            </div>
            <div style="display:flex;gap:10px;margin-top:12px;">
                <button type="submit" class="btn">Simpan Perubahan</button>
                <a href="{{ route('books.index') }}" class="btn btn-out">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

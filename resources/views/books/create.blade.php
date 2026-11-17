@extends('layouts.app')
@section('title','Tambah Buku')
@section('page_title','Tambah Buku')
@section('content')
<a href="{{ route('books.index') }}" class="back-lnk">← Kembali ke daftar buku</a>
<div class="card">
    <div class="card-hd"><h2>📖 Form Tambah Buku</h2></div>
    <div class="card-bd">
        <form action="{{ route('books.store') }}" method="POST" class="form-wrap">
            @csrf
            <div class="form-grid">
                <div class="form-grp full">
                    <label for="judul">Judul Buku</label>
                    <input type="text" name="judul" id="judul" value="{{ old('judul') }}" placeholder="Masukkan judul buku">
                    @error('judul')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp">
                    <label for="penulis">Penulis</label>
                    <input type="text" name="penulis" id="penulis" value="{{ old('penulis') }}" placeholder="Nama penulis">
                    @error('penulis')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp">
                    <label for="penerbit">Penerbit</label>
                    <input type="text" name="penerbit" id="penerbit" value="{{ old('penerbit') }}" placeholder="Nama penerbit">
                    @error('penerbit')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp">
                    <label for="tahun_terbit">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" id="tahun_terbit" value="{{ old('tahun_terbit') }}" placeholder="cth: 2024" min="1900" max="2099">
                    @error('tahun_terbit')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp">
                    <label for="isbn">ISBN <span class="hint">(opsional)</span></label>
                    <input type="text" name="isbn" id="isbn" value="{{ old('isbn') }}" placeholder="978-xxx-xxx-xxx-x">
                    @error('isbn')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp">
                    <label for="stok">Stok</label>
                    <input type="number" name="stok" id="stok" value="{{ old('stok',1) }}" min="0">
                    @error('stok')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp">
                    <label for="category_id">Kategori</label>
                    <select name="category_id" id="category_id">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $c)
                        <option value="{{ $c['id'] }}" @selected(old('category_id')==$c['id'])>{{ $c['nama_kategori'] }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<div class="error">{{ $message }}</div>@enderror
                </div>
            </div>
            <div style="display:flex;gap:10px;margin-top:8px;">
                <button type="submit" class="btn">💾 Simpan Buku</button>
                <a href="{{ route('books.index') }}" class="btn btn-out">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

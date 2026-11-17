@extends('layouts.app')
@section('title','Edit Kategori')
@section('page_title','Edit Kategori')
@section('content')
<a href="{{ route('categories.index') }}" class="back-lnk">← Kembali ke daftar kategori</a>
<div class="card" style="max-width:520px;">
    <div class="card-hd"><h2>✏️ Edit Kategori</h2></div>
    <div class="card-bd">
        <form action="{{ route('categories.update',$category['id']) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-grp">
                <label for="nama_kategori">Nama Kategori</label>
                <input type="text" name="nama_kategori" id="nama_kategori" value="{{ old('nama_kategori',$category['nama_kategori']) }}">
                @error('nama_kategori')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="form-grp">
                <label for="deskripsi">Deskripsi <span class="hint">(opsional)</span></label>
                <textarea name="deskripsi" id="deskripsi">{{ old('deskripsi',$category['deskripsi']) }}</textarea>
                @error('deskripsi')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div style="display:flex;gap:10px;margin-top:8px;">
                <button type="submit" class="btn">💾 Perbarui Kategori</button>
                <a href="{{ route('categories.index') }}" class="btn btn-out">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

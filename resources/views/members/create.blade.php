@extends('layouts.app')
@section('title','Tambah Anggota')
@section('page_title','Tambah Anggota')
@section('content')
<a href="{{ route('members.index') }}" class="back-lnk">← Kembali ke daftar anggota</a>
<div class="card">
    <div class="card-hd"><h2>👤 Form Tambah Anggota</h2></div>
    <div class="card-bd">
        <form action="{{ route('members.store') }}" method="POST" class="form-wrap">
            @csrf
            <div class="form-grid">
                <div class="form-grp full">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}" placeholder="Nama lengkap mahasiswa">
                    @error('nama')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp">
                    <label for="nim">NIM</label>
                    <input type="text" name="nim" id="nim" value="{{ old('nim') }}" placeholder="Nomor Induk Mahasiswa">
                    @error('nim')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="email@pens.ac.id">
                    @error('email')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp">
                    <label for="nomor_telepon">Nomor Telepon</label>
                    <input type="text" name="nomor_telepon" id="nomor_telepon" value="{{ old('nomor_telepon') }}" placeholder="08xx-xxxx-xxxx">
                    @error('nomor_telepon')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp">
                    <label for="status">Status</label>
                    <select name="status" id="status">
                        <option value="aktif" {{ old('status','aktif')==='aktif'?'selected':'' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status')==='nonaktif'?'selected':'' }}>Nonaktif</option>
                    </select>
                    @error('status')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp full">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" id="alamat" placeholder="Alamat lengkap mahasiswa...">{{ old('alamat') }}</textarea>
                    @error('alamat')<div class="error">{{ $message }}</div>@enderror
                </div>
            </div>
            <div style="display:flex;gap:10px;margin-top:8px;">
                <button type="submit" class="btn">💾 Simpan Anggota</button>
                <a href="{{ route('members.index') }}" class="btn btn-out">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

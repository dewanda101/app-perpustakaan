@extends('layouts.app')
@section('title','Edit Anggota')
@section('page_title','Edit Anggota')
@section('content')
<a href="{{ route('members.index') }}" class="back-lnk">← Kembali ke daftar anggota</a>
<div class="card">
    <div class="card-hd"><h2>✏️ Edit Data Anggota</h2></div>
    <div class="card-bd">
        <form action="{{ route('members.update',$member['id']) }}" method="POST" class="form-wrap">
            @csrf @method('PUT')
            <div class="form-grid">
                <div class="form-grp full">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama',$member['nama']) }}">
                    @error('nama')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp">
                    <label for="nim">NIM</label>
                    <input type="text" name="nim" id="nim" value="{{ old('nim',$member['nim']) }}">
                    @error('nim')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email',$member['email']) }}">
                    @error('email')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp">
                    <label for="nomor_telepon">Nomor Telepon</label>
                    <input type="text" name="nomor_telepon" id="nomor_telepon" value="{{ old('nomor_telepon',$member['nomor_telepon']) }}">
                    @error('nomor_telepon')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp">
                    <label for="status">Status</label>
                    <select name="status" id="status">
                        <option value="aktif" {{ old('status',$member['status'])==='aktif'?'selected':'' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status',$member['status'])==='nonaktif'?'selected':'' }}>Nonaktif</option>
                    </select>
                    @error('status')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp full">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" id="alamat">{{ old('alamat',$member['alamat']) }}</textarea>
                    @error('alamat')<div class="error">{{ $message }}</div>@enderror
                </div>
            </div>
            <div style="display:flex;gap:10px;margin-top:8px;">
                <button type="submit" class="btn">💾 Perbarui Anggota</button>
                <a href="{{ route('members.index') }}" class="btn btn-out">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

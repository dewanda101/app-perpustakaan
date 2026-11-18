@extends('layouts.app')
@section('title', 'Perbarui Data Anggota - Perpustakaan Digital Kampus PENS')
@section('page_title', 'Perbarui Data Anggota')
@section('content')
<a href="{{ route('members.index') }}" class="back-lnk">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <line x1="19" y1="12" x2="5" y2="12"/>
        <polyline points="12 19 5 12 12 5"/>
    </svg>
    <span>Kembali ke daftar anggota</span>
</a>

<div class="card">
    <div class="card-hd">
        <h2>Perbarui Data Anggota</h2>
    </div>
    <div class="card-bd">
        <form action="{{ route('members.update', $member['id']) }}" method="POST" class="form-wrap">
            @csrf @method('PUT')
            <div class="form-grid">
                <div class="form-grp full">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', $member['nama']) }}" required>
                    @error('nama')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp">
                    <label for="nim">Nomor Induk Mahasiswa (NIM)</label>
                    <input type="text" name="nim" id="nim" value="{{ old('nim', $member['nim']) }}" required>
                    @error('nim')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp">
                    <label for="email">Email Institusi</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $member['email']) }}" required>
                    @error('email')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp">
                    <label for="nomor_telepon">Nomor Telepon</label>
                    <input type="text" name="nomor_telepon" id="nomor_telepon" value="{{ old('nomor_telepon', $member['nomor_telepon']) }}" required>
                    @error('nomor_telepon')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp">
                    <label for="status">Status Keanggotaan</label>
                    <select name="status" id="status" required>
                        <option value="aktif" {{ old('status', $member['status']) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ old('status', $member['status']) === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                    @error('status')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp full">
                    <label for="alamat">Alamat Domisili</label>
                    <textarea name="alamat" id="alamat" required>{{ old('alamat', $member['alamat']) }}</textarea>
                    @error('alamat')<div class="error">{{ $message }}</div>@enderror
                </div>
            </div>
            <div style="display:flex;gap:10px;margin-top:12px;">
                <button type="submit" class="btn">Simpan Perubahan</button>
                <a href="{{ route('members.index') }}" class="btn btn-out">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

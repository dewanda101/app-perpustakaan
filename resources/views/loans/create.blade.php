@extends('layouts.app')
@section('title','Tambah Peminjaman')
@section('page_title','Tambah Peminjaman')
@section('content')
<a href="{{ route('loans.index') }}" class="back-lnk">← Kembali ke daftar peminjaman</a>
<div class="card" style="max-width:660px;">
    <div class="card-hd"><h2>📋 Form Transaksi Peminjaman</h2></div>
    <div class="card-bd">
        <form action="{{ route('loans.store') }}" method="POST">
            @csrf
            <div class="form-grp">
                <label for="member_id">Anggota</label>
                <select name="member_id" id="member_id">
                    <option value="">-- Pilih Anggota --</option>
                    @foreach($members as $m)
                    <option value="{{ $m['id'] }}" @selected(old('member_id')==$m['id'])>{{ $m['nama'] }} ({{ $m['nim'] }})</option>
                    @endforeach
                </select>
                @error('member_id')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:10px 14px;margin-bottom:16px;font-size:13px;color:#15803d;">
                👤 Petugas: <strong>{{ auth()->user()->name }}</strong> <span style="color:#6b7280;">(otomatis terisi)</span>
            </div>
            <div class="form-grid">
                <div class="form-grp">
                    <label for="tanggal_pinjam">Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" value="{{ old('tanggal_pinjam') }}">
                    @error('tanggal_pinjam')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp">
                    <label for="tanggal_kembali">Tanggal Kembali</label>
                    <input type="date" name="tanggal_kembali" id="tanggal_kembali" value="{{ old('tanggal_kembali') }}">
                    @error('tanggal_kembali')<div class="error">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="form-grp">
                <label>Buku yang Dipinjam</label>
                <div class="chk-list">
                    @forelse($books as $book)
                    <label class="chk-item">
                        <input type="checkbox" name="book_ids[]" value="{{ $book['id'] }}" @checked(in_array($book['id'],old('book_ids',[])))>
                        <span>{{ $book['judul'] }} <span style="color:#94a3b8;font-size:12px;">(stok: {{ $book['stok'] }})</span></span>
                    </label>
                    @empty
                    <div style="padding:12px 14px;color:#94a3b8;font-size:13px;">Belum ada data buku tersedia.</div>
                    @endforelse
                </div>
                @error('book_ids')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div style="display:flex;gap:10px;margin-top:8px;">
                <button type="submit" class="btn">💾 Simpan Peminjaman</button>
                <a href="{{ route('loans.index') }}" class="btn btn-out">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

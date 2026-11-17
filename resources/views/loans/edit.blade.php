@extends('layouts.app')
@section('title','Edit Peminjaman')
@section('page_title','Edit Peminjaman')
@section('content')
<a href="{{ route('loans.index') }}" class="back-lnk">← Kembali ke daftar peminjaman</a>
<div class="card" style="max-width:520px;">
    <div class="card-hd"><h2>✏️ Edit Peminjaman</h2></div>
    <div class="card-bd">
        <div class="form-grp">
            <div class="lbl">Anggota</div>
            <div class="info-blk">{{ $loan['member']['nama'] }} ({{ $loan['member']['nim'] }})</div>
        </div>
        <div class="form-grp">
            <div class="lbl">Buku Dipinjam</div>
            <div class="info-blk">
                @foreach($loan['loanItems'] as $item)
                {{ $item['book']['judul'] }}@if(!$loop->last), @endif
                @endforeach
            </div>
        </div>
        <form action="{{ route('loans.update',$loan['id']) }}" method="POST">
            @csrf @method('PUT')
            <input type="hidden" name="tanggal_pinjam" value="{{ $loan['tanggal_pinjam'] }}">
            <div class="form-grid">
                <div class="form-grp">
                    <label for="tanggal_kembali">Tanggal Kembali</label>
                    <input type="date" name="tanggal_kembali" id="tanggal_kembali" value="{{ old('tanggal_kembali',$loan['tanggal_kembali']) }}">
                    @error('tanggal_kembali')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp">
                    <label for="status">Status</label>
                    <select name="status" id="status">
                        <option value="dipinjam" @selected(old('status',$loan['status'])=='dipinjam')>Dipinjam</option>
                        <option value="dikembalikan" @selected(old('status',$loan['status'])=='dikembalikan')>Dikembalikan</option>
                        <option value="terlambat" @selected(old('status',$loan['status'])=='terlambat')>Terlambat</option>
                    </select>
                    @error('status')<div class="error">{{ $message }}</div>@enderror
                </div>
            </div>
            <div style="display:flex;gap:10px;margin-top:8px;">
                <button type="submit" class="btn">💾 Perbarui Peminjaman</button>
                <a href="{{ route('loans.index') }}" class="btn btn-out">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

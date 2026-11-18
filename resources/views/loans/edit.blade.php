@extends('layouts.app')
@section('title', 'Perbarui Transaksi Peminjaman - Perpustakaan Digital Kampus PENS')
@section('page_title', 'Perbarui Peminjaman')
@section('content')
<a href="{{ route('loans.index') }}" class="back-lnk">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <line x1="19" y1="12" x2="5" y2="12"/>
        <polyline points="12 19 5 12 12 5"/>
    </svg>
    <span>Kembali ke daftar peminjaman</span>
</a>

<div class="card" style="max-width:560px;">
    <div class="card-hd">
        <h2>Perbarui Status Transaksi Sirkulasi</h2>
    </div>
    <div class="card-bd">
        <div class="form-grp" style="margin-bottom:14px;">
            <div style="font-size:12.5px;color:var(--text-muted);font-weight:500;">Anggota Peminjam</div>
            <div style="font-size:14px;font-weight:600;color:var(--text);margin-top:2px;">
                {{ $loan['member']['nama'] }} <span style="font-weight:400;color:var(--text-muted);">(NIM: {{ $loan['member']['nim'] }})</span>
            </div>
        </div>

        <div class="form-grp" style="margin-bottom:16px;">
            <div style="font-size:12.5px;color:var(--text-muted);font-weight:500;">Koleksi Buku Dipinjam</div>
            <div style="margin-top:4px;display:flex;flex-direction:column;gap:4px;">
                @foreach($loan['loanItems'] as $item)
                <div style="font-size:13px;padding:6px 10px;background:var(--bg);border:1px solid var(--border);border-radius:4px;">
                    {{ $item['book']['judul'] }}
                </div>
                @endforeach
            </div>
        </div>

        <form action="{{ route('loans.update', $loan['id']) }}" method="POST">
            @csrf @method('PUT')
            <input type="hidden" name="tanggal_pinjam" value="{{ $loan['tanggal_pinjam'] }}">
            <div class="form-grid">
                <div class="form-grp">
                    <label for="tanggal_kembali">Batas Tanggal Pengembalian</label>
                    <input type="date" name="tanggal_kembali" id="tanggal_kembali" value="{{ old('tanggal_kembali', $loan['tanggal_kembali']) }}" required>
                    @error('tanggal_kembali')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp">
                    <label for="status">Status Sirkulasi</label>
                    <select name="status" id="status" required>
                        <option value="dipinjam" @selected(old('status', $loan['status']) == 'dipinjam')>Dipinjam</option>
                        <option value="dikembalikan" @selected(old('status', $loan['status']) == 'dikembalikan')>Dikembalikan</option>
                        <option value="terlambat" @selected(old('status', $loan['status']) == 'terlambat')>Jatuh Tempo (Terlambat)</option>
                    </select>
                    @error('status')<div class="error">{{ $message }}</div>@enderror
                </div>
            </div>
            <div style="display:flex;gap:10px;margin-top:16px;padding-top:12px;border-top:1px solid var(--border);">
                <button type="submit" class="btn">Simpan Perubahan</button>
                <a href="{{ route('loans.index') }}" class="btn btn-out">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

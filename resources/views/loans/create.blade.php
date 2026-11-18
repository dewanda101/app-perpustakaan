@extends('layouts.app')
@section('title', 'Catat Peminjaman Baru - Perpustakaan Digital Kampus PENS')
@section('page_title', 'Catat Peminjaman Baru')
@section('content')
<a href="{{ route('loans.index') }}" class="back-lnk">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <line x1="19" y1="12" x2="5" y2="12"/>
        <polyline points="12 19 5 12 12 5"/>
    </svg>
    <span>Kembali ke daftar peminjaman</span>
</a>

<div class="card" style="max-width:680px;">
    <div class="card-hd">
        <h2>Formulir Transaksi Sirkulasi</h2>
    </div>
    <div class="card-bd">
        <form action="{{ route('loans.store') }}" method="POST">
            @csrf
            <div class="form-grp" style="margin-bottom:16px;">
                <label for="member_id">Pilih Anggota Peminjam</label>
                <select name="member_id" id="member_id" required>
                    <option value="">-- Pilih Mahasiswa / Sivitas --</option>
                    @foreach($members as $m)
                    <option value="{{ $m['id'] }}" @selected(old('member_id') == $m['id'])>{{ $m['nama'] }} (NIM: {{ $m['nim'] }})</option>
                    @endforeach
                </select>
                @error('member_id')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div style="background:var(--primary-light);border:1px solid #bfdbfe;border-radius:6px;padding:10px 14px;margin-bottom:16px;font-size:13px;color:var(--text);display:flex;align-items:center;justify-content:space-between;">
                <span>Petugas Pencatat: <strong>{{ auth()->user()->name }}</strong></span>
                <span style="color:var(--text-muted);font-size:12px;">(Terdata otomatis)</span>
            </div>

            <div class="form-grid">
                <div class="form-grp">
                    <label for="tanggal_pinjam">Tanggal Peminjaman</label>
                    <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" required>
                    @error('tanggal_pinjam')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp">
                    <label for="tanggal_kembali">Batas Tanggal Pengembalian</label>
                    <input type="date" name="tanggal_kembali" id="tanggal_kembali" value="{{ old('tanggal_kembali', date('Y-m-d', strtotime('+7 days'))) }}" required>
                    @error('tanggal_kembali')<div class="error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-grp" style="margin-bottom:16px;">
                <label>Pilih Judul Buku yang Dipinjam</label>
                <div class="chk-list">
                    @forelse($books as $book)
                    <label class="chk-item">
                        <input type="checkbox" name="book_ids[]" value="{{ $book['id'] }}" @checked(in_array($book['id'], old('book_ids', [])))>
                        <span>
                            {{ $book['judul'] }}
                            <span style="color:var(--text-muted);font-size:12px;font-variant-numeric:tabular-nums;">(Tersedia: {{ $book['stok'] }} eksemplar)</span>
                        </span>
                    </label>
                    @empty
                    <div style="padding:14px;color:var(--text-muted);font-size:13px;text-align:center;">
                        Tidak ada koleksi buku yang tersedia untuk dipinjam saat ini.
                    </div>
                    @endforelse
                </div>
                @error('book_ids')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div style="display:flex;gap:10px;margin-top:16px;padding-top:12px;border-top:1px solid var(--border);">
                <button type="submit" class="btn">Simpan Transaksi</button>
                <a href="{{ route('loans.index') }}" class="btn btn-out">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

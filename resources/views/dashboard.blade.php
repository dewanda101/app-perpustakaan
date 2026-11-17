@extends('layouts.app')
@section('title', 'Dashboard - Perpustakaan Digital Kampus')
@section('page_title', 'Dashboard')
@section('content')

{{-- Stats Cards dengan Counter Animasi (data real dari DB) --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-ic ic-blue">📚</div>
        <div>
            <div class="stat-val" data-count="{{ $stats['total_buku'] }}">0</div>
            <div class="stat-lbl">Total Buku</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-ic ic-grn">👥</div>
        <div>
            <div class="stat-val" data-count="{{ $stats['total_anggota'] }}">0</div>
            <div class="stat-lbl">Total Anggota</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-ic ic-org">📋</div>
        <div>
            <div class="stat-val" data-count="{{ $stats['peminjaman_aktif'] }}">0</div>
            <div class="stat-lbl">Peminjaman Aktif</div>
        </div>
    </div>
    @if($overdue_count > 0)
    <div class="stat-card" style="border-left: 3px solid #ef4444;">
        <div class="stat-ic" style="background:rgba(239,68,68,0.1);color:#ef4444;">⚠️</div>
        <div>
            <div class="stat-val" data-count="{{ $overdue_count }}" style="color:#ef4444;">0</div>
            <div class="stat-lbl" style="color:#ef4444;">Terlambat</div>
        </div>
    </div>
    @endif
</div>

{{-- Quick Access Cards --}}
<div style="margin-top:8px;display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px;">
    <a href="{{ route('books.index') }}" class="stat-card" style="text-decoration:none;" aria-label="Kelola data buku perpustakaan">
        <div class="stat-ic ic-blue">📖</div>
        <div>
            <div style="font-size:14px;font-weight:600;color:var(--text);">Kelola Buku</div>
            <div style="font-size:12.5px;color:var(--text-muted);margin-top:2px;">Tambah, edit, hapus data buku</div>
        </div>
    </a>
    <a href="{{ route('members.index') }}" class="stat-card" style="text-decoration:none;" aria-label="Kelola data anggota perpustakaan">
        <div class="stat-ic ic-grn">👤</div>
        <div>
            <div style="font-size:14px;font-weight:600;color:var(--text);">Kelola Anggota</div>
            <div style="font-size:12.5px;color:var(--text-muted);margin-top:2px;">Data mahasiswa peminjam</div>
        </div>
    </a>
    <a href="{{ route('loans.create') }}" class="stat-card" style="text-decoration:none;" aria-label="Buat transaksi peminjaman buku baru">
        <div class="stat-ic ic-org">➕</div>
        <div>
            <div style="font-size:14px;font-weight:600;color:var(--text);">Transaksi Baru</div>
            <div style="font-size:12.5px;color:var(--text-muted);margin-top:2px;">Catat peminjaman buku</div>
        </div>
    </a>
    <a href="{{ route('loans.report') }}" class="stat-card" style="text-decoration:none;" aria-label="Lihat laporan seluruh peminjaman">
        <div class="stat-ic ic-pur">📊</div>
        <div>
            <div style="font-size:14px;font-weight:600;color:var(--text);">Laporan</div>
            <div style="font-size:12.5px;color:var(--text-muted);margin-top:2px;">Riwayat seluruh peminjaman</div>
        </div>
    </a>
</div>

{{-- Peminjaman Terbaru --}}
@if(count($recent_loans) > 0)
<div class="card" style="margin-top:24px;">
    <div class="card-hd">
        <h2>🕐 Peminjaman Terbaru</h2>
        <a href="{{ route('loans.index') }}" class="btn btn-sm btn-out">Lihat Semua →</a>
    </div>
    <div class="tbl-wrap">
        <table>
            <thead>
                <tr><th>Anggota</th><th>Buku</th><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Status</th></tr>
            </thead>
            <tbody>
            @foreach($recent_loans as $loan)
            <tr data-due="{{ $loan['tanggal_kembali'] }}" data-status="{{ $loan['status'] }}">
                <td style="font-weight:500;">{{ $loan['member']['nama'] }}</td>
                <td style="max-width:200px;">
                    @foreach($loan['loanItems'] as $item)
                    <span style="display:inline-block;background:#f1f5f9;border-radius:4px;padding:2px 7px;font-size:11.5px;margin:1px;">{{ $item['book']['judul'] }}</span>
                    @endforeach
                </td>
                <td style="font-size:13px;color:var(--text-muted);">{{ $loan['tanggal_pinjam'] }}</td>
                <td data-due-cell style="font-size:13px;">{{ $loan['tanggal_kembali'] }}</td>
                <td><span class="badge badge-{{ $loan['status'] }}">{{ ucfirst($loan['status']) }}</span></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@endsection

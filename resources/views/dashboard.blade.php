@extends('layouts.app')
@section('title', 'Dashboard - Perpustakaan Digital Kampus')
@section('page_title', 'Dashboard')
@section('content')

{{-- Stats Cards dengan Counter Animasi --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-ic ic-blue">📚</div>
        <div>
            <div class="stat-val" data-count="{{ $stats['total_buku'] }}">{{ $stats['total_buku'] }}</div>
            <div class="stat-lbl">Total Buku</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-ic ic-grn">👥</div>
        <div>
            <div class="stat-val" data-count="{{ $stats['total_anggota'] }}">{{ $stats['total_anggota'] }}</div>
            <div class="stat-lbl">Total Anggota</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-ic ic-org">📋</div>
        <div>
            <div class="stat-val" data-count="{{ $stats['peminjaman_aktif'] }}">{{ $stats['peminjaman_aktif'] }}</div>
            <div class="stat-lbl">Peminjaman Aktif</div>
        </div>
    </div>
</div>

{{-- Quick Access Cards --}}
<div style="margin-top:8px;display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px;">
    <a href="{{ route('books.index') }}" class="stat-card" style="text-decoration:none;">
        <div class="stat-ic ic-blue">📖</div>
        <div>
            <div style="font-size:14px;font-weight:600;color:var(--text);">Kelola Buku</div>
            <div style="font-size:12.5px;color:var(--text-muted);margin-top:2px;">Tambah, edit, hapus data buku</div>
        </div>
    </a>
    <a href="{{ route('members.index') }}" class="stat-card" style="text-decoration:none;">
        <div class="stat-ic ic-grn">👤</div>
        <div>
            <div style="font-size:14px;font-weight:600;color:var(--text);">Kelola Anggota</div>
            <div style="font-size:12.5px;color:var(--text-muted);margin-top:2px;">Data mahasiswa peminjam</div>
        </div>
    </a>
    <a href="{{ route('loans.create') }}" class="stat-card" style="text-decoration:none;">
        <div class="stat-ic ic-org">➕</div>
        <div>
            <div style="font-size:14px;font-weight:600;color:var(--text);">Transaksi Baru</div>
            <div style="font-size:12.5px;color:var(--text-muted);margin-top:2px;">Catat peminjaman buku</div>
        </div>
    </a>
    <a href="{{ route('loans.report') }}" class="stat-card" style="text-decoration:none;">
        <div class="stat-ic ic-pur">📊</div>
        <div>
            <div style="font-size:14px;font-weight:600;color:var(--text);">Laporan</div>
            <div style="font-size:12.5px;color:var(--text-muted);margin-top:2px;">Riwayat seluruh peminjaman</div>
        </div>
    </a>
</div>
@endsection

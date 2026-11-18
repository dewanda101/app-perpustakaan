@extends('layouts.app')
@section('title', 'Profil Anggota - Perpustakaan Digital Kampus PENS')
@section('page_title', 'Profil Anggota')
@section('content')
<a href="{{ route('members.index') }}" class="back-lnk">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <line x1="19" y1="12" x2="5" y2="12"/>
        <polyline points="12 19 5 12 12 5"/>
    </svg>
    <span>Kembali ke daftar anggota</span>
</a>

<div style="display:grid;grid-template-columns:minmax(0,1fr) minmax(0,2fr);gap:18px;align-items:start;">
    <div class="card">
        <div class="card-bd" style="text-align:center;">
            <div style="width:64px;height:64px;border-radius:6px;background:var(--primary);display:flex;align-items:center;justify-content:center;font-size:24px;font-weight:700;color:#fff;margin:0 auto 12px;" aria-hidden="true">
                {{ strtoupper(substr($member['nama'],0,1)) }}
            </div>
            <div style="font-size:16px;font-weight:700;margin-bottom:6px;color:var(--text);">{{ $member['nama'] }}</div>
            <span class="badge badge-{{ $member['status'] }}">{{ ucfirst($member['status']) }}</span>

            <div style="margin-top:16px;">
                <table class="dtbl">
                    <tr><th>NIM</th><td style="font-variant-numeric:tabular-nums;">{{ $member['nim'] }}</td></tr>
                    <tr><th>Email</th><td>{{ $member['email'] }}</td></tr>
                    <tr><th>Telepon</th><td style="font-variant-numeric:tabular-nums;">{{ $member['nomor_telepon'] }}</td></tr>
                    <tr><th>Alamat</th><td>{{ $member['alamat'] }}</td></tr>
                </table>
            </div>
            <div style="margin-top:16px;padding-top:14px;border-top:1px solid var(--border);">
                <a href="{{ route('members.edit',$member['id']) }}" class="btn btn-sm">Edit Data Anggota</a>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-hd">
            <h2>Riwayat Sirkulasi Peminjaman</h2>
        </div>
        <div class="tbl-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Tgl Pinjam</th>
                        <th>Batas Kembali</th>
                        <th>Petugas</th>
                        <th>Buku Dipinjam</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($member['loans'] as $loan)
                <tr>
                    <td style="font-size:13px;font-variant-numeric:tabular-nums;">{{ $loan['tanggal_pinjam'] }}</td>
                    <td style="font-size:13px;font-variant-numeric:tabular-nums;">{{ $loan['tanggal_kembali'] }}</td>
                    <td style="color:var(--text-muted);">{{ $loan['user']['name'] }}</td>
                    <td>
                        @foreach($loan['loanItems'] as $item)
                        <span style="display:inline-block;background:var(--bg);border:1px solid var(--border);border-radius:4px;padding:2px 6px;font-size:12px;margin:1px;">
                            {{ $item['book']['judul'] }}
                        </span>
                        @endforeach
                    </td>
                    <td><span class="badge badge-{{ $loan['status'] }}">{{ ucfirst($loan['status']) }}</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;color:var(--text-muted);padding:32px 16px;">
                        Anggota ini belum memiliki riwayat peminjaman buku.
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

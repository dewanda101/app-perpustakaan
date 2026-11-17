@extends('layouts.app')
@section('title','Detail Anggota')
@section('page_title','Detail Anggota')
@section('content')
<a href="{{ route('members.index') }}" class="back-lnk">← Kembali ke daftar anggota</a>
<div style="display:grid;grid-template-columns:minmax(0,1fr) minmax(0,2fr);gap:18px;align-items:start;">
    <div class="card">
        <div class="card-bd" style="text-align:center;">
            <div style="width:68px;height:68px;border-radius:50%;background:linear-gradient(135deg,#4f46e5,#06b6d4);display:flex;align-items:center;justify-content:center;font-size:28px;font-weight:700;color:#fff;margin:0 auto 12px;">
                {{ strtoupper(substr($member['nama'],0,1)) }}
            </div>
            <div style="font-size:16px;font-weight:700;margin-bottom:6px;">{{ $member['nama'] }}</div>
            <span class="badge badge-{{ $member['status'] }}">{{ ucfirst($member['status']) }}</span>
            <div style="margin-top:16px;">
                <table class="dtbl">
                    <tr><th>NIM</th><td style="font-family:monospace;">{{ $member['nim'] }}</td></tr>
                    <tr><th>Email</th><td>{{ $member['email'] }}</td></tr>
                    <tr><th>Telepon</th><td>{{ $member['nomor_telepon'] }}</td></tr>
                    <tr><th>Alamat</th><td>{{ $member['alamat'] }}</td></tr>
                </table>
            </div>
            <div style="margin-top:16px;">
                <a href="{{ route('members.edit',$member['id']) }}" class="btn btn-sm">✏️ Edit Profil</a>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-hd"><h2>📋 Riwayat Peminjaman</h2></div>
        <div class="tbl-wrap">
            <table>
                <thead>
                    <tr><th>Tgl Pinjam</th><th>Tgl Kembali</th><th>Petugas</th><th>Buku</th><th>Status</th></tr>
                </thead>
                <tbody>
                @forelse($member['loans'] as $loan)
                <tr>
                    <td>{{ $loan['tanggal_pinjam'] }}</td>
                    <td>{{ $loan['tanggal_kembali'] }}</td>
                    <td style="color:#64748b;">{{ $loan['user']['name'] }}</td>
                    <td>
                        @foreach($loan['loanItems'] as $item)
                        {{ $item['book']['judul'] }}@if(!$loop->last), @endif
                        @endforeach
                    </td>
                    <td><span class="badge badge-{{ $loan['status'] }}">{{ ucfirst($loan['status']) }}</span></td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align:center;color:#94a3b8;padding:24px;">Belum pernah meminjam.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

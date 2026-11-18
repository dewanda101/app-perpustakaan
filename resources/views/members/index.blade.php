@extends('layouts.app')
@section('title', 'Data Anggota - Perpustakaan Digital Kampus PENS')
@section('page_title', 'Data Anggota')
@section('content')
<div class="ph">
    <div>
        <h1>Daftar Anggota Perpustakaan</h1>
        <div class="sub">Total {{ $members->total() }} civitas akademika terdaftar</div>
    </div>
    <a href="{{ route('members.create') }}" class="btn">
        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <line x1="12" y1="5" x2="12" y2="19"/>
            <line x1="5" y1="12" x2="19" y2="12"/>
        </svg>
        <span>Tambah Anggota</span>
    </a>
</div>

<div class="card">
    <div class="card-hd">
        <h2>Daftar Mahasiswa & Anggota</h2>
        <form method="GET" action="{{ route('members.index') }}" style="display:flex;gap:8px;align-items:center;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama anggota..." aria-label="Cari nama anggota" style="width:200px;padding:6px 10px;font-size:13px;">
            <button type="submit" class="btn btn-sm">Cari</button>
            @if(request('search'))
            <a href="{{ route('members.index') }}" class="btn btn-sm btn-out">Reset</a>
            @endif
        </form>
    </div>
    <div class="tbl-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width:48px;">No</th>
                    <th>Nama Lengkap</th>
                    <th>NIM</th>
                    <th>Email Institusi</th>
                    <th>Nomor Telepon</th>
                    <th>Status</th>
                    <th style="width:160px;text-align:right;">Tindakan</th>
                </tr>
            </thead>
            <tbody>
            @forelse($members as $m)
            <tr>
                <td style="color:var(--text-light);font-size:12px;font-variant-numeric:tabular-nums;">{{ $loop->iteration + ($members->currentPage() - 1) * $members->perPage() }}</td>
                <td style="font-weight:500;">{{ $m['nama'] }}</td>
                <td style="font-variant-numeric:tabular-nums;color:var(--text-muted);font-size:13px;">{{ $m['nim'] }}</td>
                <td style="color:var(--text-muted);">{{ $m['email'] }}</td>
                <td style="font-variant-numeric:tabular-nums;">{{ $m['nomor_telepon'] }}</td>
                <td><span class="badge badge-{{ $m['status'] }}">{{ ucfirst($m['status']) }}</span></td>
                <td>
                    <div class="aksi-wrap" style="justify-content:flex-end;">
                        <a href="{{ route('members.show',$m['id']) }}" class="btn-detail" title="Lihat profil anggota">
                            Detail
                        </a>
                        <a href="{{ route('members.edit',$m['id']) }}" class="btn-edit" title="Ubah data anggota">
                            Edit
                        </a>
                        <form class="inline" action="{{ route('members.destroy',$m['id']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data anggota ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-hapus" title="Hapus anggota">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;padding:48px 16px;">
                    @if(request('search'))
                        <div style="color:var(--text-muted);font-size:14px;margin-bottom:12px;">
                            Tidak ditemukan anggota dengan nama "<strong>{{ request('search') }}</strong>".
                        </div>
                        <a href="{{ route('members.index') }}" class="btn btn-sm btn-out">Tampilkan Semua Anggota</a>
                    @else
                        <div style="color:var(--text-muted);font-size:14px;margin-bottom:12px;">
                            Belum ada anggota perpustakaan yang terdaftar.
                        </div>
                        <a href="{{ route('members.create') }}" class="btn btn-sm">Daftarkan Anggota Baru</a>
                    @endif
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="pg-wrap">{{ $members->appends(request()->query())->links() }}</div>
</div>
@endsection

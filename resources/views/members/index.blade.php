@extends('layouts.app')
@section('title','Daftar Anggota')
@section('page_title','Anggota')
@section('content')
<div class="ph">
    <div>
        <h1>Daftar Anggota</h1>
        <div class="sub">Total {{ $members->total() }} anggota terdaftar</div>
    </div>
    <a href="{{ route('members.create') }}" class="btn">➕ Tambah Anggota</a>
</div>
<div class="card">
    <div class="card-hd">
        <h2>Data Anggota</h2>
        <form method="GET" action="{{ route('members.index') }}" style="display:flex;gap:8px;align-items:center;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama anggota..." style="width:210px;padding:7px 11px;font-size:13px;">
            <button type="submit" class="btn btn-sm">🔍 Cari</button>
            @if(request('search'))
            <a href="{{ route('members.index') }}" class="btn btn-sm btn-out">✕ Reset</a>
            @endif
        </form>
    </div>
    <div class="tbl-wrap">
        <table>
            <thead>
                <tr><th>#</th><th>Nama</th><th>NIM</th><th>Email</th><th>Telepon</th><th>Status</th><th>Aksi</th></tr>
            </thead>
            <tbody>
            @forelse($members as $m)
            <tr>
                <td style="color:#94a3b8;font-size:12px;">{{ $m['id'] }}</td>
                <td style="font-weight:500;">{{ $m['nama'] }}</td>
                <td style="font-family:monospace;font-size:13px;">{{ $m['nim'] }}</td>
                <td style="color:#64748b;">{{ $m['email'] }}</td>
                <td>{{ $m['nomor_telepon'] }}</td>
                <td><span class="badge badge-{{ $m['status'] }}">{{ ucfirst($m['status']) }}</span></td>
                <td>
                    <div class="aksi-wrap">
                        <a href="{{ route('members.show',$m['id']) }}" class="btn-detail">🔍 Detail</a>
                        <a href="{{ route('members.edit',$m['id']) }}" class="btn-edit">✏️ Edit</a>
                        <form class="inline" action="{{ route('members.destroy',$m['id']) }}" method="POST" onsubmit="return confirm('Yakin hapus anggota ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-hapus">🗑️ Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;color:#94a3b8;padding:32px;">
                    @if(request('search'))Tidak ada hasil untuk "{{ request('search') }}".@else Belum ada data anggota.@endif
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    <div class="pg-wrap">{{ $members->appends(request()->query())->links() }}</div>
</div>
@endsection

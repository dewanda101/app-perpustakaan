@extends('layouts.app')
@section('title','Profil Saya')
@section('page_title','Profil Saya')
@section('content')
<div style="display:grid;grid-template-columns:minmax(0,1fr) minmax(0,2fr);gap:20px;align-items:start;max-width:860px;">
    <div class="card">
        <div class="card-bd" style="text-align:center;">
            <div style="width:70px;height:70px;border-radius:50%;background:linear-gradient(135deg,#4f46e5,#06b6d4);display:flex;align-items:center;justify-content:center;font-size:28px;font-weight:700;color:#fff;margin:0 auto 14px;">
                {{ strtoupper(substr(auth()->user()->name,0,1)) }}
            </div>
            <div style="font-size:17px;font-weight:700;margin-bottom:6px;color:#0f172a;">{{ auth()->user()->name }}</div>
            <span class="badge badge-aktif">{{ ucfirst(auth()->user()->role) }}</span>
            <div style="margin-top:16px;">
                <table class="dtbl">
                    <tr><th>Email</th><td>{{ auth()->user()->email }}</td></tr>
                    <tr><th>Role</th><td>{{ ucfirst(auth()->user()->role) }}</td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-hd"><h2>🔒 Ganti Password</h2></div>
        <div class="card-bd">
            @include('partials.alert')
            <form action="{{ route('profil.password') }}" method="POST" style="max-width:380px;">
                @csrf @method('PUT')
                <div class="form-grp">
                    <label for="password_lama">Password Lama</label>
                    <input type="password" name="password_lama" id="password_lama" placeholder="Password saat ini">
                    @error('password_lama')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp">
                    <label for="password_baru">Password Baru</label>
                    <input type="password" name="password_baru" id="password_baru" placeholder="Minimal 8 karakter">
                    @error('password_baru')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp">
                    <label for="password_baru_confirmation">Konfirmasi Password Baru</label>
                    <input type="password" name="password_baru_confirmation" id="password_baru_confirmation" placeholder="Ulangi password baru">
                </div>
                <button type="submit" class="btn" style="margin-top:8px;">💾 Simpan Password</button>
            </form>
        </div>
    </div>
</div>
@endsection

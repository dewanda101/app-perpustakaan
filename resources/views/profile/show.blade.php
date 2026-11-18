@extends('layouts.app')
@section('title', 'Profil Akun - Perpustakaan Digital Kampus PENS')
@section('page_title', 'Profil Akun')
@section('content')
<div style="display:grid;grid-template-columns:minmax(0,1fr) minmax(0,2fr);gap:20px;align-items:start;max-width:860px;">
    <div class="card">
        <div class="card-bd" style="text-align:center;">
            <div style="width:68px;height:68px;border-radius:6px;background:var(--primary);display:flex;align-items:center;justify-content:center;font-size:26px;font-weight:700;color:#fff;margin:0 auto 14px;" aria-hidden="true">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div style="font-size:16px;font-weight:700;margin-bottom:6px;color:var(--text);">{{ auth()->user()->name }}</div>
            <span class="badge badge-aktif">{{ ucfirst(auth()->user()->role) }} Perpustakaan</span>
            <div style="margin-top:18px;">
                <table class="dtbl">
                    <tr><th>Email</th><td>{{ auth()->user()->email }}</td></tr>
                    <tr><th>Peran Akses</th><td>{{ ucfirst(auth()->user()->role) }}</td></tr>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-hd">
            <h2>Ubah Kata Sandi</h2>
        </div>
        <div class="card-bd">
            <form action="{{ route('profil.password') }}" method="POST" style="max-width:380px;">
                @csrf @method('PUT')
                <div class="form-grp" style="margin-bottom:14px;">
                    <label for="password_lama">Kata Sandi Saat Ini</label>
                    <input type="password" name="password_lama" id="password_lama" placeholder="Masukkan kata sandi lama" required>
                    @error('password_lama')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp" style="margin-bottom:14px;">
                    <label for="password_baru">Kata Sandi Baru</label>
                    <input type="password" name="password_baru" id="password_baru" placeholder="Minimal 8 karakter" required>
                    @error('password_baru')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-grp" style="margin-bottom:18px;">
                    <label for="password_baru_confirmation">Konfirmasi Kata Sandi Baru</label>
                    <input type="password" name="password_baru_confirmation" id="password_baru_confirmation" placeholder="Ulangi kata sandi baru" required>
                </div>
                <button type="submit" class="btn">Perbarui Kata Sandi</button>
            </form>
        </div>
    </div>
</div>
@endsection

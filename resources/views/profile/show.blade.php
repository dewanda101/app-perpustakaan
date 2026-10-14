{{-- File: resources/views/profile/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Profil Saya - Perpustakaan Digital Kampus')

@section('content')
    <h1>Profil Saya</h1>

    {{-- Info Profil --}}
    <table style="max-width:500px; margin-bottom:32px;">
        <tr>
            <th style="width:140px;">Nama</th>
            <td>{{ auth()->user()->name }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ auth()->user()->email }}</td>
        </tr>
        <tr>
            <th>Role</th>
            <td>{{ ucfirst(auth()->user()->role) }}</td>
        </tr>
    </table>

    <h2>Ganti Password</h2>

    <form action="{{ route('profil.password') }}" method="POST" style="max-width:400px;">
        @csrf
        @method('PUT')

        <label for="password_lama">Password Lama</label>
        <input type="password" name="password_lama" id="password_lama">
        @error('password_lama')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="password_baru">Password Baru</label>
        <input type="password" name="password_baru" id="password_baru">
        @error('password_baru')
            <div class="error">{{ $message }}</div>
        @enderror

        <label for="password_baru_confirmation">Konfirmasi Password Baru</label>
        <input type="password" name="password_baru_confirmation" id="password_baru_confirmation">
        @error('password_baru_confirmation')
            <div class="error">{{ $message }}</div>
        @enderror

        <button type="submit" class="btn" style="margin-top:16px;">Simpan Password Baru</button>
    </form>
@endsection

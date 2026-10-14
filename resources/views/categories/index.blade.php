{{-- File: resources/views/categories/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Daftar Kategori')

@section('content')
    <h1>Daftar Kategori</h1>

    <p><a href="{{ route('categories.create') }}" class="btn">+ Tambah Kategori</a></p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $category['id'] }}</td>
                    <td>{{ $category['nama_kategori'] }}</td>
                    <td>{{ $category['deskripsi'] ?? '-' }}</td>
                    <td>
                        <div class="aksi-wrap">
                            <a href="{{ route('categories.edit', $category['id']) }}" class="btn-edit">✏️ Edit</a>
                            <form class="inline" action="{{ route('categories.destroy', $category['id']) }}" method="POST"
                                  onsubmit="return confirm('Yakin hapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-hapus">🗑️ Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Belum ada data kategori.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $categories->links() }}
@endsection

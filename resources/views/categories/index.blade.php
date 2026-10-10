@extends('layouts.app')

@section('title', 'Kategori Menu')

@section('content')

    <div class="category-page">
        <div class="category-container">

            <h1>Kategori Menu</h1>

            {{-- Pesan sukses --}}
            @if (session('success')) <div class="alert alert-success" role="alert">
            {{ session('success') }} </div>
            @endif
            
            {{-- Pesan error --}}
            @if (session('error')) <div class="alert alert-error" role="alert">
            {{ session('error') }} </div>
            @endif
            
            {{-- Pesan validasi --}}
            @if ($errors->any()) <div class="alert alert-error" role="alert"> <ul>
            @foreach ($errors->all() as $error) <li>{{ $error }}</li>
            @endforeach </ul> </div>
            @endif

            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                + Tambah Kategori
            </a>

            <table>
                <thead>
                    <tr>
                        <th width="60">No</th>
                        <th>Nama Kategori</th>
                        <th width="200">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($categories as $category)

                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $category->name }}
                            </td>

                            <td>
                                <div class="actions">

                                    <a
                                        href="{{ route('categories.edit', $category->id) }}"
                                        class="btn btn-warning"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('categories.destroy', $category->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus kategori ini?')"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-danger"
                                        >
                                            Hapus
                                        </button>

                                    </form>

                                </div>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="3" class="text-center">
                                Belum ada kategori.
                            </td>
                        </tr>

                    @endforelse

                </tbody>
            </table>

        </div>
    </div>

@endsection

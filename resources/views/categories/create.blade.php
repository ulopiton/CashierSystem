@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')

    <div class="category-create-page">

        <div class="category-create-container">

            <h1>Tambah Kategori</h1>

            <form
                action="{{ route('categories.store') }}"
                method="POST"
            >

                @csrf

                <div class="form-group">

                    <label for="name">
                        Nama Kategori
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Contoh: Makanan"
                    >

                    @error('name')
                        <div class="error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <a
                    href="{{ route('categories.index') }}"
                    class="btn btn-secondary"
                >
                    Kembali
                </a>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Simpan
                </button>

            </form>

        </div>

    </div>

@endsection
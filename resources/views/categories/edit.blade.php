@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')

    <div class="category-edit-page">

        <div class="category-edit-container">

            <h1>Edit Kategori</h1>

            <form
                action="{{ route('categories.update', $category->id) }}"
                method="POST"
            >

                @csrf

                @method('PUT')

                <div class="form-group">

                    <label for="name">
                        Nama Kategori
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $category->name) }}"
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
                    Update
                </button>

            </form>

        </div>

    </div>

@endsection
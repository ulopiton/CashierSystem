@extends('layouts.app')

@section('title', 'Tambah Menu')

@section('content')

    <div class="menu-create-page">

        <div class="menu-create-container">

            <h1>Tambah Menu</h1>

            <form
                action="{{ route('menus.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf

                <div class="form-group">

                    <label for="category_id">
                        Kategori
                    </label>

                    <select
                        name="category_id"
                        id="category_id"
                    >

                        <option value="">
                            -- Pilih Kategori --
                        </option>

                        @foreach ($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}
                            >
                                {{ $category->name }}
                            </option>

                        @endforeach

                    </select>

                    @error('category_id')

                        <div class="error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

                <div class="form-group">

                    <label for="name">
                        Nama Menu
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Contoh: Nasi Goreng"
                    >

                    @error('name')

                        <div class="error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

                <div class="form-group">

                    <label for="price">
                        Harga
                    </label>

                    <input
                        type="number"
                        id="price"
                        name="price"
                        value="{{ old('price') }}"
                        min="0"
                        placeholder="Contoh: 15000"
                    >

                    @error('price')

                        <div class="error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

                <div class="form-group">

                    <label for="stock">
                        Stok
                    </label>

                    <input
                        type="number"
                        id="stock"
                        name="stock"
                        value="{{ old('stock', 0) }}"
                        min="0"
                    >

                    @error('stock')

                        <div class="error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

                <div class="form-group">

                    <label for="image">
                        Foto Menu
                    </label>

                    <input
                        type="file"
                        id="image"
                        name="image"
                        accept=".jpg,.jpeg,.png,.webp"
                    >

                    <small>
                        Format: JPG, JPEG, PNG, WEBP. Maksimal 2 MB.
                    </small>

                    @error('image')

                        <div class="error">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

                <a
                    href="{{ route('menus.index') }}"
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

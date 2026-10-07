<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Edit Menu</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="menu-edit-page">

<div class="menu-edit-container">

    <h1>Edit Menu</h1>

    <form
        action="{{ route('menus.update', $menu->id) }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf

        @method('PUT')

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
                        {{ old('category_id', $menu->category_id) == $category->id ? 'selected' : '' }}
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
                value="{{ old('name', $menu->name) }}"
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
                value="{{ old('price', $menu->price) }}"
                min="0"
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
                value="{{ old('stock', $menu->stock) }}"
                min="0"
            >

            @error('stock')

                <div class="error">
                    {{ $message }}
                </div>

            @enderror

        </div>

        <div class="form-group">

            <label>
                Foto Saat Ini
            </label>

            @if ($menu->image)

                <br>

                <img
                    src="{{ asset($menu->image) }}"
                    alt="{{ $menu->name }}"
                    class="current-image"
                >

            @else

                <p>
                    Belum ada foto.
                </p>

            @endif

        </div>

        <div class="form-group">

            <label for="image">
                Ganti Foto
            </label>

            <input
                type="file"
                id="image"
                name="image"
                accept=".jpg,.jpeg,.png,.webp"
            >

            <small>
                Kosongkan jika tidak ingin mengganti foto.
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
            Update
        </button>

    </form>

</div>

</body>

</html>
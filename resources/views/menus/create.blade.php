<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Tambah Menu</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 650px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background-color: #2563eb;
            color: white;
        }

        .btn-secondary {
            background-color: #6b7280;
            color: white;
        }

        .error {
            color: #dc2626;
            font-size: 14px;
            margin-top: 5px;
        }

    </style>

</head>

<body>

<div class="container">

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

</body>

</html>
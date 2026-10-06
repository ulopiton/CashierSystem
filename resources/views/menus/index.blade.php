<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Daftar Menu</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
        }

        h1 {
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 8px 14px;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-primary {
            background-color: #2563eb;
            color: white;
        }

        .btn-warning {
            background-color: #f59e0b;
            color: white;
        }

        .btn-danger {
            background-color: #dc2626;
            color: white;
        }

        .btn-secondary {
            background-color: #6b7280;
            color: white;
        }

        .alert {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .alert-success {
            background-color: #dcfce7;
            color: #166534;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
            vertical-align: middle;
        }

        th {
            background-color: #f3f4f6;
        }

        .menu-image {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
        }

        .no-image {
            width: 80px;
            height: 60px;
            background: #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            color: #6b7280;
            border-radius: 5px;
        }

        .actions {
            display: flex;
            gap: 5px;
        }

        .actions form {
            display: inline;
        }

    </style>

</head>

<body>

<div class="container">

    <h1>Daftar Menu</h1>

    @if (session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif

    <a
        href="{{ route('menus.create') }}"
        class="btn btn-primary"
    >
        + Tambah Menu
    </a>

    <a
        href="{{ route('categories.index') }}"
        class="btn btn-secondary"
    >
        Kelola Kategori
    </a>

    <table>

        <thead>

            <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Nama Menu</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>

        </thead>

        <tbody>

            @forelse ($menus as $menu)

                <tr>

                    <td>
                        {{ $loop->iteration }}
                    </td>

                    <td>

                        @if ($menu->image)

                            <img
                                src="{{ asset($menu->image) }}"
                                alt="{{ $menu->name }}"
                                class="menu-image"
                            >

                        @else

                            <div class="no-image">
                                Tidak ada foto
                            </div>

                        @endif

                    </td>

                    <td>
                        {{ $menu->name }}
                    </td>

                    <td>
                        {{ $menu->category->name }}
                    </td>

                    <td>
                        Rp {{ number_format($menu->price, 0, ',', '.') }}
                    </td>

                    <td>
                        {{ $menu->stock }}
                    </td>

                    <td>

                        <div class="actions">

                            <a
                                href="{{ route('menus.edit', $menu->id) }}"
                                class="btn btn-warning"
                            >
                                Edit
                            </a>

                            <form
                                action="{{ route('menus.destroy', $menu->id) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus menu ini?')"
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

                    <td
                        colspan="7"
                        style="text-align: center;"
                    >
                        Belum ada menu.
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>

</body>

</html>
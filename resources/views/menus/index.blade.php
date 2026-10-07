<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Daftar Menu</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="menu-index-page">

<div class="menu-index-container">

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
                        class="text-center"
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
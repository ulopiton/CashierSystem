<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kategori Menu</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="category-page">
<div class="category-container">

    <h1>Kategori Menu</h1>

    {{-- Pesan sukses --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
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

</body>
</html>
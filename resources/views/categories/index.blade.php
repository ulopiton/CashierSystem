<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kategori Menu</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 900px;
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
        }

        th {
            background-color: #f3f4f6;
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
                    <td colspan="3" style="text-align: center;">
                        Belum ada kategori.
                    </td>
                </tr>

            @endforelse

        </tbody>
    </table>

</div>

</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kasir</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f5f5f5;
        }

        h1 {
            margin-bottom: 20px;
        }

        .menu-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
        }

        .menu-card {
            background: white;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .menu-image {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .no-image {
            width: 100%;
            height: 160px;
            background: #ddd;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            color: #666;
        }

        .menu-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .menu-category {
            color: #666;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .menu-price {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .menu-stock {
            font-size: 14px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>

    <h1>Kasir</h1>

    <div class="menu-container">

        @forelse ($menus as $menu)

            <div class="menu-card">

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

                <div class="menu-name">
                    {{ $menu->name }}
                </div>

                <div class="menu-category">
                    {{ $menu->category->name }}
                </div>

                <div class="menu-price">
                    Rp {{ number_format($menu->price, 0, ',', '.') }}
                </div>

                <div class="menu-stock">
                    Stok: {{ $menu->stock }}
                </div>

            </div>

        @empty

            <p>Tidak ada menu yang tersedia.</p>

        @endforelse

    </div>

</body>
</html>
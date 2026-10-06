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

        .message {
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 6px;
        }

        .success {
            background: #d4edda;
            color: #155724;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
        }

        .layout {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
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

        .add-form {
            margin-top: 10px;
        }

        .quantity-input {
            width: 60px;
            padding: 8px;
            margin-right: 5px;
        }

        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            background: #ddd;
        }

        .btn:hover {
            background: #ccc;
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .btn-add {
            background: #28a745;
            color: white;
        }

        .btn-add:hover {
            background: #218838;
        }

        .cart {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            height: fit-content;
        }

        .cart h2 {
            margin-top: 0;
        }

        .cart-item {
            border-bottom: 1px solid #ddd;
            padding: 12px 0;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .cart-name {
            font-weight: bold;
        }

        .cart-detail {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
        }

        .cart-subtotal {
            font-weight: bold;
            margin-top: 5px;
        }

        .cart-total {
            border-top: 2px solid #333;
            margin-top: 15px;
            padding-top: 15px;
            font-size: 18px;
            font-weight: bold;
        }

        .payment-section {
            border-top: 1px solid #ddd;
            margin-top: 20px;
            padding-top: 20px;
        }

        .payment-section h3 {
            margin-top: 0;
        }

        .payment-input {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        .payment-button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 6px;
            background: #007bff;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        .payment-button:hover {
            background: #0069d9;
        }

        .payment-result {
            background: #e8f5e9;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .payment-result p {
            margin: 8px 0;
        }

        .change {
            font-size: 20px;
            font-weight: bold;
        }

        @media (max-width: 800px) {
            .layout {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <h1>Kasir</h1>

    {{-- Pesan berhasil --}}
    @if (session('success'))
        <div class="message success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Pesan error --}}
    @if (session('error'))
        <div class="message error">
            {{ session('error') }}
        </div>
    @endif

    <div class="layout">

        {{-- ========================= --}}
        {{-- DAFTAR MENU --}}
        {{-- ========================= --}}

        <div>

            <h2>Daftar Menu</h2>

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

                        {{-- Form Tambah --}}
                        <form
                            action="{{ route('transactions.cart.add') }}"
                            method="POST"
                            class="add-form"
                        >

                            @csrf

                            <input
                                type="number"
                                name="quantity"
                                value="1"
                                min="1"
                                max="{{ $menu->stock }}"
                                class="quantity-input"
                            >

                            <input
                                type="hidden"
                                name="menu_id"
                                value="{{ $menu->id }}"
                            >

                            <button
                                type="submit"
                                class="btn btn-add"
                            >
                                Tambah
                            </button>

                        </form>

                    </div>

                @empty

                    <p>Tidak ada menu yang tersedia.</p>

                @endforelse

            </div>

        </div>


        {{-- ========================= --}}
        {{-- KERANJANG --}}
        {{-- ========================= --}}

        <div class="cart">

            <h2>Keranjang</h2>

            @if (count($cart) > 0)

                @php
                    $total = 0;
                @endphp

                @foreach ($cart as $item)

                    @php
                        $total += $item['subtotal'];
                    @endphp

                    <div class="cart-item">

                        <div class="cart-name">
                            {{ $item['name'] }}
                        </div>

                        <div class="cart-detail">
                            Rp {{ number_format($item['price'], 0, ',', '.') }}
                            ×
                            {{ $item['quantity'] }}
                        </div>

                        <div class="cart-subtotal">
                            Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                        </div>

                        {{-- Update quantity --}}
                        <form
                            action="{{ route('transactions.cart.update') }}"
                            method="POST"
                            style="margin-top: 10px;"
                        >

                            @csrf

                            <input
                                type="hidden"
                                name="menu_id"
                                value="{{ $item['menu_id'] }}"
                            >

                            <button
                                type="submit"
                                name="quantity"
                                value="{{ $item['quantity'] - 1 }}"
                                class="btn"
                                {{ $item['quantity'] <= 1 ? 'disabled' : '' }}
                            >
                                −
                            </button>

                            <span style="margin: 0 10px;">
                                {{ $item['quantity'] }}
                            </span>

                            <button
                                type="submit"
                                name="quantity"
                                value="{{ $item['quantity'] + 1 }}"
                                class="btn"
                            >
                                +
                            </button>

                        </form>

                        {{-- Hapus item --}}
                        <form
                            action="{{ route('transactions.cart.remove') }}"
                            method="POST"
                            style="margin-top: 8px;"
                        >

                            @csrf

                            <input
                                type="hidden"
                                name="menu_id"
                                value="{{ $item['menu_id'] }}"
                            >

                            <button
                                type="submit"
                                class="btn"
                            >
                                Hapus
                            </button>

                        </form>

                    </div>

                @endforeach


                {{-- ========================= --}}
                {{-- TOTAL --}}
                {{-- ========================= --}}

                <div class="cart-total">
                    Total:
                    Rp {{ number_format($total, 0, ',', '.') }}
                </div>


                {{-- ========================= --}}
                {{-- HASIL PEMBAYARAN --}}
                {{-- ========================= --}}

                @if (session('payment'))

                    <div class="payment-result">

                        <strong>Pembayaran Berhasil</strong>

                        <p>
                            Total:
                            Rp {{ number_format(session('payment.total'), 0, ',', '.') }}
                        </p>

                        <p>
                            Dibayar:
                            Rp {{ number_format(session('payment.payment_amount'), 0, ',', '.') }}
                        </p>

                        <p class="change">
                            Kembalian:
                            Rp {{ number_format(session('payment.change'), 0, ',', '.') }}
                        </p>

                    </div>

                @endif


                {{-- ========================= --}}
                {{-- FORM PEMBAYARAN --}}
                {{-- ========================= --}}

                <div class="payment-section">

                    <h3>Pembayaran</h3>

                    <form
                        action="{{ route('transactions.payment') }}"
                        method="POST"
                    >

                        @csrf

                        <label for="payment_amount">
                            Jumlah Pembayaran
                        </label>

                        <input
                            type="number"
                            name="payment_amount"
                            id="payment_amount"
                            min="{{ $total }}"
                            step="1000"
                            placeholder="Masukkan jumlah uang"
                            class="payment-input"
                            required
                        >

                        <button
                            type="submit"
                            class="payment-button"
                        >
                            BAYAR
                        </button>

                    </form>

                </div>

            @else

                <p>Keranjang masih kosong.</p>

            @endif

        </div>

    </div>

</body>
</html>
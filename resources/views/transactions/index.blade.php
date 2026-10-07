<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kasir</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                            class="cart-update-form"
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

                            <span class="cart-quantity">
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
                            class="cart-remove-form"
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
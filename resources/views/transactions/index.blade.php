@extends('layouts.app')

@section('title', 'Kasir')

@section('content')

<div class="transaction-page">

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


    {{-- ========================= --}}
    {{-- LAYOUT UTAMA --}}
    {{-- ========================= --}}

    <div class="layout">


        {{-- ========================= --}}
        {{-- JUDUL DAFTAR MENU --}}
        {{-- ========================= --}}

        <h2 class="menu-title">
            Daftar Menu
        </h2>


        {{-- ========================= --}}
        {{-- DAFTAR MENU --}}
        {{-- ========================= --}}

        <div class="menu-container">

            @forelse ($menus as $menu)

                <div class="menu-card">

                    {{-- Foto Menu --}}
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


                    {{-- Nama Menu --}}
                    <div class="menu-name">
                        {{ $menu->name }}
                    </div>


                    {{-- Kategori --}}
                    <div class="menu-category">
                        {{ $menu->category->name }}
                    </div>


                    {{-- Harga --}}
                    <div class="menu-price">
                        Rp {{ number_format($menu->price, 0, ',', '.') }}
                    </div>


                    {{-- Stok --}}
                    <div class="menu-stock">
                        Stok: {{ $menu->stock }}
                    </div>


                    {{-- Form Tambah ke Keranjang --}}
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


        {{-- ========================= --}}
        {{-- KERANJANG --}}
        {{-- ========================= --}}

        <div class="cart">

            <h2>Keranjang</h2>

            @if (count($cart) > 0)

                @php
                    $total = 0;
                @endphp


                {{-- ========================= --}}
                {{-- ITEM KERANJANG --}}
                {{-- ========================= --}}

                @foreach ($cart as $item)

                    @php
                        $total += $item['subtotal'];
                    @endphp


                    <div class="cart-item">

                        {{-- Nama --}}
                        <div class="cart-name">
                            {{ $item['name'] }}
                        </div>


                        {{-- Harga × Quantity --}}
                        <div class="cart-detail">
                            Rp {{ number_format($item['price'], 0, ',', '.') }}
                            ×
                            {{ $item['quantity'] }}
                        </div>


                        {{-- Subtotal --}}
                        <div class="cart-subtotal">
                            Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                        </div>


                        {{-- ========================= --}}
                        {{-- UPDATE QUANTITY --}}
                        {{-- ========================= --}}

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

                            {{-- Kurangi --}}
                            <button
                                type="submit"
                                name="quantity"
                                value="{{ $item['quantity'] - 1 }}"
                                class="btn"
                                {{ $item['quantity'] <= 1 ? 'disabled' : '' }}
                            >
                                −
                            </button>


                            {{-- Quantity --}}
                            <span class="cart-quantity">
                                {{ $item['quantity'] }}
                            </span>


                            {{-- Tambah --}}
                            <button
                                type="submit"
                                name="quantity"
                                value="{{ $item['quantity'] + 1 }}"
                                class="btn"
                            >
                                +
                            </button>

                        </form>


                        {{-- ========================= --}}
                        {{-- HAPUS ITEM --}}
                        {{-- ========================= --}}

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

                        <strong>
                            Pembayaran Berhasil
                        </strong>

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

                    <h3>
                        Pembayaran
                    </h3>

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

                <p>
                    Keranjang masih kosong.
                </p>

            @endif

        </div>

    </div>

</div>

@endsection

@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <h1>Dashboard</h1>

    <p>
        Ringkasan Cashier System hari ini.
    </p>


    <div class="dashboard-grid">

        <div class="card">

            <h3>Penjualan Hari Ini</h3>

            <div class="value">
                Rp {{ number_format($todaySales, 0, ',', '.') }}
            </div>

        </div>


        <div class="card">

            <h3>Transaksi Hari Ini</h3>

            <div class="value">
                {{ $todayTransactions }}
            </div>

        </div>


        <div class="card">

            <h3>Total Menu</h3>

            <div class="value">
                {{ $totalMenus }}
            </div>

        </div>

    </div>


    <div class="card stock-card">

        <h2>Stok Rendah</h2>

        @if ($lowStockMenus->count() > 0)

            <table>

                <thead>

                    <tr>
                        <th>Menu</th>
                        <th>Stok</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach ($lowStockMenus as $menu)

                        <tr>

                            <td>
                                {{ $menu->name }}
                            </td>

                            <td>
                                {{ $menu->stock }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        @else

            <p>
                Tidak ada menu dengan stok rendah.
            </p>

        @endif

    </div>


    <div class="quick-actions">

        <h2>Akses Cepat</h2>

        <a href="{{ route('transactions.index') }}">
            Kasir
        </a>

        <a href="{{ route('menus.index') }}">
            Kelola Menu
        </a>

        <a href="{{ route('categories.index') }}">
            Kelola Kategori
        </a>

        <a href="{{ route('transactions.history') }}">
            Riwayat Transaksi
        </a>

    </div>

@endsection
<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Riwayat Transaksi</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="transaction-history-page">

<div class="transaction-history-container">

    <h1>Riwayat Transaksi</h1>

    <div class="top-bar">

        <a
            href="{{ route('transactions.index') }}"
            class="btn btn-cashier"
        >
            Kembali ke Kasir
        </a>

    </div>

    <div class="filter-container">

        <form
            action="{{ route('transactions.history') }}"
            method="GET"
        >

            <div class="filter-grid">

                <div class="filter-group">

                    <label for="invoice">
                        Invoice
                    </label>

                    <input
                        type="text"
                        id="invoice"
                        name="invoice"
                        value="{{ request('invoice') }}"
                        placeholder="Cari nomor invoice"
                    >

                </div>

                <div class="filter-group">

                    <label for="date_from">
                        Dari Tanggal
                    </label>

                    <input
                        type="date"
                        id="date_from"
                        name="date_from"
                        value="{{ request('date_from') }}"
                    >

                </div>

                <div class="filter-group">

                    <label for="date_to">
                        Sampai Tanggal
                    </label>

                    <input
                        type="date"
                        id="date_to"
                        name="date_to"
                        value="{{ request('date_to') }}"
                    >

                </div>

                <div class="filter-actions">

                    <button
                        type="submit"
                        class="btn btn-search"
                    >
                        Cari
                    </button>

                    <a
                        href="{{ route('transactions.history') }}"
                        class="btn btn-reset"
                    >
                        Reset
                    </a>

                </div>

            </div>

        </form>

    </div>

    <div class="transaction-count">

        Menampilkan
        <strong>{{ $transactions->count() }}</strong>
        transaksi.

    </div>

    <div class="table-container">

        @if ($transactions->count() > 0)

            <table>

                <thead>

                    <tr>

                        <th>No</th>

                        <th>Invoice</th>

                        <th>Tanggal</th>

                        <th>Total</th>

                        <th>Dibayar</th>

                        <th>Kembalian</th>

                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach ($transactions as $transaction)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $transaction->invoice_number }}
                            </td>

                            <td>
                                {{ $transaction->created_at->format('d/m/Y H:i') }}
                            </td>

                            <td>
                                Rp
                                {{ number_format($transaction->total_amount, 0, ',', '.') }}
                            </td>

                            <td>
                                Rp
                                {{ number_format($transaction->payment_amount, 0, ',', '.') }}
                            </td>

                            <td>
                                Rp
                                {{ number_format($transaction->change_amount, 0, ',', '.') }}
                            </td>

                            <td>

                                <a
                                    href="{{ route('transactions.detail', $transaction->id) }}"
                                    class="btn btn-detail"
                                >
                                    Detail
                                </a>

                                <a
                                    href="{{ route('transactions.receipt', $transaction->id) }}"
                                    class="btn btn-receipt"
                                >
                                    Lihat Struk
                                </a>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        @else

            <div class="empty">
                Belum ada transaksi.
            </div>

        @endif

    </div>

</div>

</body>

</html>
<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >


    <title>Detail Transaksi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="transaction-show-page">

<div class="transaction-show-container">

    <h1>Detail Transaksi</h1>

    <div class="card">

        <div class="info">

            <strong>Invoice</strong>

            {{ $transaction->invoice_number }}

        </div>

        <div class="info">

            <strong>Tanggal</strong>

            {{ $transaction->created_at->format('d/m/Y H:i:s') }}

        </div>

    </div>

    <div class="card">

        <h2>Daftar Menu</h2>

        <table>

            <thead>

                <tr>

                    <th>No</th>

                    <th>Menu</th>

                    <th>Harga</th>

                    <th>Jumlah</th>

                    <th>Subtotal</th>

                </tr>

            </thead>

            <tbody>

                @foreach ($transaction->details as $detail)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $detail->menu->name }}
                        </td>

                        <td>
                            Rp {{ number_format($detail->price, 0, ',', '.') }}
                        </td>

                        <td>
                            {{ $detail->quantity }}
                        </td>

                        <td>
                            Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

    <div class="card">

        <div class="info">

            <strong>Total</strong>

            Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}

        </div>

        <div class="info">

            <strong>Dibayar</strong>

            Rp {{ number_format($transaction->payment_amount, 0, ',', '.') }}

        </div>

        <div class="info">

            <strong>Kembalian</strong>

            Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}

        </div>

    </div>

    <div class="actions">

        <a
            href="{{ route('transactions.history') }}"
            class="btn btn-back"
        >
            Kembali ke Riwayat
        </a>

        <a
            href="{{ route('transactions.receipt', $transaction->id) }}"
            class="btn btn-receipt"
        >
            Lihat Struk
        </a>

    </div>

</div>

</body>

</html>

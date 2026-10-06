<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Detail Transaksi</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f5f5f5;
        }

        .container {
            max-width: 1000px;
            margin: auto;
        }

        h1 {
            margin-bottom: 20px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .info {
            margin-bottom: 8px;
        }

        .info strong {
            display: inline-block;
            width: 130px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #f1f1f1;
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .total-row {
            font-weight: bold;
        }

        .btn {
            display: inline-block;
            padding: 9px 14px;
            border-radius: 6px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            margin-right: 5px;
        }

        .btn-back {
            background: #6c757d;
            color: white;
        }

        .btn-receipt {
            background: #28a745;
            color: white;
        }

        .actions {
            margin-top: 20px;
        }

        @media (max-width: 700px) {

            th,
            td {
                font-size: 14px;
                padding: 8px;
            }

            .info strong {
                width: 100px;
            }
        }
    </style>
</head>

<body>

<div class="container">

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
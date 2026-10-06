<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Riwayat Transaksi</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f5f5f5;
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        h1 {
            margin-bottom: 20px;
        }

        .top-bar {
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 9px 14px;
            border-radius: 6px;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .btn-cashier {
            background: #007bff;
            color: white;
        }

        .table-container {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #f1f1f1;
        }

        .text-right {
            text-align: right;
        }

        .btn-receipt {
            background: #28a745;
            color: white;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #666;
        }

        @media (max-width: 700px) {

            th,
            td {
                font-size: 14px;
                padding: 8px;
            }

        }
      .btn-detail {
          background: #17a2b8;
          color: white;
        }

    </style>

</head>

<body>

<div class="container">

    <h1>Riwayat Transaksi</h1>

    <div class="top-bar">

        <a
            href="{{ route('transactions.index') }}"
            class="btn btn-cashier"
        >
            Kembali ke Kasir
        </a>

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
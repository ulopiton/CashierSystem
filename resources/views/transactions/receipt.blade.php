<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Struk {{ $transaction->invoice_number }}</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 30px;
        }

        .receipt {
            width: 380px;
            max-width: 100%;
            margin: auto;
            background: white;
            padding: 25px;
            box-sizing: border-box;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0;
            color: #666;
        }

        .info {
            font-size: 14px;
            margin-bottom: 20px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }

        .item {
            border-bottom: 1px dashed #ccc;
            padding: 10px 0;
        }

        .item-name {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .item-detail {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
        }

        .summary {
            margin-top: 20px;
            border-top: 2px solid #333;
            padding-top: 15px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .total {
            font-size: 18px;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: 25px;
            padding-top: 15px;
            border-top: 1px dashed #ccc;
            font-size: 14px;
            color: #666;
        }

        .actions {
            text-align: center;
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            margin: 5px;
        }

        .btn-print {
            background: #007bff;
            color: white;
        }

        .btn-back {
            background: #6c757d;
            color: white;
        }

        @media print {

            body {
                background: white;
                padding: 0;
            }

            .receipt {
                width: 100%;
                max-width: 380px;
                box-shadow: none;
                padding: 10px;
            }

            .actions {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="receipt">

        <div class="header">

            <h1>RESTORAN</h1>

            <p>Struk Pembayaran</p>

        </div>

        <div class="info">

            <div class="info-row">
                <span>Invoice</span>

                <strong>
                    {{ $transaction->invoice_number }}
                </strong>
            </div>

            <div class="info-row">
                <span>Tanggal</span>

                <span>
                    {{ $transaction->created_at->format('d/m/Y H:i') }}
                </span>
            </div>

        </div>

        @foreach ($transaction->details as $detail)

            <div class="item">

                <div class="item-name">
                    {{ $detail->menu->name }}
                </div>

                <div class="item-detail">

                    <span>
                        {{ $detail->quantity }}
                        ×
                        Rp {{ number_format($detail->price, 0, ',', '.') }}
                    </span>

                    <strong>
                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                    </strong>

                </div>

            </div>

        @endforeach

        <div class="summary">

            <div class="summary-row total">

                <span>Total</span>

                <span>
                    Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                </span>

            </div>

            <div class="summary-row">

                <span>Dibayar</span>

                <span>
                    Rp {{ number_format($transaction->payment_amount, 0, ',', '.') }}
                </span>

            </div>

            <div class="summary-row">

                <span>Kembalian</span>

                <span>
                    Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}
                </span>

            </div>

        </div>

        <div class="footer">

            <p>Terima kasih atas kunjungan Anda.</p>

            <p>Silakan datang kembali.</p>

        </div>

    </div>

    <div class="actions">

        <button
            onclick="window.print()"
            class="btn btn-print"
        >
            Cetak Struk
        </button>

        <a
            href="{{ route('transactions.index') }}"
            class="btn btn-back"
        >
            Kembali ke Kasir
        </a>

    </div>

</body>

</html>

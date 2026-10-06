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
      .filter-container {
          background: white;
          padding: 20px;
          border-radius: 10px;
          margin-bottom: 20px;
          box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      }
      
      .filter-grid {
          display: grid;
          grid-template-columns: 1fr 1fr 1fr auto;
          gap: 15px;
          align-items: end;
      }
      
      .filter-group {
          display: flex;
          flex-direction: column;
      }
      
      .filter-group label {
          margin-bottom: 6px;
          font-weight: bold;
      }
      
      .filter-group input {
          padding: 10px;
          border: 1px solid #ccc;
          border-radius: 6px;
          font-size: 14px;
      }
      
      .filter-actions {
          display: flex;
          gap: 8px;
      }
      
      .btn-search {
          background: #007bff;
          color: white;
      }
      
      .btn-reset {
          background: #6c757d;
          color: white;
      }
      
      @media (max-width: 800px) {
      
        .filter-grid {
            grid-template-columns: 1fr;
        }
  
        .filter-actions {
            margin-top: 5px;
        }
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
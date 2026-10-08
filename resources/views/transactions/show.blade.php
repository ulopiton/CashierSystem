@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')

<div class="transaction-show-page">

    <div class="transaction-show-container">

        <h1>
            Detail Transaksi
        </h1>


        {{-- ========================= --}}
        {{-- INFORMASI TRANSAKSI --}}
        {{-- ========================= --}}

        <div class="card">

            <div class="info">

                <strong>
                    Invoice
                </strong>

                {{ $transaction->invoice_number }}

            </div>


            <div class="info">

                <strong>
                    Tanggal
                </strong>

                {{ $transaction->created_at->format('d/m/Y H:i:s') }}

            </div>

        </div>


        {{-- ========================= --}}
        {{-- DAFTAR MENU --}}
        {{-- ========================= --}}

        <div class="card">

            <h2>
                Daftar Menu
            </h2>

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
                                Rp
                                {{ number_format($detail->price, 0, ',', '.') }}
                            </td>

                            <td>
                                {{ $detail->quantity }}
                            </td>

                            <td>
                                Rp
                                {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>


        {{-- ========================= --}}
        {{-- RINGKASAN PEMBAYARAN --}}
        {{-- ========================= --}}

        <div class="card">

            <div class="info">

                <strong>
                    Total
                </strong>

                Rp
                {{ number_format($transaction->total_amount, 0, ',', '.') }}

            </div>


            <div class="info">

                <strong>
                    Dibayar
                </strong>

                Rp
                {{ number_format($transaction->payment_amount, 0, ',', '.') }}

            </div>


            <div class="info">

                <strong>
                    Kembalian
                </strong>

                Rp
                {{ number_format($transaction->change_amount, 0, ',', '.') }}

            </div>

        </div>


        {{-- ========================= --}}
        {{-- ACTION --}}
        {{-- ========================= --}}

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

</div>

@endsection

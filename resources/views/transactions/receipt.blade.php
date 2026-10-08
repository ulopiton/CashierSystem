@extends('layouts.app')

@section('title', 'Struk ' . $transaction->invoice_number)

@section('content')

<div class="transaction-receipt-page">

    <div class="receipt">

        <div class="header">

            <h1>RESTORAN</h1>

            <p>Struk Pembayaran</p>

        </div>


        <div class="info">

            <div class="info-row">

                <span>
                    Invoice
                </span>

                <strong>
                    {{ $transaction->invoice_number }}
                </strong>

            </div>


            <div class="info-row">

                <span>
                    Tanggal
                </span>

                <span>
                    {{ $transaction->created_at->format('d/m/Y H:i') }}
                </span>

            </div>

        </div>


        {{-- ========================= --}}
        {{-- DETAIL ITEM --}}
        {{-- ========================= --}}

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


        {{-- ========================= --}}
        {{-- SUMMARY --}}
        {{-- ========================= --}}

        <div class="summary">

            <div class="summary-row total">

                <span>
                    Total
                </span>

                <span>
                    Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                </span>

            </div>


            <div class="summary-row">

                <span>
                    Dibayar
                </span>

                <span>
                    Rp {{ number_format($transaction->payment_amount, 0, ',', '.') }}
                </span>

            </div>


            <div class="summary-row">

                <span>
                    Kembalian
                </span>

                <span>
                    Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}
                </span>

            </div>

        </div>


        {{-- ========================= --}}
        {{-- FOOTER STRUK --}}
        {{-- ========================= --}}

        <div class="footer">

            <p>
                Terima kasih atas kunjungan Anda.
            </p>

            <p>
                Silakan datang kembali.
            </p>

        </div>

    </div>


    {{-- ========================= --}}
    {{-- ACTION --}}
    {{-- ========================= --}}

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

</div>

@endsection

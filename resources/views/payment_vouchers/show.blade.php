@extends('layouts.invoice')

@section('title', 'payment_vouchers')

@section('sub-title', 'show')

@section('content')
<div class="receipt-main">
    <div class="container">
        <h5>ELMA SHIPPING AND TRADING SARL</h5>
        <h5 class="my-2">REG#3802724</h5>

        <h5 class="text-center my-4">PAYMENT VOUCHER #{{ $payment_voucher->number }}</h5>

        <h5 class="text-right my-4">DATE {{ $payment_voucher->date }}</h5>
        <br>
        <div class="border-custom my-4">
            <table class="w-100">
                <thead>
                    <tr style="font-size: 0.9rem;">
                        <th class="p-2 col-3">PAID TO</th>
                        <th class="p-2 col-9 border-left">{{ ucwords($payment_voucher->supplier->name) }}</th>
                    </tr>
                </thead>
            </table>
        </div>
        <br>
        <div class="border-custom my-4">
            <table class="w-100">
                <thead class="border-bottom text-center">
                    <tr style="font-size: 0.9rem;">
                        <th class="p-2 col-9">Description</th>
                        <th class="p-2 col-3 border-left">Amount ({{ $payment_voucher->currency->code }})</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse ($payment_voucher->items as $item)
                    <tr>
                        <td class="p-2">{{ $item->description }}</td>
                        <td class="border-left p-2">{{ number_format($item->amount, 2) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td class="p-2" colspan="3">No Payment Voucher Items Yet</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot class="border-top text-center">
                    <tr class="border-top">
                        <th class="p-2 text-uppercase">{{
                            Helper::format_currency_to_words($payment_voucher->total)
                            }}</th>
                        <th class="p-2 border-left">{{
                            number_format($payment_voucher->total, 2) }}
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection
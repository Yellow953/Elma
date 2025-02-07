@extends('layouts.invoice')

@section('title', 'receipts')

@section('sub-title', 'show')

@section('content')
<div class="receipt-main">
    <div class="container">
        <div>
            <div class="row mb-5">
                <div class="col-md-6">
                    <strong>Receipt Number:</strong> {{ $receipt->receipt_number }} <br>
                    <strong>Supplier:</strong> {{ $receipt->supplier->name }}
                </div>
                <div class="col-md-3 offset-md-3">
                    <strong>Date: </strong>{{ ucwords($receipt->date) }} <br>
                    <strong>Currency: </strong>{{ ucwords($receipt->currency->code) }} <br>
                </div>
            </div>

            <div class="border-custom">
                <table class="w-100">
                    <thead class="border-bottom text-center">
                        <tr style="font-size: 0.9rem;">
                            <th class="p-2 col-4">Receipt Number</th>
                            <th class="p-2 col-4 border-left">Description</th>
                            <th class="p-2 col-4 border-left">Amount ({{ $receipt->currency->code }})</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse ($items as $item)
                        <tr>
                            <td class="p-2">{{ $item->supplier_receipt }}</td>
                            <td class="border-left p-2">{{ $item->description }}</td>
                            <td class="border-left p-2">{{ number_format($item->total_cost, 2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td class="p-2" colspan="3">No Receipt Items Yet</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="border-top text-center">
                        <tr>
                            <th class="p-2" colspan="2">{{
                                Helper::format_currency_to_words($items->sum('total_cost_after_vat')) }}</th>
                            <th class="p-2 border-left">{{ number_format($items->sum('total_cost_after_vat'), 2) }}
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
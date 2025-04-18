@extends('layouts.invoice')

@section('title', 'receipts')

@section('sub-title', 'show')

@section('content')
<div class="receipt-main">
    <div class="container">
        <h5 class="mb-5">REG#3802724</h5>

        <div>
            <div class="row mb-5 d-flex align-items-stretch">
                <div class="col-md-6 border-custom p-3 d-flex flex-column">
                    <strong>Receipt Number:</strong> {{ $receipt->receipt_number }} <br>
                    <strong>Supplier:</strong> {{ $receipt->supplier->name }}
                </div>

                <div class="col-md-3 offset-md-3 border-custom p-3 d-flex flex-column">
                    <strong>Date: </strong>{{ \Carbon\Carbon::parse($receipt->date)->format('d-m-Y') }} <br>
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
                        {{-- <tr>
                            <th class="p-2">Sub Total</th>
                            <th class="border-left p-2">{{ $items->sum('total_cost') }}</th>
                        </tr>
                        <tr class="border-top">
                            <th class="p-2">Vat</th>
                            <th class="border-left p-2">{{ $items->sum('total_cost') }}</th>
                        </tr> --}}
                        <tr class="border-top">
                            <th class="p-2 text-uppercase" colspan="2">{{
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
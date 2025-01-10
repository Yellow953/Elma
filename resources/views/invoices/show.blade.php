@extends('layouts.invoice')

@section('title', 'invoices')

@section('sub-title', 'show')

@section('content')
<div class="container">
    <a href="{{ url()->previous() }}" class="btn btn-secondary px-3 py-2">
        <i class="fa-solid fa-chevron-left"></i> Back </a>

    <div class="receipt-main">
        @include('layouts._invoice_header')

        <div class="container">
            <div>
                <div class="row mb-5">
                    <div class="col-md-6">
                        <strong>Invoice Number:</strong>{{ $invoice->invoice_number }} <br>
                        <strong>Client: </strong>{{ucwords($invoice->client->name)}} <br>
                    </div>
                    <div class="col-md-3 offset-md-3">
                        <strong>Date: </strong>{{ ucwords($invoice->date) }} <br>
                        <strong>Currency: </strong>{{ucwords($invoice->currency->code)}} <br>
                    </div>
                </div>

                <div class="">
                    <div class="table-responsive overflow-auto">
                        <table class="table table-striped">
                            <thead class="text-center">
                                <tr style="font-size: 0.9rem">
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse ($invoice->invoice_items as $item)
                                <tr>
                                    <td class="col-4">
                                        {{ $item->item->name }} <br>
                                        {{ $item->item->description }}
                                    </td>
                                    <td class="col-2">{{ number_format($item->quantity, 2) }}</td>
                                    <td class="col-2">{{ number_format($item->unit_price, 2) }}</td>
                                    <td class="col-2">{{ number_format($item->total_price, 2) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4">No Invoice Items Yet</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="text-center">
                                <tr class="bg-dark text-white" style="font-size: 0.8rem">
                                    <th colspan="2"></th>
                                    <th>Total</th>
                                    <th>{{ number_format($total_price, 2) }}</th>
                                </tr>
                                <tr class="bg-dark text-white" style="font-size: 0.8rem">
                                    <th colspan="2"></th>
                                    <th>Tax</th>
                                    <th>{{ number_format($total_tax, 2) }}</th>
                                </tr>
                                <tr class="bg-dark text-white" style="font-size: 0.8rem">
                                    <th colspan="2"></th>
                                    <th>Total Price After VAT</th>
                                    <th>{{ number_format($total_after_tax, 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
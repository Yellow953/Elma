@extends('layouts.invoice')

@section('title', 'receipts')

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
                        <strong>Receipt Number:</strong>
                        {{ $receipt->receipt_number }} <br>
                        <strong>Supplier:</strong> {{ $receipt->supplier->name }} <br>
                        <strong>Supplier Invoice:</strong> {{ucwords($receipt->supplier_invoice)}} <br>
                    </div>
                    <div class="col-md-3 offset-md-3">
                        <strong>Date: </strong>{{ ucwords($receipt->date) }} <br>
                        <strong>Currency: </strong>{{ucwords($receipt->currency->code) }} <br>
                        <strong>Foreign Currency: </strong>{{ucwords($receipt->foreign_currency->code) }} <br>
                    </div>
                </div>

                <div class="mt-5">
                    <h4 class="text-primary text-center my-4">Landed Cost</h4>
                    <div class="table-responsive overflow-auto">
                        <table class="table table-striped">
                            <thead class="text-center">
                                <tr style="font-size: 0.9rem">
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Supplier</th>
                                    <th>Currency</th>
                                    <th>Rate</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse ($receipt->landed_costs as $lc)
                                <tr>
                                    <td>{{ $lc->date }}</td>
                                    <td>{{ $lc->name }}</td>
                                    <td>{{ $lc->supplier->name }}</td>
                                    <td>{{ $lc->currency->code }}</td>
                                    <td>{{ number_format($lc->rate) }}</td>
                                    <td>{{ number_format($lc->amount, 2) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6">No Landed Costs Yet</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr class="bg-dark text-white text-center" style="font-size: 0.9rem">
                                    <th colspan="5"></th>
                                    <th>{{ number_format($total_landed_cost, 2) }}</th>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div> <br>

                <div class="">
                    <h4 class="text-primary text-center my-4">Items</h4>
                    <div class="table-responsive overflow-auto">
                        <table class="table table-striped">
                            <thead class="text-center">
                                <tr style="font-size: 0.9rem;">
                                    <th>Item</th>
                                    <th>Barcodes</th>
                                    <th>Quantity</th>
                                    <th>Unit Cost</th>
                                    <th>Total Cost</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse ($receipt->receipt_items as $item)
                                <tr>
                                    <td class="col-4">{{ $item->item->itemcode }}
                                        <br>{{ $item->item->description }}
                                    </td>
                                    <td class="col-2">
                                        @if ($item->item->type == 'Serialized')
                                        @forelse ($item->item->barcodes as $barcode)
                                        @if($barcode->receipt_id == $receipt->id)
                                        {{ $barcode->barcode }},
                                        @endif
                                        @empty
                                        No Barcodes
                                        @endforelse
                                        @else
                                        Item Not Serialized
                                        @endif
                                    </td>
                                    <td class="col-2">{{ number_format($item->quantity, 2) }}</td>
                                    <td class="col-2">{{ number_format($item->unit_cost, 2) }}</td>
                                    <td class="col-2">{{ number_format($item->total_cost, 2) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5">No Receipt Items Yet</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="text-center">
                                <tr class="bg-dark text-white" style="font-size: 0.8rem">
                                    <th colspan="3"></th>
                                    <th>Total</th>
                                    <th>{{ number_format($total, 2) }}</th>
                                </tr>
                                <tr class="bg-dark text-white" style="font-size: 0.8rem">
                                    <th colspan="3"></th>
                                    <th>Total Foreign</th>
                                    <th>{{ number_format($total_foreign, 2) }}</th>
                                </tr>
                                <tr class="bg-dark text-white" style="font-size: 0.8rem">
                                    <th colspan="3"></th>
                                    <th>Tax</th>
                                    <th>{{ number_format($total_tax, 2) }}</th>
                                </tr>
                                <tr class="bg-dark text-white" style="font-size: 0.8rem">
                                    <th colspan="3"></th>
                                    <th>Total After TAX</th>
                                    <th>{{ number_format($total_after_tax, 2) }}</th>
                                </tr>
                                <tr class="bg-dark text-white" style="font-size: 0.8rem">
                                    <th colspan="3"></th>
                                    <th>Total After Landed Cost</th>
                                    <th>{{ number_format($total_after_landed_cost, 2) }}</th>
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
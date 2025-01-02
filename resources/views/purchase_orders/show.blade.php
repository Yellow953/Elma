@extends('layouts.invoice')

@section('title', 'purchase_orders')

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
                        <strong>SO Number:</strong> {{ $purchase_order->po_number }} <br>
                        <strong>Supplier: </strong>{{ucwords($purchase_order->supplier->name)}} <br>
                        <strong>Status: </strong>{{ucwords($purchase_order->status)}} <br>
                    </div>
                    <div class="col-md-6 text-right">
                        <strong>Order Date: </strong>{{ $purchase_order->order_date}} <br>
                        @if ($purchase_order->due_date)
                        <strong>Due Date: </strong>{{ $purchase_order->due_date}} <br>
                        @endif
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
                                @forelse ($purchase_order->items as $item)
                                <tr>
                                    <td class="col-4">
                                        {{ $item->item->name }}
                                    </td>
                                    <td class="col-2">{{ number_format($item->quantity, 2) }}</td>
                                    <td class="col-2">{{ number_format($item->unit_price, 2) }}</td>
                                    <td class="col-2">{{ number_format($item->total_price, 2) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5">No Sales Order Items Yet</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <h5>Notes</h5>
                        <p class="text-center mt-2">
                            {{ $purchase_order->notes ?? 'No Notes...' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
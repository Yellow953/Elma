@extends('layouts.invoice')

@section('title', 'purchase_orders')

@section('sub-title', 'show')

@section('content')
<div class="receipt-main">
    <div class="container">
        <h5 class="mb-5">REG#3802724</h5>

        <div class="row mb-5 d-flex align-items-stretch">
            <div class="col border-custom p-3 d-flex flex-column">
                <strong>SO Number:</strong> {{ $purchase_order->po_number }} <br>
                <strong>Supplier: </strong>{{ ucwords($purchase_order->supplier->name) }} <br>
                <strong>Status: </strong>{{ ucwords($purchase_order->status) }} <br>
            </div>

            <div class="col-md-1"></div>

            <div class="col text-right border-custom p-3 d-flex flex-column">
                <strong>Order Date: </strong>{{ \Carbon\Carbon::parse($purchase_order->order_date)->format('d-m-Y')
                }}<br>
                @if ($purchase_order->due_date)
                <strong>Due Date: </strong>{{ \Carbon\Carbon::parse($purchase_order->due_date)->format('d-m-Y') }}<br>
                @endif
            </div>
        </div>

        <div class="">
            <div class="border-custom">
                <table class="w-100">
                    <thead class="border-bottom text-center">
                        <tr style="font-size: 0.9rem">
                            <th class="p-2">Item</th>
                            <th class="p-2">Quantity</th>
                            <th class="p-2">Unit Price</th>
                            <th class="p-2">Total Price</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse ($purchase_order->items as $item)
                        <tr>
                            <td class="col-4 p-2">
                                {{ $item->item->name }}
                            </td>
                            <td class="col-2 p-2">{{ number_format($item->quantity, 2) }}</td>
                            <td class="col-2 p-2">{{ number_format($item->unit_price, 2) }}</td>
                            <td class="col-2 p-2">{{ number_format($item->total_price, 2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td class="p-2" colspan="5">No Sales Order Items Yet</td>
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
@endsection
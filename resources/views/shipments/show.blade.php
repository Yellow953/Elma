@extends('layouts.invoice')

@section('title', 'shipments')

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
                        <strong>Shipment Number:</strong>{{ $shipment->shipment_number }} <br>
                        <strong>Mode:</strong>{{ $shipment->mode }} <br>
                        <strong>Client: </strong>{{ucwords($shipment->client->name)}} <br>
                        <strong>Status: </strong>{{ucwords($shipment->status)}} <br>
                    </div>
                    <div class="col-md-6 text-right">
                        <strong>Commodity: </strong>{{ $shipment->commodity }} <br>
                        <strong>Departure: </strong>{{ $shipment->departure }} <br>
                        <strong>Arrival: </strong>{{ $shipment->arrival}} <br>
                        <strong>Shipping Date: </strong>{{ $shipment->shipping_date}} <br>
                        @if ($shipment->delivery_date)
                        <strong>Delivery Date: </strong>{{ $shipment->delivery_date}} <br>
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
                                @forelse ($shipment->items as $item)
                                <tr>
                                    <td class="col-4">
                                        {{ $item->item->name }} <br>
                                        {{ $item->supplier_id ? $item->supplier->name : '' }}
                                    </td>
                                    <td class="col-2">{{ number_format($item->quantity, 2) }}</td>
                                    <td class="col-2">{{ number_format($item->unit_price, 2) }}</td>
                                    <td class="col-2">{{ number_format($item->total_price, 2) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5">No Shipment Items Yet</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <h5>Notes</h5>
                        <p class="text-center mt-2">
                            {{ $shipment->notes ?? 'No Notes...' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

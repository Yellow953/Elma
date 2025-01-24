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
                <h2 class="text-center">
                    Shipment Number: {{ $shipment->shipment_number }}
                </h2>

                <div class="row my-5 px-3">
                    <div class="col-5 border-custom py-3 px-4">
                        <div class="row">
                            <div class="col-3">
                                Mode
                            </div>
                            <div class="col-9">
                                {{ $shipment->mode }}
                            </div>
                            <div class="col-3">
                                Client
                            </div>
                            <div class="col-9">
                                {{ $shipment->client->name }}
                            </div>
                            <div class="col-3">
                                Consignee
                            </div>
                            <div class="col-9">
                                {{ $shipment->consignee_name }}
                            </div>
                            <div class="col-3">
                            </div>
                            <div class="col-9">
                                {{ $shipment->consignee_country }}
                            </div>
                            <div class="col-3">
                                Commodity
                            </div>
                            <div class="col-9">
                                {{ $shipment->commodity }}
                            </div>
                            <div class="col-3">
                                Carrier
                            </div>
                            <div class="col-9">
                                {{ $shipment->carrier_name }}
                            </div>
                        </div>
                    </div>
                    <div class="col-2"></div>
                    <div class="col-5 border-custom py-3 px-4">
                        <div class="row">
                            <div class="col-3">
                                Arrival
                            </div>
                            <div class="col-9">
                                {{ $shipment->arrival }}
                            </div>
                            <div class="col-3">
                                Departure
                            </div>
                            <div class="col-9">
                                {{ $shipment->departure }}
                            </div>
                            <div class="col-3">
                                Shipping
                            </div>
                            <div class="col-9">
                                {{ $shipment->shipping_date }}
                            </div>
                            <div class="col-3">
                                Loading
                            </div>
                            <div class="col-9">
                                {{ $shipment->loading_date }}
                            </div>
                            <div class="col-3">
                                Vessel
                            </div>
                            <div class="col-9">
                                {{ $shipment->vessel_name }}
                            </div>
                            <div class="col-3">
                            </div>
                            <div class="col-9">
                                {{ $shipment->vessel_date }}
                            </div>
                            <div class="col-3">
                                Booking Number
                            </div>
                            <div class="col-9">
                                {{ $shipment->booking_number }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="my-5">
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

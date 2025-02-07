@extends('layouts.invoice')

@section('title', 'sales_orders')

@section('sub-title', 'show')

@section('content')
<div class="receipt-main">
    <div class="container">
        <div>
            <div class="row my-5 px-3">
                <div class="col-5 mb-auto border-custom p-0">
                    <table class="w-100 m-0">
                        <tr class="border-none">
                            <th class="w-custom p-2">Due From</th>
                            <td colspan="2" class="py-2 px-4 border-left">
                                {{ $shipment->due_from->name }} <br>
                                TEL: {{ $shipment->due_from->phone }} <br>
                                {{ $shipment->due_from->address }}
                            </td>
                        </tr>

                        <tr class="border-none">
                            <th class="w-custom p-2">Shipper</th>
                            <td colspan="2" class="py-2 px-4 border-left">
                                {{ $shipment->shipper }}
                            </td>
                        </tr>

                        <tr class="border-none">
                            <th class="w-custom p-2">Consignee</th>
                            <td colspan="2" class="py-2 px-4 border-left">
                                {{ $shipment->consignee_name }} <br>
                                {{ $shipment->consignee_country }}
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-2"></div>
                <div class="col-5 mb-auto border-custom p-0">
                    <table class="w-100 m-0">
                        <tr class="border-none">
                            <th class="w-custom p-1">Date</th>
                            <td colspan="2" class="py-1 px-4 border-left">
                                {{ $shipment->created_at->format('d-m-Y') }}
                            </td>
                        </tr>

                        <tr class="border-none">
                            <th class="w-custom p-1">FILE#</th>
                            <td colspan="2" class="py-1 px-4 border-left">
                                {{ $shipment->shipment_number }}
                            </td>
                        </tr>

                        <tr class="border-none">
                            <th class="w-custom p-1">Container#</th>
                            <td colspan="2" class="py-1 px-4 border-left">
                                {{ $shipment->container_number }}
                            </td>
                        </tr>

                        <tr class="border-none">
                            <th class="w-custom p-1">Vessel</th>
                            <td colspan="2" class="py-1 px-4 border-left">
                                {{ $shipment->vessel_name }}
                            </td>
                        </tr>

                        <tr class="border-none">
                            <th class="w-custom p-1">Loading Date</th>
                            <td colspan="2" class="py-1 px-4 border-left">
                                {{ $shipment->loading_date }}
                            </td>
                        </tr>

                        <tr class="border-none">
                            <th class="w-custom p-1">Commodity</th>
                            <td colspan="2" class="py-1 px-4 border-left">
                                {{ $shipment->commodity }}
                            </td>
                        </tr>

                        <tr class="border-none">
                            <th class="w-custom p-1">POL</th>
                            <td colspan="2" class="py-1 px-4 border-left">
                                {{ $shipment->departure }}
                            </td>
                        </tr>

                        <tr class="border-none">
                            <th class="w-custom p-1">POD</th>
                            <td colspan="2" class="py-1 px-4 border-left">
                                {{ $shipment->arrival }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col-md-6">
                    <strong>SO Number:</strong> {{ $sales_order->so_number }} <br>
                    <strong>Client: </strong>{{ucwords($sales_order->client->name)}} <br>
                    <strong>Status: </strong>{{ucwords($sales_order->status)}} <br>
                </div>
                <div class="col-md-6 text-right">
                    <strong>Order Date: </strong>{{ $sales_order->order_date}} <br>
                    @if ($sales_order->due_date)
                    <strong>Due Date: </strong>{{ $sales_order->due_date}} <br>
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
                            @forelse ($sales_order->items as $item)
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
                        {{ $sales_order->notes ?? 'No Notes...' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
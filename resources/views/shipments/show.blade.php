@extends('layouts.invoice')

@section('title', 'shipments')

@section('sub-title', 'show')

@section('content')
<div class="receipt-main">
    <div class="container">
        <div>
            <h5 class="mb-5">REG#3802724</h5>

            <h2 class="text-center">
                Shipment Number: {{ $shipment->shipment_number }}
            </h2>

            <div class="row my-5 px-3 d-flex align-items-stretch">
                <div class="col border-custom p-0 d-flex flex-column">
                    <table class="w-100 m-0 flex-grow-1">
                        <tr class="border-none">
                            <th class="w-custom p-2 align-content-start">Due From</th>
                            <td colspan="2" class="py-2 px-4 border-left align-content-start">
                                {{ $shipment->due_from->name }} <br>
                                @if ($shipment->due_from->phone)
                                TEL: {{ $shipment->due_from->phone }} <br>
                                @endif
                                {{ $shipment->due_from->address }} <br>
                                {{ $shipment->due_from->vat_number }}
                            </td>
                        </tr>
                        <tr class="border-none">
                            <th class="w-custom p-2 align-content-start">Shipper</th>
                            <td colspan="2" class="py-2 px-4 border-left align-content-start">
                                {{ $shipment->shipper }}
                            </td>
                        </tr>
                        <tr class="border-none">
                            <th class="w-custom p-2 align-content-start">Consignee</th>
                            <td colspan="2" class="py-2 px-4 border-left align-content-start">
                                {{ $shipment->consignee_name }} <br>
                                {{ $shipment->consignee_country }}
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="col-1"></div>

                <div class="col border-custom p-0 d-flex flex-column">
                    <table class="w-100 m-0 flex-grow-1">
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
                                {{ \Carbon\Carbon::parse($shipment->loading_date)->format('d-m-Y') }}
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

            <div class="my-5">
                <div class="border-custom">
                    <table class="w-100 m-0">
                        <thead class="border-bottom">
                            <tr>
                                <th class="col-9 p-2">Description</th>
                                <th class="col-3 p-2 border-left">Amount(USD)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($shipment->items as $item)
                            <tr>
                                <th class="p-2">{{ ucwords($item->item->name) }}</th>
                                <td class="border-left p-2">
                                    {{ number_format($item->total_price, 2) }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="p-2" colspan="2">No Shipment Items Yet</td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="border-top">
                            <tr>
                                <th class="p-2 text-uppercase">
                                    {{ Helper::format_currency_to_words($item->sum('total_price')) }}
                                </th>
                                <th class="border-left p-2">
                                    {{ number_format($item->sum('total_price'), 2) }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <br><br><br>

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
@endsection
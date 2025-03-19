@extends('layouts.invoice')

@section('title', 'invoices')

@section('sub-title', 'show')

@section('content')
<div class="receipt-main">
    <div class="container">
        <h5 class="mb-4">REG#3802724</h5>

        <h2 class="text-center">
            Invoice Number: {{ $invoice->invoice_number }}
        </h2>

        <div class="row my-5 px-3 d-flex">
            <div class="col border-custom p-0 d-flex flex-column">
                <table class="w-100 m-0 flex-grow-1">
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

        <div class="mt-4">
            <div class="border-custom">
                <table class="w-100">
                    <thead class="text-center">
                        <tr class="border-bottom">
                            <th class="col-9 p-2">Description</th>
                            <th class="col-3 border-left p-2">Amount ({{ $invoice->currency->code }})</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse ($items as $item)
                        @if ($item->type == 'item')
                        <tr>
                            <td class="p-2">
                                {{ $item->description }}
                            </td>
                            <td class="border-left p-2">{{ number_format($item->total_price, 2) }}</td>
                        </tr>
                        @endif
                        @empty
                        <tr>
                            <td class="p-2" colspan="2">No Invoice Items Yet</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="text-center border-top">
                        <tr>
                            <th class="p-2">Sub Total</th>
                            <th class="border-left p-2">{{ $total }}</th>
                        </tr>
                        <tr class="border-top">
                            <th class="p-2">Vat</th>
                            <th class="border-left p-2">{{ $vat }}</th>
                        </tr>
                        <tr class="border-top">
                            <th class="p-2 text-uppercase">{{ Helper::format_currency_to_words($total_price_after_vat)
                                }}</th>
                            <th class="border-left p-2">{{ number_format($total_price_after_vat, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
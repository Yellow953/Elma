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
                        <th class="w-custom p-2 align-content-start">Due From</th>
                        <td colspan="2" class="py-2 px-4 border-left align-content-start">
                            {{ $shipment->due_from->name }} <br>
                            TEL: {{ $shipment->due_from->phone }} <br>
                            {{ $shipment->due_from->address }}
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

        <br>
        <div>
            <div class="border-custom">
                <div class="d-flex border-bottom">
                    <div class="col-9 p-2 fw-bold">Description</div>
                    <div class="col-3 border-left p-2 fw-bold">Amount ({{ $invoice->currency->code }})</div>
                </div>

                <div class="w-100 min-h">
                    @foreach ($items as $item)
                    @if ($item->type == 'item')
                    <div class="row-flex w-100" style="max-height: 50px;">
                        <div class="col-9 p-2 text-center" style="font-size: 20px;">{{ $item->description }}</div>
                        <div class="col-3 p-2 border-left">{{ number_format($item->total_price, 2) }}</div>
                    </div>
                    @endif
                    @endforeach
                    <div class="row-flex">
                        <div class="col-9 p-2 fw-bold">&nbsp;</div>
                        <div class="col-3 p-2 border-left fw-bold">&nbsp;</div>
                    </div>
                </div>

                {{-- <div class="d-flex border-top">
                    <div class="col-9 p-2">Sub Total</div>
                    <div class="col-3 p-2 border-left">{{ number_format($total, 2) }}</div>
                </div>
                <div class="d-flex border-top">
                    <div class="col-9 p-2">VAT</div>
                    <div class="col-3 p-2 border-left">{{ number_format($vat, 2) }}</div>
                </div> --}}
                <div class="d-flex border-top">
                    <div class="col-9 p-2">Total</div>
                    <div class="col-3 p-2 border-left">{{ number_format($total_price_after_vat, 2) }}</div>
                </div>
            </div>

            <div class="mt-5">
                <h5>{{ Helper::format_currency_to_words($total_price_after_vat) }}</h5>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.invoice')

@section('title', 'Items')

@section('sub-title', 'Report')

@section('content')
<div class="container">
    <a href="{{ url()->previous() }}" class="btn btn-secondary px-3 py-2">
        <i class="fa-solid fa-chevron-left"></i> Back
    </a>

    @if(isset($reportData) && count($reportData) >= 1)
    @foreach ($reportData as $itemId => $itemReport)
    <div class="receipt-main">
        @include('layouts._invoice_header')

        <div class="container">
            <div class="row mb-5">
                <div class="col-6">
                    <strong>Item Name:</strong> {{ ucwords($itemReport['item']->name) }} <br>
                    <strong>Itemcode:</strong> {{ $itemReport['item']->itemcode }} <br>
                    <strong>Description:</strong> {{ $itemReport['item']->description }} <br>
                </div>
                <div class="col-6 text-right">
                    <strong>Revenue Account: </strong>{{
                    ucwords($itemReport['item']->revenue_account->account_number) }}
                </div>
            </div>

            <div class="d-flex justify-content-between mb-5">
                <div>
                    <strong>Current Quantity:</strong> {{ $itemReport['item']->quantity }}
                </div>
                <div>
                    <strong>Unit Cost:</strong> {{ number_format($itemReport['item']->unit_cost, 2) }}
                </div>
                <div>
                    <strong>Unit Price:</strong> {{ number_format($itemReport['item']->unit_price, 2) }}
                </div>
            </div>

            <div class="table-responsive overflow-auto">
                <table class="table table-striped mb-5">
                    <thead class="text-center">
                        <tr style="font-size: 0.9rem">
                            <th>Date</th>
                            <th>Type</th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Unit Cost</th>
                            <th>Unit Price</th>
                            <th>Total Cost</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse ($itemReport['combinedData'] as $data)
                        <tr>
                            <td>{{ $data['date'] }}</td>
                            <td>{{ $data['type'] }}</td>
                            <td>{{ $data['name'] }}</td>
                            <td>{{ $data['quantity'] }}</td>
                            <td>{{ $data['unit_cost'] != "" ? number_format($data['unit_cost'], 2) : '-' }}</td>
                            <td>{{ $data['unit_price'] != "" ? number_format($data['unit_price'], 2) : '-' }}</td>
                            <td>{{ $data['total_cost'] != "" ? number_format($data['total_cost'], 2) : '-' }}</td>
                            <td>{{ $data['total_price'] != "" ? number_format($data['total_price'], 2) : '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8">No History Yet...</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="6" class="text-right">Item Total</th>
                            <th>{{ number_format($itemReport['totalItemCost'], 2) }}</th>
                            <th>{{ number_format($itemReport['totalItemPrice'], 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    @endforeach

    <div class="receipt-main mt-5">
        <div class="container">
            <h3 class="text-center mb-4">Overall Summary</h3>
            <div class="row">
                <div class="col-6">
                    <strong>Total Overall Cost:</strong> {{ number_format($totalOverallCost, 2) }}
                </div>
                <div class="col-6 text-right">
                    <strong>Total Overall Price:</strong> {{ number_format($totalOverallPrice, 2) }}
                </div>
            </div>
            @if($fromDate && $toDate)
            <div class="row mt-3">
                <div class="col-12 text-center">
                    <strong>Report Period:</strong> {{ $fromDate->format('Y-m-d') }} to {{ $toDate->format('Y-m-d') }}
                </div>
            </div>
            @endif
        </div>
    </div>

    @else
    <div class="receipt-main">
        @include('layouts._invoice_header')

        <div class="container">
            <div class="row mb-5">
                <div class="col-6">
                    <strong>Item Name:</strong> {{ ucwords($item->name) }} <br>
                    <strong>Itemcode:</strong> {{ $item->itemcode }} <br>
                    <strong>Description:</strong> {{ $item->description }} <br>
                </div>
                <div class="col-6 text-right">
                    <strong>Inventory Account: </strong>{{ ucwords($item->inventory_account->account_number) }}
                    <br>
                    <strong>Cost Of Sales Account: </strong>{{
                    ucwords($item->cost_of_sales_account->account_number)
                    }} <br>
                    <strong>Sales Account: </strong>{{ ucwords($item->sales_account->account_number) }} <br>
                </div>
            </div>

            <div class="d-flex justify-content-between mb-5">
                <div>
                    <strong>Current Quantity:</strong> {{ $item->quantity }}
                </div>
                <div>
                    <strong>Unit Cost:</strong> {{ number_format($item->unit_cost, 2) }}
                </div>
                <div>
                    <strong>Unit Price:</strong> {{ number_format($item->unit_price, 2) }}
                </div>
            </div>

            <div class="table-responsive overflow-auto">
                <table class="table table-striped">
                    <thead class="text-center">
                        <tr style="font-size: 0.9rem">
                            <th>Date</th>
                            <th>Type</th>
                            <th>Name</th>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Unit Cost</th>
                            <th>Unit Price</th>
                            <th>Total Cost</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse ($CombinedData as $data)
                        <tr>
                            <td>{{ $data['date'] }}</td>
                            <td>{{ $data['type'] }}</td>
                            <td>{{ $data['name'] }}</td>
                            <td>{{ $data['item_name'] }}</td>
                            <td>{{ $data['quantity'] }}</td>
                            <td>{{ $data['unit_cost'] != "" ? number_format($data['unit_cost'], 2) : '-' }}</td>
                            <td>{{ $data['unit_price'] != "" ? number_format($data['unit_price'], 2) : '-' }}</td>
                            <td>{{ $data['total_cost'] != "" ? number_format($data['total_cost'], 2) : '-' }}</td>
                            <td>{{ $data['total_price'] != "" ? number_format($data['total_price'], 2) : '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9">No History Yet...</td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-center">Total</th>
                            <th colspan="4"></th>
                            <th>{{ number_format($total_cost, 2) }}</th>
                            <th>{{ number_format($total_price, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
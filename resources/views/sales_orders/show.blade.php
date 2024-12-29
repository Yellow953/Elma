@extends('layouts.invoice')

@section('title', 'sales_orders')

@section('title', 'show')

@section('content')
<div class="container">
    <a href="{{ url()->previous() }}" class="btn btn-secondary px-3 py-2">
        <i class="fa-solid fa-chevron-left"></i> Back </a>

    <div class="receipt-main"
        style="{{
		(!Str::contains(Route::current()->uri, 'print')) ? 'border-bottom: 12px solid #333333; border-top: 12px solid blue;' : 'border: none;'}}">
        @include('layouts._invoice_header')

        <div class="container">
            <div>
                <div class="row mb-5">
                    <div class="col-3">
                        <strong>SO Number:</strong>
                        {{ $sales_order->so_number }} <br>

                        <strong>Date: </strong>
                        {{ ucwords($sales_order->date) }} <br>

                        <strong>Description: </strong>
                        {{ $sales_order->description }} <br>
                    </div>
                    <div class="offset-6 col-3">
                        <strong>Technician: </strong>
                        {{ucwords($sales_order->technician) }}<br>

                        <strong>Job Number: </strong>
                        {{ $sales_order->job_number }} <br>
                    </div>
                </div>

                <h3 class="text-blue my-4">Items</h3>
                <div class="items">
                    <div class="table-responsive overflow-auto">
                        <table class="table table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>Item</th>
                                    <th>Description</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sales_order->so_items as $item)
                                <tr class="text-center">
                                    <td class="col-4">{{$item->item->itemcode}}</td>
                                    <td class="col-4">{{$item->item->description}}</td>
                                    <td class="col-4">{{number_format($item->quantity, 2)}}</td>
                                </tr>
                                @empty
                                <tr class="text-center">
                                    <td colspan="3">No Items Yet ...</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <h3 class="text-blue my-4">Signatures</h3>
                <div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Management</th>
                                <th>Account</th>
                                <th>Stock Keeper</th>
                                <th>Receiver</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><br><br><br></td>
                                <td><br><br><br></td>
                                <td><br><br><br></td>
                                <td><br><br><br></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- print --}}
@if (Str::contains(Route::current()->uri, 'print'))
<script>
    $(document).ready(function () {
			window.print();
		});
</script>
@else
<div class="print">
    <a href="{{ route('sales_orders.print', $sales_order->id) }}" class="btn btn-primary m-3">Print</a>
</div>

{{-- @if (auth()->user()->role == 'admin' && isset($sales_order->client))
<div class="send">
    <a href="{{ route('sales_orders.send', $sales_order->id) }}" class="btn btn-primary m-3">Send</a>
</div>
@endif --}}

@endif

@endsection
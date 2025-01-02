@extends('layouts.app')

@section('title', 'sales_orders')

@php
$statuses = Helper::get_order_statuses();
@endphp

@section('actions')
@can('sales_orders.create')
<a class="btn btn-sm btn-info mx-1" href="{{ route('sales_orders.new') }}">New Sales Order</a>
@endcan
@can('sales_orders.export')
<a class="btn btn-sm btn-info mx-1" href="{{ route('sales_orders.export') }}">Export Sales Orders</a>
@endcan
@endsection

@section('filter')
<button class="btn btn-secondary py-2 px-3 mx-2 text-dark ignore-confirm" type="button" id="filterDropdown"
    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Filter
</button>
<div class="dropdown-menu dropdown-menu-right mt-2 p-4" aria-labelledby="filterDropdown" style="width: 300px">
    <h4 class="mb-2">Filter POs</h4>
    <form action="{{ route('sales_orders') }}" method="get" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-6">
                <div class="input-group input-group-outline my-2">
                    <div class="w-100">
                        <label for="so_number">SO Number</label>
                        <div>
                            <input type="text" class="form-control border" name="so_number" placeholder="SO Number"
                                value="{{request()->query('so_number')}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-outline my-2">
                    <div class="w-100">
                        <label for="shipment_id">Shipment</label>
                        <div>
                            <select name="shipment_id" id="shipment_id" class="form-select select2">
                                <option value=""></option>
                                @foreach ($shipments as $shipment)
                                <option value="{{ $shipment->id }}" {{ $shipment->id ==
                                    request()->query('shipment_id') ?
                                    'selected' : '' }}>{{ $shipment->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="input-group input-group-outline my-2">
                    <div class="w-100">
                        <label for="client_id">Client</label>
                        <div>
                            <select name="client_id" id="client_id" class="form-select select2">
                                <option value=""></option>
                                @foreach ($clients as $client)
                                <option value="{{ $client->id }}" {{ $client->id ==
                                    request()->query('client_id') ?
                                    'selected' : '' }}>{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-outline my-2">
                    <div class="w-100">
                        <label for="status">Status</label>
                        <div>
                            <select name="status" id="status" class="form-select select2">
                                <option value=""></option>
                                @foreach ($statuses as $status)
                                <option value="{{ $status }}" {{ $status==request()->query('status') ?
                                    'selected' : '' }}>{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="input-group input-group-outline my-2">
                    <div class="w-100">
                        <label for="order_date">Order Date</label>
                        <div>
                            <input type="date" class="form-control border" name="order_date"
                                value="{{request()->query('order_date')}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-outline my-2">
                    <div class="w-100">
                        <label for="due_date">Due Date</label>
                        <div>
                            <input type="date" class="form-control border" name="due_date"
                                value="{{request()->query('due_date')}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="input-group input-group-outline my-2">
            <div class="w-100">
                <label for="notes">Notes</label>
                <div>
                    <input type="text" class="form-control border" name="notes" placeholder="Notes"
                        value="{{request()->query('notes')}}">
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-around mt-3">
            <button type="reset"
                class="btn btn-secondary py-2 px-3 mx-2 text-dark ignore-confirm reset-button">reset</button>
            <button type="submit" class="btn btn-info py-2 px-3 mx-2 text-dark">apply</button>
        </div>
    </form>
</div>
@endsection

@section('content')
<div class="container-fluid py-2">
    <div class="d-flex align-items-center justify-content-end">
        @yield('actions')

        @yield('filter')
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3">
                    <div class="bg-gradient-info shadow-info border-radius-lg pt-4 pb-3">
                        <h5 class="text-capitalize ps-3">Sales Orders table</h5>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 text-sm text-dark">
                            <thead>
                                <tr>
                                    <th class="col-2">SO Number</th>
                                    <th class="col-2">Shipment</th>
                                    <th class="col-2">Client</th>
                                    <th class="col-2">Dates</th>
                                    <th class="col-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sales_orders as $sales_order)
                                <tr class="rounded">
                                    <td>
                                        <h6> {{ $sales_order->so_number }} </h6>
                                        <span class="text-dark">{{ $sales_order->status }}</span>
                                    </td>
                                    <td>
                                        {{ $sales_order->shipment->shipment_number }}
                                    </td>
                                    <td>
                                        {{ $sales_order->client->name }}
                                    </td>
                                    <td>
                                        <p>
                                            {{ $sales_order->order_date }}
                                            @if ($sales_order->due_date)
                                            -> {{ $sales_order->due_date }}
                                            @endif
                                        </p>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-row justify-content-center">
                                            @can('sales_orders.create')
                                            <a href="{{ route('sales_orders.AddItems', $sales_order->id) }}"
                                                class="btn btn-info btn-custom" title="Add items">
                                                <i class="fa-solid fa-plus"></i>
                                            </a>
                                            @endcan

                                            @can('sales_orders.read')
                                            <a href="{{ route('sales_orders.show', $sales_order->id) }}"
                                                class="btn btn-info btn-custom" title="Show">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('sales_orders.activity', $sales_order->id) }}"
                                                class="btn btn-secondary btn-custom" title="Activity">
                                                <i class="fa-solid fa-clock-rotate-left"></i>
                                            </a>
                                            @endcan

                                            @can('sales_orders.update')
                                            <a href="{{ route('sales_orders.edit', $sales_order->id) }}"
                                                class="btn btn-warning btn-custom" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            @endcan

                                            @can('invoices.create')
                                            <a href="{{ route('sales_orders.new_invoice', $sales_order->id) }}"
                                                class="btn btn-success btn-custom" title="New Invoice">
                                                <i class="fa-solid fa-receipt"></i>
                                            </a>
                                            @endcan

                                            @can('sales_orders.delete')
                                            <form method="GET"
                                                action="{{ route('sales_orders.destroy', $sales_order->id) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-danger show_confirm btn-custom"
                                                    data-toggle="tooltip" title='Delete'>
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5">
                                        No Sales Orders Found...
                                    </td>
                                </tr>
                                @endforelse
                                <tr>
                                    <td colspan="5">{{ $sales_orders->appends(request()->all())->links() }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
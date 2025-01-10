@extends('layouts.app')

@section('title', 'shipments')

@php
$modes = Helper::get_shipping_modes();
$statuses = Helper::get_shipping_statuses();
$ports = Helper::get_shipping_ports();
@endphp

@section('actions')
@can('shipments.create')
<a class="btn btn-sm btn-info mx-1" href="{{ route('shipments.new') }}">New Shipment</a>
@endcan
@can('shipments.export')
<a class=" btn btn-sm btn-info mx-1" href="{{ route('shipments.export') }}">Export Shipments</a>
@endcan
@endsection

@section('filter')
<button class="btn btn-secondary py-2 px-3 mx-2 text-dark ignore-confirm" type="button" id="filterDropdown"
    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Filter
</button>
<div class="dropdown-menu dropdown-menu-right mt-2 p-4" aria-labelledby="filterDropdown" style="width: 300px">
    <h4 class="mb-2">Filter Shipment</h4>
    <form action="{{ route('shipments') }}" method="get" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-6">
                <div class="input-group input-group-outline my-2">
                    <div class="w-100">
                        <label for="shipment_number">Number</label>
                        <div>
                            <input type="text" class="form-control border" name="shipment_number"
                                placeholder="Shipment Number" value="{{request()->query('shipment_number')}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-outline my-2">
                    <div class="w-100">
                        <label for="mode">Mode</label>
                        <div>
                            <select name="mode" id="mode" class="form-select select2">
                                <option value=""></option>
                                @foreach ($modes as $mode)
                                <option value="{{ $mode }}" {{ $mode==request()->query('mode') ?
                                    'selected' : '' }}>{{ $mode }}</option>
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
                        <label for="departure">Departure</label>
                        <div>
                            <select name="departure" id="departure" class="form-select select2">
                                <option value=""></option>
                                @foreach ($ports as $port)
                                <option value="{{ $port }}" {{ $port==request()->query('departure') ?
                                    'selected' : '' }}>{{ $port }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-outline my-2">
                    <div class="w-100">
                        <label for="arrival">Arrival</label>
                        <div>
                            <select name="arrival" id="arrival" class="form-select select2">
                                <option value=""></option>
                                @foreach ($ports as $port)
                                <option value="{{ $port }}" {{ $port==request()->query('arrival') ?
                                    'selected' : '' }}>{{ $port }}</option>
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
                        <label for="shipping_date">Shipping Date</label>
                        <div>
                            <input type="date" class="form-control border" name="shipping_date"
                                value="{{request()->query('shipping_date')}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-outline my-2">
                    <div class="w-100">
                        <label for="delivery_date">Delivery Date</label>
                        <div>
                            <input type="date" class="form-control border" name="delivery_date"
                                value="{{request()->query('delivery_date')}}">
                        </div>
                    </div>
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
                        <h5 class="text-capitalize ps-3">Shipments Table</h5>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 text-sm text-dark">
                            <thead>
                                <tr>
                                    <th>Shipment Number</th>
                                    <th>Client</th>
                                    <th>Info</th>
                                    <th>Ports</th>
                                    <th>Dates</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($shipments as $shipment)
                                <tr class="rounded">
                                    <td>
                                        <span class="fw-bold">{{ $shipment->shipment_number }}</span> <br>
                                        {{ $shipment->mode }}
                                    </td>
                                    <td>
                                        {{ ucwords($shipment->client->name) }}
                                    </td>
                                    <td>
                                        Status: {{ $shipment->status }} <br>
                                        Commodity: {{ $shipment->commodity }}
                                    </td>
                                    <td>
                                        {{ $shipment->departure }} <br>
                                        {{ $shipment->arrival }}
                                    </td>
                                    <td>
                                        {{ $shipment->shipping_date }} <br>
                                        {{ $shipment->delivery_date ? ' -> ' . $shipment->delivery_date : '' }}
                                    </td>
                                    <td>
                                        <div class="d-flex flex-row justify-content-center">
                                            @can('shipments.read')
                                            <a href="{{ route('shipments.show', $shipment->id) }}"
                                                class="btn btn-info btn-custom" title="Show">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            @endcan

                                            @can('shipments.update')
                                            <a href="{{ route('shipments.edit', $shipment->id) }}"
                                                class="btn btn-warning btn-custom" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            @endcan

                                            @can('shipments.delete')
                                            @if ($shipment->can_delete())
                                            <form method="GET" action="{{ route('shipments.destroy', $shipment->id) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-danger show_confirm btn-custom"
                                                    data-toggle="tooltip" title='Delete'>
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                            @endif
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6">
                                        No Shipments Found ...
                                    </td>
                                </tr>
                                @endforelse
                                <tr>
                                    <td colspan="6">{{ $shipments->appends(request()->all())->links() }}</td>
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
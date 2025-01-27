@extends('layouts.app')

@section('title', 'invoices')

@section('actions')
@can('invoices.create')
<a class="btn btn-sm btn-info mx-1" href="{{ route('invoices.new') }}">New Invoice</a>
@endcan
@can('invoices.export')
<a class=" btn btn-sm btn-info mx-1" href="{{ route('invoices.export') }}">Export Invoices</a>
@endcan
@endsection

@section('filter')
<button class="btn btn-secondary py-2 px-3 mx-2 text-dark ignore-confirm" type="button" id="filterDropdown"
    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Filter
</button>
<div class="dropdown-menu dropdown-menu-right mt-2 p-4" aria-labelledby="filterDropdown" style="width: 300px">
    <h4 class="mb-2">Filter Invoice</h4>
    <form action="{{ route('invoices') }}" method="get" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-6">
                <div class="input-group input-group-outline my-2">
                    <div class="w-100">
                        <label for="invoice_number">Number</label>
                        <div>
                            <input type="text" class="form-control border" name="invoice_number"
                                placeholder="Invoice Number" value="{{request()->query('invoice_number')}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="input-group input-group-outline my-2">
                    <div class="w-100">
                        <label for="date">Date</label>
                        <div>
                            <input type="date" class="form-control border" name="date"
                                value="{{request()->query('date')}}">
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
                        <label for="shipment_id">Shipment</label>
                        <div>
                            <select name="shipment_id" id="shipment_id" class="form-select select2">
                                <option value=""></option>
                                @foreach ($shipments as $shipment)
                                <option value="{{ $shipment->id }}" {{ $shipment->id ==
                                    request()->query('shipment_id') ?
                                    'selected' : '' }}>{{ $shipment->shipment_number }}</option>
                                @endforeach
                            </select>
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
                        <h5 class="text-capitalize ps-3">Invoices Table</h5>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 text-sm text-dark">
                            <thead>
                                <tr>
                                    <th>Invoice Number</th>
                                    <th>Shipment</th>
                                    <th>Client</th>
                                    <th>Profit</th>
                                    <th>Currency</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($invoices as $invoice)
                                <tr class="rounded">
                                    <td>
                                        <p>{{ $invoice->invoice_number }}</p>
                                    </td>
                                    <td>
                                        <p>{{ $invoice->shipment->shipment_number }}</p>
                                    </td>
                                    <td>
                                        <p>{{ ucwords($invoice->client->name) }}</p>
                                    </td>
                                    <td>
                                        {{ number_format($invoice->stats()[2], 2) }}
                                    </td>
                                    <td>
                                        <p>{{ $invoice->currency->code }}</p>
                                    </td>
                                    <td>
                                        {{ $invoice->date }}
                                    </td>
                                    <td>
                                        <div class="d-flex flex-row justify-content-center">
                                            @can('invoices.read')
                                            <a href="{{ route('invoices.show', $invoice->id) }}"
                                                class="btn btn-info btn-custom" title="Show">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            @endcan

                                            @can('invoices.update')
                                            <a href="{{ route('invoices.edit', $invoice->id) }}"
                                                class="btn btn-warning btn-custom" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            @endcan

                                            @can('invoices.delete')
                                            @if ($invoice->can_delete())
                                            <form method="GET" action="{{ route('invoices.destroy', $invoice->id) }}">
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
                                        No Invoices Found ...
                                    </td>
                                </tr>
                                @endforelse
                                <tr>
                                    <td colspan="6">{{ $invoices->appends(request()->all())->links() }}</td>
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
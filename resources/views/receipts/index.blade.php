@extends('layouts.app')

@section('title', 'receipts')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-6 col-md-10 d-flex justify-content-end">
            <button class="btn btn-info py-2 px-3 text-dark ignore-confirm" type="button" id="actionsDropdown"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Actions
            </button>
            <div class="dropdown-menu dropdown-menu-right mt-2" aria-labelledby="actionsDropdown">
                {{-- <a class="dropdown-item text-dark" href="{{ route('receipts.new') }}">New Receipt</a> --}}
                <a class="dropdown-item text-dark" href="{{ route('receipts.return') }}">Return Receipt</a>
                @if (auth()->user()->role == 'admin')
                <a class="dropdown-item text-dark" href="{{ route('export.receipts') }}">Export Receipts</a>
                <a class="dropdown-item text-dark" href="{{ route('export.receipt_items') }}">Export Receipt Items</a>
                <a class="dropdown-item text-dark" href="{{ route('export.landed_costs') }}">Export Landed Costs</a>
                @endif
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="d-flex justify-content-end">
                <button class="btn btn-secondary py-2 px-3 mx-2 text-dark ignore-confirm" type="button"
                    id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Filter
                </button>
                <div class="dropdown-menu dropdown-menu-right mt-2 p-4" aria-labelledby="filterDropdown"
                    style="width: 300px">
                    <h4 class="mb-2">Filter Receipt</h4>
                    <form action="{{ route('receipts') }}" method="get" enctype="multipart/form-data">
                        <div class="input-group input-group-outline my-2">
                            <div class="w-100">
                                <label for="receipt_number">Number</label>
                                <div>
                                    <input type="text" class="form-control border" name="receipt_number"
                                        placeholder="Receipt Number" value="{{request()->query('receipt_number')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-2">
                                    <div class="w-100">
                                        <label for="supplier_id">Supplier</label>
                                        <div>
                                            <select name="supplier_id" id="supplier_id" class="form-select select2">
                                                <option value=""></option>
                                                @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}" {{ $supplier->id ==
                                                    request()->query('supplier_id') ?
                                                    'selected' : '' }}>{{ $supplier->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-2">
                                    <div class="w-100">
                                        <label for="supplier_invoice">Invoice</label>
                                        <div>
                                            <input type="text" class="form-control border" name="supplier_invoice"
                                                placeholder="Supplier Invoice"
                                                value="{{request()->query('supplier_invoice')}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-2">
                                    <div class="w-100">
                                        <label for="tax_id">Tax</label>
                                        <div>
                                            <select name="tax_id" id="tax_id" class="form-select select2">
                                                <option value=""></option>
                                                @foreach ($taxes as $tax)
                                                <option value="{{ $tax->id }}" {{ $tax->id ==
                                                    request()->query('tax_id') ?
                                                    'selected' : '' }}>{{ $tax->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
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

                        <div class="d-flex justify-content-around mt-3">
                            <button type="reset"
                                class="btn btn-secondary py-2 px-3 mx-2 text-dark ignore-confirm reset-button">reset</button>
                            <button type="submit" class="btn btn-info py-2 px-3 mx-2 text-dark">apply</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid py-2">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3">
                    <div class="bg-gradient-info shadow-info border-radius-lg pt-4 pb-3">
                        <h5 class="text-capitalize ps-3">Receipts Table</h5>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 text-sm text-dark">
                            <thead>
                                <tr>
                                    <th>Receipt Number</th>
                                    <th>Supplier</th>
                                    <th>Tax</th>
                                    <th>Currency</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($receipts as $receipt)
                                <tr class="rounded">
                                    <td>
                                        <p>{{ $receipt->receipt_number }}</p>
                                    </td>
                                    <td>
                                        <p>
                                            {{ ucwords($receipt->supplier->name) }} <br>
                                            {{ $receipt->supplier_invoice }}
                                        </p>
                                    </td>
                                    <td>
                                        <p>{{ ucwords($receipt->tax->name) }}</p>
                                    </td>
                                    <td>
                                        <p>{{ $receipt->currency->code }}</p>
                                    </td>
                                    <td>
                                        {{ $receipt->date }}
                                    </td>
                                    <td>
                                        <div class="d-flex flex-row justify-content-center">
                                            <a href="{{ route('receipts.show', $receipt->id) }}"
                                                class="btn btn-info btn-custom" title="Show">
                                                <i class="fa-solid fa-receipt"></i>
                                            </a>
                                            @if ($receipt->can_edit())
                                            <a href="{{ route('receipts.edit', $receipt->id) }}"
                                                class="btn btn-warning btn-custom" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            @endif
                                            @if (auth()->user()->role == 'admin' && $receipt->can_delete())
                                            <form method="GET" action="{{ route('receipts.destroy', $receipt->id) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-danger show_confirm btn-custom"
                                                    data-toggle="tooltip" title='Delete'>
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6">
                                        No Receipts Found ...
                                    </td>
                                </tr>
                                @endforelse
                                <tr>
                                    <td colspan="6">
                                        {{ $receipts->appends(['receipt_number' =>
                                        request()->query('receipt_number'), 'supplier_invoice' =>
                                        request()->query('supplier_invoice'), 'supplier_id' =>
                                        request()->query('supplier_id'),'currency_id' =>
                                        request()->query('currency_id'),
                                        'foreign_currency_id'
                                        => request()->query('foreign_currency_id'), 'date' =>
                                        request()->query('date')])->links() }}
                                    </td>
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
@extends('layouts.app')

@section('title', 'voc')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-6 col-md-10 d-flex justify-content-end">
            <button class="btn btn-info py-2 px-3 text-dark ignore-confirm" type="button" id="actionsDropdown"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Actions
            </button>
            <div class="dropdown-menu dropdown-menu-right mt-2" aria-labelledby="actionsDropdown">
                <a class="dropdown-item text-dark" href="{{ route('voc.new') }}">New VOC</a>
                <a class="dropdown-item text-dark" href="{{ route('voc.return') }}">Return VOC</a>
                @if (auth()->user()->role == 'admin')
                <a class="dropdown-item text-dark" href="{{ route('export.vocs') }}">Export VOCs</a>
                <a class="dropdown-item text-dark" href="{{ route('export.voc_items') }}">Export VOC Items</a>
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
                    <form action="{{ route('voc') }}" method="get" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-2">
                                    <div class="w-100">
                                        <label for="voc_number">Number</label>
                                        <div>
                                            <input type="text" class="form-control border" name="voc_number"
                                                placeholder="Transaction Number"
                                                value="{{request()->query('voc_number')}}">
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
                        <div class="input-group input-group-outline my-2">
                            <div class="w-100">
                                <label for="description">Description</label>
                                <div>
                                    <input type="text" class="form-control border" name="description"
                                        placeholder="Description" value="{{request()->query('description')}}">
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
                        <h5 class="text-capitalize ps-3">VOC Table</h5>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 text-sm text-dark">
                            <thead>
                                <tr>
                                    <th>Transaction Number</th>
                                    <th>Supplier</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($vocs as $voc)
                                <tr class="rounded">
                                    <td>
                                        <p>{{ $voc->voc_number }}</p>
                                    </td>
                                    <td>
                                        <p>{{ ucwords($voc->supplier->name) }}<br>
                                            {{ $voc->supplier_invoice }}
                                        </p>
                                    </td>
                                    <td>
                                        {{ $voc->date }}
                                    </td>
                                    <td>
                                        <div class="d-flex flex-row justify-content-center">
                                            <a href="{{ route('voc.show', $voc->id) }}" class="btn btn-info btn-custom"
                                                title="Show">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            @if ($voc->can_edit())
                                            <a href="{{ route('voc.edit', $voc->id) }}"
                                                class="btn btn-warning btn-custom" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            @endif
                                            @if (auth()->user()->role == 'admin' && $voc->can_delete())
                                            <form method="GET" action="{{ route('voc.destroy', $voc->id) }}">
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
                                        No VOC Found ...
                                    </td>
                                </tr>
                                @endforelse
                                <tr>
                                    <td colspan="6">
                                        {{ $vocs->appends(['voc_number' =>
                                        request()->query('voc_number'), 'supplier_invoice' =>
                                        request()->query('supplier_invoice'), 'supplier_id' =>
                                        request()->query('supplier_id'),'currency_id' =>
                                        request()->query('currency_id'),
                                        'foreign_currency_id'
                                        => request()->query('foreign_currency_id'), 'date' =>
                                        request()->query('date'), 'description' =>
                                        request()->query('description')])->links() }}
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
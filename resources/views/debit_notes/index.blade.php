@extends('layouts.app')

@section('title', 'debit_notes')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-6 col-md-10 d-flex justify-content-end">
            <button class="btn btn-info py-2 px-3 text-dark ignore-confirm" type="button" id="actionsDropdown"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Actions
            </button>
            <div class="dropdown-menu dropdown-menu-right mt-2" aria-labelledby="actionsDropdown">
                <a class="dropdown-item text-dark" href="{{ route('debit_notes.new') }}">New Debit Note</a>
                @if (auth()->user()->role == 'admin')
                <a class=" dropdown-item text-dark" href="{{ route('export.cdnotes') }}">Export Dedit Notes</a>
                <a class=" dropdown-item text-dark" href="{{ route('export.cdnote_items') }}">Export Dedit Note
                    Items</a>
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
                    <h4 class="mb-2">Filter C/D Notes</h4>
                    <form action="{{ route('debit_notes') }}" method="get" enctype="multipart/form-data">
                        <div class="input-group input-group-outline my-2">
                            <div class="w-100">
                                <label for="cdnote_number">Number</label>
                                <div>
                                    <input type="text" class="form-control border" name="cdnote_number"
                                        placeholder="C/D Note Number" value="{{request()->query('cdnote_number')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
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
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="input-group input-group-outline my-2">
                                    <div class="w-100">
                                        <label for="description">Description</label>
                                        <div>
                                            <input type="text" class="form-control border" name="description"
                                                placeholder="Description" value="{{request()->query('description')}}">
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
                        <h5 class="text-capitalize ps-3">Debit Note Table</h5>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 text-sm text-dark">
                            <thead>
                                <tr>
                                    <th>Debit Note Number</th>
                                    <th>Type</th>
                                    <th>Supplier</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($cdnotes as $cdnote)
                                <tr class="rounded">
                                    <td>
                                        <p>{{ $cdnote->cdnote_number }}</p>
                                    </td>
                                    <td>{{ ucwords($cdnote->type) }}</td>
                                    <td>
                                        {{ ucwords($cdnote->supplier->name ?? '') }}
                                    </td>
                                    <td>
                                        {{ $cdnote->date }}
                                    </td>
                                    <td>
                                        <div class="d-flex flex-row justify-content-center">
                                            <a href="{{ route('debit_notes.show', $cdnote->id) }}"
                                                class="btn btn-info btn-custom" title="Show">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            @if ($cdnote->can_edit())
                                            <a href="{{ route('debit_notes.edit', $cdnote->id) }}"
                                                class="btn btn-warning btn-custom" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            @endif
                                            @if (auth()->user()->role == 'admin' && $cdnote->can_delete())
                                            <form method="GET" action="{{ route('debit_notes.destroy', $cdnote->id) }}">
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
                                        No Debit Notes Found ...
                                    </td>
                                </tr>
                                @endforelse
                                <tr>
                                    <td colspan="6">
                                        {{ $cdnotes->appends(['cdnote_number' =>
                                        request()->query('cdnote_number'), 'supplier_id' =>
                                        request()->query('supplier_id'), 'account_id' =>
                                        request()->query('account_id'), 'description' =>
                                        request()->query('description'), 'date' =>
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
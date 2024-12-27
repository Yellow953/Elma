@extends('layouts.app')

@section('title', 'cash_receipts')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-6 col-md-10 d-flex justify-content-end">
            <button class="btn btn-info py-2 px-3 text-dark ignore-confirm" type="button" id="actionsDropdown"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Actions
            </button>
            <div class="dropdown-menu dropdown-menu-right mt-2" aria-labelledby="actionsDropdown">
                <a class="dropdown-item text-dark" href="{{ route('cash_receipts.new') }}">New Cash Receipt</a>
                <a class="dropdown-item text-dark" href="{{ route('cash_receipts.return') }}">Return Cash Receipt</a>
                @if (auth()->user()->role == 'admin')
                <a class=" dropdown-item text-dark" href="{{ route('export.payments') }}">Export Cash Receipts</a>
                <a class=" dropdown-item text-dark" href="{{ route('export.payment_items') }}">Export Cash Receipt
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
                    <h4 class="mb-2">Filter Cash Receipt</h4>
                    <form action="{{ route('cash_receipts') }}" method="get" enctype="multipart/form-data">
                        <div class="input-group input-group-outline my-2">
                            <div class="w-100">
                                <label for="payment_number">Number</label>
                                <div>
                                    <input type="text" class="form-control border" name="payment_number"
                                        placeholder="Payment Number" value="{{request()->query('payment_number')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
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
                        <h5 class="text-capitalize ps-3">Cash Receipts Table</h5>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 text-sm text-dark">
                            <thead>
                                <tr>
                                    <th>Payment Number</th>
                                    <th>Type</th>
                                    <th>Client</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($payments as $payment)
                                <tr class="rounded">
                                    <td>
                                        <p>{{ $payment->payment_number }}</p>
                                    </td>
                                    <td>{{ ucwords($payment->type) }}</td>
                                    <td>
                                        {{ ucwords($payment->client->name ?? '') }}
                                    </td>
                                    <td>
                                        {{ $payment->date }}
                                    </td>
                                    <td>
                                        <div class="d-flex flex-row justify-content-center">
                                            <a href="{{ route('cash_receipts.show', $payment->id) }}"
                                                class="btn btn-info btn-custom" title="Show">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            @if ($payment->can_edit())
                                            <a href="{{ route('cash_receipts.edit', $payment->id) }}"
                                                class="btn btn-warning btn-custom" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            @endif
                                            @if (auth()->user()->role == 'admin' && $payment->can_delete())
                                            <form method="GET"
                                                action="{{ route('cash_receipts.destroy', $payment->id) }}">
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
                                        No Cash Receipts Found ...
                                    </td>
                                </tr>
                                @endforelse
                                <tr>
                                    <td colspan="6">
                                        {{ $payments->appends(['payment_number' =>
                                        request()->query('payment_number'), 'client_id' =>
                                        request()->query('client_id'), 'account_id' =>
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
@extends('layouts.app')

@section('title', 'payment_vouchers')

@section('actions')
@can('payment_vouchers.create')
<a class="btn btn-sm btn-info mx-1" href="{{ route('payment_vouchers.new') }}">New Payment Voucher</a>
@endcan
@endsection

@section('filter')
<button class="btn btn-secondary py-2 px-3 mx-2 text-dark ignore-confirm" type="button" id="filterDropdown"
    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Filter
</button>
<div class="dropdown-menu dropdown-menu-right mt-2 p-4" aria-labelledby="filterDropdown" style="width: 300px">
    <h4 class="mb-2">Filter Payment Voucher</h4>
    <form action="{{ route('payment_vouchers') }}" method="get" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="input-group input-group-outline my-2">
                    <div class="w-100">
                        <label for="number">Number</label>
                        <div>
                            <input type="text" class="form-control border" name="number" placeholder="Number"
                                value="{{request()->query('number')}}">
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
                        <label for="receipt_id">Receipt</label>
                        <div>
                            <select name="receipt_id" id="receipt_id" class="form-select select2">
                                <option value=""></option>
                                @foreach ($receipts as $receipt)
                                <option value="{{ $receipt->id }}" {{ $receipt->id ==
                                    request()->query('receipt_id') ?
                                    'selected' : '' }}>{{ $receipt->name }}</option>
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
                        <h5 class="text-capitalize ps-3">Payment Vouchers Table</h5>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 text-sm text-dark">
                            <thead>
                                <tr>
                                    <th>Number</th>
                                    <th>Date</th>
                                    <th>Supplier</th>
                                    <th>Receipt</th>
                                    <th>Amount</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($payment_vouchers as $payment_voucher)
                                <tr class="rounded">
                                    <td>
                                        {{ $payment_voucher->number }}
                                    </td>
                                    <td>
                                        {{ $payment_voucher->date }}
                                    </td>
                                    <td>
                                        {{ ucwords($payment_voucher->supplier->name) }}
                                    </td>
                                    <td>
                                        {{ ucwords($payment_voucher->receipt->receipt_number ?? 'No Receipt') }}
                                    </td>
                                    <td>
                                        {{ ucwords($payment_voucher->total) }}{{ $payment_voucher->currency->symbol }}
                                    </td>
                                    <td>
                                        <div class="d-flex flex-row justify-content-center">
                                            @can('payment_vouchers.read')
                                            <a href="{{ route('payment_vouchers.show', $payment_voucher->id) }}"
                                                class="btn btn-info btn-custom" title="Show">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            @endcan

                                            @can('payment_vouchers.update')
                                            <a href="{{ route('payment_vouchers.edit', $payment_voucher->id) }}"
                                                class="btn btn-warning btn-custom" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            @endcan

                                            @can('payment_vouchers.delete')
                                            @if ($payment_voucher->can_delete())
                                            <form method="GET"
                                                action="{{ route('payment_vouchers.destroy', $payment_voucher->id) }}">
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
                                        No Payment Vouchers Found ...
                                    </td>
                                </tr>
                                @endforelse
                                <tr>
                                    <td colspan="6">{{ $payment_vouchers->appends(request()->all())->links() }}</td>
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
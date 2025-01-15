@extends('layouts.app')

@section('title', 'payments')

@section('actions')
@can('payments.create')
<a class="btn btn-sm btn-info mx-1" href="{{ route('payments.new') }}">New Payment</a>
@endcan
@can('payments.export')
<a class="btn btn-sm btn-info mx-1" href="{{ route('payments.export') }}">Export Payments</a>
@endcan
@endsection

@section('filter')
<button class="btn btn-secondary py-2 px-3 mx-2 text-dark ignore-confirm" type="button" id="filterDropdown"
    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Filter
</button>
<div class="dropdown-menu dropdown-menu-right mt-2 p-4" aria-labelledby="filterDropdown" style="width: 300px">
    <h4 class="mb-2">Filter Payments</h4>
    <form action="{{ route('payments') }}" method="get" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-6">
                <div class="input-group input-group-outline my-2">
                    <div class="w-100">
                        <label for="payment_number">Number</label>
                        <div>
                            <input type="text" class="form-control border" name="payment_number"
                                placeholder="Payment Number" value="{{request()->query('payment_number')}}">
                        </div>
                    </div>
                </div>
            </div>
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
        </div>
        <div class="row">
            <div class="col-6">
                <div class="input-group input-group-outline my-2">
                    <div class="w-100">
                        <label for="description">Description</label>
                        <div>
                            <input type="text" class="form-control border" name="description" placeholder="Description"
                                value="{{request()->query('description')}}">
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
                        <h5 class="text-capitalize ps-3">Payment Table</h5>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 text-sm text-dark">
                            <thead>
                                <tr>
                                    <th>Payment Number</th>
                                    <th>Client</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($payments as $payment)
                                <tr class="rounded">
                                    <td>
                                        <p>{{ $payment->payment_number }}</p>
                                    </td>
                                    <td>
                                        {{ ucwords($payment->client->name ?? '') }}
                                    </td>
                                    <td>
                                        {{ $payment->date }}
                                    </td>
                                    <td>
                                        {{ $payment->currency->symbol }}{{ number_format($payment->amount, 2) }}
                                    </td>
                                    <td>
                                        <div class="d-flex flex-row justify-content-center">
                                            @can('payments.read')
                                            <a href="{{ route('payments.show', $payment->id) }}"
                                                class="btn btn-info btn-custom" title="Show">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            @endcan

                                            @can('payments.update')
                                            <a href="{{ route('payments.edit', $payment->id) }}"
                                                class="btn btn-warning btn-custom" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            @endcan

                                            @can('payments.delete')
                                            @if ($payment->can_delete())
                                            <form method="GET" action="{{ route('payments.destroy', $payment->id) }}">
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
                                        No Payments Found ...
                                    </td>
                                </tr>
                                @endforelse
                                <tr>
                                    <td colspan="6">{{ $payments->appends(request()->all())->links() }}</td>
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

@extends('layouts.app')

@section('title', 'invoices')

@section('sub-title', 'edit')

@section('content')
<div class="inner-container w-100 m-0 p-5">
    <div class="card">
        <div class="card-header bg-info border-b">
            <h4 class="font-weight-bolder">Edit Invoice</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('invoices.update', $invoice->id) }}" enctype="multipart/form-data">
                @csrf

                <div class="input-group input-group-outline row my-3">
                    <label for="date" class="col-md-5 col-form-label text-md-end">{{
                        __('Date *') }}</label>

                    <div class="col-md-6">
                        <input id="date" type="date" class="form-control date-input @error('date') is-invalid @enderror"
                            name="date" required autocomplete="date" value="{{ $invoice->date ?? date('Y-m-d') }}">

                        @error('date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <h5 class="mt-5 text-center">Invoice Items</h5>
                <div class="w-100 my-4 overflow-x-auto">
                    <table class="table table-bordered" id="invoiceItemsTable">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-sm">Item</th>
                                <th class="text-sm">Quantity</th>
                                <th class="text-sm">Unit Price</th>
                                <th class="text-sm">Total Price</th>
                            </tr>

                            @foreach ($invoice_items as $item)
                            <tr>
                                <td>
                                    {{-- <a href="{{ route('invoices.items.destroy', $item->id) }}"
                                        class="btn btn-danger btn-sm my-auto show_confirm">
                                        <i class="fa fa-trash"></i>
                                    </a> --}}
                                </td>
                                <td>{{ $item->description }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->unit_price, 2) }}</td>
                                <td>{{ number_format($item->total_price, 2) }}</td>
                            </tr>
                            @endforeach
                        </thead>
                    </table>
                </div>

                <div class="d-flex align-items-center justify-content-around mt-3">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-info">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
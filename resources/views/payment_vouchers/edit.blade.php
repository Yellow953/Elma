@extends('layouts.app')

@section('title', 'payment_vouchers')

@section('sub-title', 'edit')

@section('content')
<div class="inner-container w-100 m-0 p-5">
    <div class="card">
        <div class="card-header bg-info border-b">
            <h4 class="font-weight-bolder">Edit Payment Voucher</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('payment_vouchers.update', $payment_voucher->id) }}"
                enctype="multipart/form-data">
                @csrf

                <div class="input-group input-group-outline row my-3">
                    <label for="date" class="col-md-5 col-form-label text-md-end">{{
                        __('Date *') }}</label>

                    <div class="col-md-6">
                        <input id="date" type="date" class="form-control date-input @error('date') is-invalid @enderror"
                            name="date" required autocomplete="date" value="{{ $payment_voucher->date }}">

                        @error('date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <h5 class="mt-5 text-center">Items</h5>
                <div class="w-100 my-4 overflow-x-auto">
                    <table class="table table-bordered" id="paymentVoucherItemsTable">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-sm">Description</th>
                                <th class="text-sm">Amount</th>
                            </tr>

                            @foreach ($payment_voucher->items as $item)
                            <tr>
                                <td>
                                    <a href="{{ route('payment_vouchers.items.destroy', $item->id) }}"
                                        class="btn btn-danger btn-sm my-auto show_confirm">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                                <td>{{ $item->description }}</td>
                                <td>{{ number_format($item->amount, 2) }}</td>
                            </tr>
                            @endforeach
                        </thead>
                        <tbody class="dynamic">
                            <tr class="payment-voucher-item-row">
                                <td>
                                    <button type="button" class="btn btn-info py-2 px-3 ignore-confirm"
                                        onclick="addPaymentVoucherItemRow()"><i class="fa fa-plus"></i></button>
                                </td>
                                <td>
                                    <input type="text" name="description[]" class="form-control border">
                                </td>
                                <td>
                                    <input type="number" name="amount[]" class="form-control border" min="0" value="0"
                                        step="any">
                                </td>
                            </tr>
                        </tbody>
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

<script>
    function addPaymentVoucherItemRow() {
        var table = document.getElementById("paymentVoucherItemsTable").getElementsByTagName('tbody')[0];
        var newRow = table.insertRow(table.rows.length);
        var originalRow = document.querySelector('.payment-voucher-item-row');

        newRow.innerHTML = originalRow.innerHTML;

        newRow.firstElementChild.innerHTML = '<button type="button" class="btn btn-danger py-2 px-3" onclick="removeRow(this)"><i class="fa fa-minus"></i></button>';

        $(newRow).find('.select2').select2();
    }

    function removeRow(button) {
        var row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }
</script>
@endsection
@extends('layouts.app')

@section('title', 'payment_vouchers')

@section('sub-title', 'new')

@section('content')
<div class="inner-container w-100 m-0">
    <div class="inner-container w-100 m-0 px-4 px-md-5 pt-3">
        <div class="card">
            <div class="card-header bg-info border-b">
                <h4 class="font-weight-bolder">New Payment Voucher</h4>
            </div>
            <div class="card-body">
                <div class="container px-0 px-md-5">
                    <form role="form" action="{{ route('payment_vouchers.create') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group input-group-outline row mb-3">
                                    <label for="number" class="col-md-2 col-form-label text-md-end">{{
                                        __('Number *') }}</label>

                                    <div class="col-md-10">
                                        <input id="number" type="text"
                                            class="form-control @error('number') is-invalid @enderror" name="number"
                                            required autocomplete="number" placeholder="Enter Number"
                                            value="{{ old('number') }}">

                                        @error('number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-group input-group-outline row mb-3">
                                    <label for="supplier_id" class="col-md-4 col-form-label text-md-end">{{ __('Supplier
                                        *') }}</label>

                                    <div class="col-md-8">
                                        <select name="supplier_id" id="supplier_id" required
                                            class="form-select select2">
                                            <option value=""></option>
                                            @foreach ($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" {{ $supplier->id == old('supplier_id') ?
                                                'selected':'' }}>{{
                                                $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-group input-group-outline row mb-3">
                                    <label for="receipt_id" class="col-md-4 col-form-label text-md-end">{{ __('Receipt')
                                        }}</label>

                                    <div class="col-md-8">
                                        <select name="receipt_id" id="receipt_id" class="form-select select2">
                                            <option value=""></option>
                                            @foreach ($receipts as $receipt)
                                            <option value="{{ $receipt->id }}" {{ $receipt->id == old('receipt_id') ?
                                                'selected':'' }}>{{
                                                $receipt->receipt_number }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-group input-group-outline row mb-3">
                                    <label for="currency_id" class="col-md-4 col-form-label text-md-end">{{ __('Currency
                                        *') }}</label>

                                    <div class="col-md-8">
                                        <select name="currency_id" id="currency_id" required
                                            class="form-select select2">
                                            <option value=""></option>
                                            @foreach ($currencies as $currency)
                                            <option value="{{ $currency->id }}" {{ $currency->id == old('currency_id') ?
                                                'selected':'' }} data-rate="{{ $currency->rate }}">{{ $currency->code }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-group input-group-outline row mb-3">
                                    <label for="date" class="col-md-4 col-form-label text-md-end">{{
                                        __('Date *') }}</label>

                                    <div class="col-md-8">
                                        <input id="date" type="date"
                                            class="form-control date-input @error('date') is-invalid @enderror"
                                            name="date" required autocomplete="date"
                                            value="{{ old('date') ?? date('Y-m-d') }}">

                                        @error('date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="w-100 my-4 overflow-x-auto">
                                <table class="table table-bordered" id="paymentVoucherItemsTable">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th class="text-sm">Description</th>
                                            <th class="text-sm">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody class="dynamic">
                                        <tr class="payment-voucher-item-row">
                                            <td>
                                                <button type="button" class="btn btn-info py-2 px-3 ignore-confirm"
                                                    onclick="addPaymentVoucherItemRow()"><i
                                                        class="fa fa-plus"></i></button>
                                            </td>
                                            <td>
                                                <input type="text" name="description[]" class="form-control border"
                                                    required>
                                            </td>
                                            <td>
                                                <input type="number" name="amount[]" class="form-control border"
                                                    required min="0" value="0" step="any">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="text-center">
                                    <div class="row">
                                        <div class="col-6">Total</div>
                                        <div class="col-6"><span id="payment_voucher_items_total">0</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-4">
                            <button class="btn btn-success btn-lg pull-right" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
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

        newRow.querySelectorAll('input').forEach(function(input) {
            input.addEventListener('input', function() {
                updatePaymentVoucherItemsTotal();
                updateAmountForRow(newRow);
            });
        });

        $(newRow).find('.select2').select2();
    }

    function removeRow(button) {
        var row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
        updatePaymentVoucherItemsTotal();
    }

    function updateAmountForRow(row) {
        var amount = parseFloat(row.querySelector('input[name^="amount"]').value) || 0;
    }

    function updatePaymentVoucherItemsTotal() {
        var total = 0;

        document.querySelectorAll('#paymentVoucherItemsTable tbody tr').forEach(function(row) {
            var amount = parseFloat(row.querySelector('input[name^="amount"]').value) || 0;

            total += amount;
        });

        document.getElementById('payment_voucher_items_total').innerText = total.toFixed(2);
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('#paymentVoucherItemsTable tbody tr').forEach(function(row) {
            row.querySelectorAll('input').forEach(function(input) {
                input.addEventListener('input', function() {
                    updatePaymentVoucherItemsTotal();
                    updateAmountForRow(row);
                });
            });
        });
    });

    // Fill Currency Field
    document.getElementById('currency_id').value = {{ auth()->user()->currency_id }};
    document.getElementById('currency_id').dispatchEvent(new Event('input'));
</script>
@endsection
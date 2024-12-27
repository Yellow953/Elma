@extends('layouts.app')

@section('title', 'payments')

@section('sub-title', 'edit')

@section('content')

@php
$currencies = Helper::get_currencies();
@endphp

<div class="inner-container w-100 m-0 p-5">
    <div class="d-flex justify-content-around">
        <a href="{{ route('accounts.new') }}" class="btn btn-info px-3 py-2 mx-1">
            <i class="fa-solid fa-plus"></i> Account</a>
        <a href="{{ route('suppliers.new') }}" class="btn btn-info px-3 py-2 mx-1">
            <i class="fa-solid fa-plus"></i> Supplier</a>
    </div>

    <div class="card">
        <div class="card-header bg-info border-b">
            <h4 class="font-weight-bolder">Edit Payment</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('payments.update', $payment->id) }}" enctype="multipart/form-data">
                @csrf

                <div class="input-group input-group-outline row my-3">
                    <label for="currency_id" class="col-md-5 col-form-label text-md-end">{{ __('Currency
                        *') }}</label>

                    <div class="col-md-6">
                        <select name="currency_id" id="currency_id" required class="form-select select2">
                            <option value=""></option>
                            @foreach ($currencies as $currency)
                            <option value="{{ $currency->id }}" {{ $currency->id == $payment->currency_id ?
                                'selected':'' }}>{{ $currency->code }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="foreign_currency_id" class="col-md-5 col-form-label text-md-end">{{ __('Foreign
                        Currency
                        *') }}</label>

                    <div class="col-md-6">
                        <select name="foreign_currency_id" id="foreign_currency_id" required class="form-select select2"
                            onchange="updateRateField()">
                            <option value=""></option>
                            @foreach ($currencies as $currency)
                            <option value="{{ $currency->id }}" {{ $currency->id == $payment->foreign_currency_id ?
                                'selected':'' }}>{{ $currency->code }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="rate" class="col-md-5 col-form-label text-md-end">{{
                        __('Rate *') }}</label>

                    <div class="col-md-6">
                        <input id="rate" type="number" class=" form-control @error('rate') is-invalid @enderror"
                            step="any" min="0" required name="rate" required autocomplete="rate"
                            value="{{ $payment->rate }}">

                        @error('rate')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="description" class="col-md-5 col-form-label text-md-end">{{
                        __('Description *') }}</label>

                    <div class="col-md-6">
                        <input id="description" type="text"
                            class=" form-control @error('description') is-invalid @enderror" name="description" required
                            autocomplete="description" value="{{ $payment->description }}">

                        @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="date" class="col-md-5 col-form-label text-md-end">{{
                        __('Date *') }}</label>

                    <div class="col-md-6">
                        <input id="date" type="text" class=" form-control @error('date') is-invalid @enderror"
                            name="date" required autocomplete="date" value="{{ $payment->date }}">

                        @error('date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <h5 class="mt-5 text-center">Payment Items</h5>
                <div class="w-100 my-4 overflow-x-auto">
                    <table class="table table-bordered" id="paymentItemsTable">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-sm">Account</th>
                                <th class="text-sm">Amount</th>
                            </tr>

                            @foreach ($payment->payment_items as $item)
                            <tr>
                                <td></td>
                                <td>{{ $item->account->account_number }}</td>
                                <td>{{ number_format($item->amount, 2) }}</td>
                            </tr>
                            @endforeach
                        </thead>
                        <tbody class="dynamic">
                            <tr class="payment-item-row">
                                <td>
                                    <button type="button" class="btn btn-info py-2 px-3 ignore-confirm"
                                        onclick="addPaymentItemRow()"><i class="fa fa-plus"></i></button>
                                </td>
                                <td>
                                    <select name="account_id[]" class="form-control select2">
                                        <option value=""></option>
                                        @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}">{{
                                            $account->account_number }} | {{
                                            $account->account_description }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="amount[]" class="form-control border" min="0" value="0"
                                        step="any">
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="2">Total</th>
                                <th><span id="grand_total">{{ number_format($total, 2) }}</span></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="row mt-4">
                    <div class="offset-md-8 col-md-4">
                        <button type="submit" class="btn btn-info w-100" id="submitBtn">
                            {{ __('Update') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let payment_total = parseFloat({{ $total }});

    function addPaymentItemRow() {
        var table = document.getElementById("paymentItemsTable").getElementsByTagName('tbody')[0];
        var newRow = table.insertRow(table.rows.length);
        var originalRow = document.querySelector('.payment-item-row');

        newRow.innerHTML = originalRow.innerHTML;
        
        newRow.firstElementChild.innerHTML = '<button type="button" class="btn btn-danger py-2 px-3" onclick="removeRow(this)"><i class="fa fa-minus"></i></button>';
        newRow.cells[1].innerHTML = "<select name='account_id[]' required class='form-select select2'><option value=''></option>@foreach ($accounts as $account)<option value='{{ $account->id }}'>{{$account->account_number}} | {{ $account->account_description }}</option>@endforeach</select>";

        newRow.querySelectorAll('input, select').forEach(function (element) {
            element.addEventListener('input', function () {
                updatePaymentItemsTotal();
                updateGrandTotal();
            });
        });

        $(newRow).find('.select2').select2();
    }

    function updatePaymentItemsTotal() {
        var totalAmount = payment_total;

        document.querySelectorAll('#paymentItemsTable tbody tr').forEach(function (row) {
            var amount = parseFloat(row.querySelector('input[name^="amount"]').value) || 0;

            totalAmount += amount;
        });

        document.getElementById('grand_total').innerText = totalAmount.toFixed(2);
    }

    function updateGrandTotal() {
        var paymentItemsTotal = parseFloat(document.getElementById('grand_total').innerText) || 0;
        document.getElementById('grand_total').innerText = paymentItemsTotal.toFixed(2);
    }

    function removeRow(button) {
        var row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
        updatePaymentItemsTotal();
        updateGrandTotal();
    }

    function updateRateField() {
        var rate = document.querySelector('select[name^="foreign_currency_id"] option:checked').getAttribute('data-rate');
            
        const rateInput = document.querySelector('#rate');
        rateInput.value = rate;
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('#paymentItemsTable tbody tr:first-child input, #paymentItemsTable tbody tr:first-child select').forEach(function (element) {
            element.addEventListener('input', function () {
                updatePaymentItemsTotal();
                updateGrandTotal();
            });
        });
    });
</script>
@endsection
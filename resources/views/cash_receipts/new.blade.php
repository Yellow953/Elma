@extends('layouts.app')

@section('title', 'cash_receipts')

@section('sub-title', 'new')

@section('content')

@php
$currencies = Helper::get_currencies();
@endphp

<link rel="stylesheet" href="{{ asset('assets/css/stepper.css') }}">

<div class="inner-container w-100 m-0">
    <div class="d-flex justify-content-around">
        <a href="{{ route('accounts.new') }}" class="btn btn-info px-3 py-2 mx-1">
            <i class="fa-solid fa-plus"></i> Account</a>
        <a href="{{ route('clients.new') }}" class="btn btn-info px-3 py-2 mx-1">
            <i class="fa-solid fa-plus"></i> Client</a>
    </div>

    <div class="inner-container w-100 m-0 px-4 px-md-5 pt-3">
        <div class="card">
            <div class="card-header bg-info border-b">
                <h4 class="font-weight-bolder">New Cash Receipt</h4>
            </div>
            <div class="card-body">
                <div class="container px-0 px-md-5">
                    <div class="stepwizard col-12 my-4">
                        <div class="stepwizard-row setup-panel">
                            <div class="stepwizard-step">
                                <a href="#step-1" type="button"
                                    class="btn btn-circle btn-info ignore-confirm disabled">1</a>
                                <p>Cash Receipt</p>
                            </div>
                            <div class="stepwizard-step">
                                <a href="#step-2" type="button"
                                    class="btn btn-circle btn-default ignore-confirm disabled">2</a>
                                <p>Items</p>
                            </div>
                            <div class="stepwizard-step">
                                <a href="#step-3" type="button"
                                    class="btn btn-circle btn-default ignore-confirm disabled">3</a>
                                <p>Confirm</p>
                            </div>
                        </div>
                    </div>

                    <form role="form" action="{{ route('cash_receipts.create') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="row setup-content" id="step-1">
                            <div class="col-md-6">
                                <div class="input-group input-group-outline row mb-3">
                                    <label for="client_id" class="col-md-4 col-form-label text-md-end">{{ __('Client
                                        *') }}</label>

                                    <div class="col-md-8">
                                        <select name="client_id" id="client_id" required class="form-select select2">
                                            <option value=""></option>
                                            @foreach ($clients as $client)
                                            <option value="{{ $client->id }}" {{ $client->id == old('client_id') ?
                                                'selected':'' }}>{{ $client->name }}</option>
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
                                    <label for="description" class="col-md-4 col-form-label text-md-end">{{
                                        __('Description *') }}</label>

                                    <div class="col-md-8">
                                        <input id="description" type="text"
                                            class=" form-control @error('description') is-invalid @enderror"
                                            name="description" required autocomplete="description"
                                            value="{{ old('description') }}">

                                        @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button class="btn btn-info nextBtn ignore-confirm" type="button">Next</button>
                            </div>
                        </div>
                        <div class="row setup-content" id="step-2">
                            <div class="w-100 my-4 overflow-x-auto">
                                <table class="table table-bordered" id="paymentItemsTable">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th class="text-sm">Account</th>
                                            <th class="text-sm">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody class="dynamic">
                                        <tr class="payment-item-row">
                                            <td>
                                                <button type="button" class="btn btn-info py-2 px-3 ignore-confirm"
                                                    onclick="addPaymentItemRow()"><i class="fa fa-plus"></i></button>
                                            </td>
                                            <td>
                                                <select name="account_id[]" required class="form-control select2">
                                                    <option value=""></option>
                                                    @foreach ($accounts as $account)
                                                    <option value="{{ $account->id }}">{{
                                                        $account->account_number }} | {{ $account->account_description
                                                        }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" name="amount[]" class="form-control border"
                                                    required min="0" value="0" step="any">
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2">Total</th>
                                            <th><span id="grand_total">0</span></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button class="btn btn-secondary prevBtn ignore-confirm" type="button">Previous</button>
                                <button class="btn btn-info nextBtn ignore-confirm" type="button">Next</button>
                            </div>
                        </div>
                        <div class="row setup-content" id="step-3">
                            <h3>Confirm</h3>

                            <div class="col-md-12">
                                <p class="text-center">Are you sure you want to create this Cash Receipt?</p>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button class="btn btn-secondary prevBtn ignore-confirm" type="button">Previous</button>
                                <button class="btn btn-success btn-lg pull-right" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/stepper.js') }}"></script>
<script>
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
        var totalAmount = 0;

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

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('#paymentItemsTable tbody tr:first-child input, #paymentItemsTable tbody tr:first-child select').forEach(function (element) {
            element.addEventListener('input', function () {
                updatePaymentItemsTotal();
                updateGrandTotal();
            });
        });
    });

    // Fill Currency Field
    document.getElementById('currency_id').value = {{ auth()->user()->currency_id }};
    document.getElementById('currency_id').dispatchEvent(new Event('input'));
</script>

@endsection
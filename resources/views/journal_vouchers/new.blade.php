@extends('layouts.app')

@section('title', 'journal_vouchers')

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
    </div>

    <div class="inner-container w-100 m-0 px-4 px-md-5 pt-3">
        <div class="card">
            <div class="card-header bg-info border-b">
                <h4 class="font-weight-bolder">New Journal Voucher</h4>
            </div>
            <div class="card-body">
                <div class="container px-0 px-md-5">
                    <div class="stepwizard col-12 my-4">
                        <div class="stepwizard-row setup-panel">
                            <div class="stepwizard-step">
                                <a href="#step-1" type="button"
                                    class="btn btn-circle btn-info ignore-confirm disabled">1</a>
                                <p>Journal Voucher</p>
                            </div>
                            <div class="stepwizard-step">
                                <a href="#step-2" type="button"
                                    class="btn btn-circle btn-default ignore-confirm disabled">2</a>
                                <p>Transactions</p>
                            </div>
                            <div class="stepwizard-step">
                                <a href="#step-3" type="button"
                                    class="btn btn-circle btn-default ignore-confirm disabled">3</a>
                                <p>Confirm</p>
                            </div>
                        </div>
                    </div>

                    <form role="form" action="{{ route('journal_vouchers.create') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="row setup-content" id="step-1">
                            <div class="col-md-6">
                                <div class="input-group input-group-outline row mb-3">
                                    <label for="batch" class="col-md-4 col-form-label text-md-end">{{__('Batch *')
                                        }}</label>

                                    <div class="col-md-8">
                                        <input id="batch" type="text"
                                            class=" form-control @error('batch') is-invalid @enderror" name="batch"
                                            required autocomplete="batch" value="{{ old('batch') ?? 'A' }}">

                                        @error('batch')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
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
                                    <label for="foreign_currency_id" class="col-md-4 col-form-label text-md-end">{{
                                        __('Foreign
                                        Currency
                                        *') }}</label>

                                    <div class="col-md-8">
                                        <select name="foreign_currency_id" id="foreign_currency_id" required
                                            class="form-select select2" onchange="updateRateField()">
                                            <option value=""></option>
                                            @foreach ($currencies as $currency)
                                            <option value="{{ $currency->id }}" {{ $currency->id ==
                                                old('foreign_currency_id') ?
                                                'selected':'' }} data-rate="{{ $currency->rate }}">{{ $currency->code }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-group input-group-outline row mb-3">
                                    <label for="rate" class="col-md-4 col-form-label text-md-end">{{
                                        __('Rate *') }}</label>

                                    <div class="col-md-8">
                                        <input id="rate" type="number"
                                            class=" form-control @error('rate') is-invalid @enderror" name="rate"
                                            required autocomplete="rate" value="{{ old('rate') }}" step="any" min="0"
                                            required>

                                        @error('rate')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
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
                                <table class="table table-bordered" id="transactionsTable">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th class="text-sm">Account</th>
                                            <th class="text-sm">Debit</th>
                                            <th class="text-sm">Credit</th>
                                            <th class="text-sm">Balance</th>
                                            <th class="text-sm">Foreign</th>
                                        </tr>
                                    </thead>
                                    <tbody class="dynamic">
                                        <tr class="transaction-row">
                                            <td>
                                                <button type="button" class="btn btn-info py-2 px-3 ignore-confirm"
                                                    onclick="addTransactionRow()"><i class="fa fa-plus"></i></button>
                                            </td>
                                            <td>
                                                <select name="transactions[account_id][]" required
                                                    class="form-select select2">
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
                                                <input type="number" name="transactions[debit][]"
                                                    class="form-control border debit" min="0" step="any">
                                            </td>
                                            <td>
                                                <input type="number" name="transactions[credit][]"
                                                    class="form-control border credit" min="0" step="any">
                                            </td>
                                            <td>
                                                <input type="number" name="transactions[balance][]"
                                                    class="form-control border balance" required step="any" disabled>
                                            </td>
                                            <td>
                                                <input type="number" name="transactions[foreign][]"
                                                    class="form-control border foreign" required step="any" disabled>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2">Total</th>
                                            <th colspan="3"></th>
                                            <th><span id="transactions_total">0</span></th>
                                        </tr>
                                        <tr>
                                            <th colspan="2">Foreign</th>
                                            <th colspan="3"></th>
                                            <th><span id="transactions_foreign">0</span></th>
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
                                <p class="text-center">Are you sure you want to create this Journal Voucher?</p>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button class="btn btn-secondary prevBtn ignore-confirm" type="button">Previous</button>
                                <button class="btn btn-success btn-lg pull-right" id="submit" disabled
                                    type="submit">Submit</button>
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
    function addTransactionRow() {
        var table = document.getElementById("transactionsTable").getElementsByTagName('tbody')[0];
        var newRow = table.insertRow(table.rows.length);
        var originalRow = document.querySelector('.transaction-row');

        newRow.innerHTML = originalRow.innerHTML;

        newRow.firstElementChild.innerHTML = '<button type="button" class="btn btn-danger py-2 px-3" onclick="removeRow(this)"><i class="fa fa-minus"></i></button>';
        newRow.cells[1].innerHTML = "<select name='transactions[account_id][]' required class='form-select select2'><option value=''></option>@foreach ($accounts as $account)<option value='{{ $account->id }}'>{{$account->account_number}} | {{ $account->account_description }}</option>@endforeach</select>";

        newRow.querySelectorAll('input, select').forEach(function (element) {
            element.addEventListener('input', function () {
                updateTransactionsTotal();
                updateGrandTotal();
            });
        });

        $(newRow).find('.select2').select2();

        // Add event listeners for debit and credit fields
        const debitField = newRow.querySelector('.debit');
        const creditField = newRow.querySelector('.credit');

        debitField.addEventListener('input', function () {
            if (debitField.value) {
                creditField.value = '';
            }
            updateTransactionsTotal();
            updateGrandTotal();
        });

        creditField.addEventListener('input', function () {
            if (creditField.value) {
                debitField.value = '';
            }
            updateTransactionsTotal();
            updateGrandTotal();
        });
    }

    function updateTransactionsTotal() {
        var totalBalance = 0;
        var foreignBalance = 0;
        var rate = parseFloat(document.querySelector('#rate').value) || 1;
        const submitBtn = document.getElementById('submit');

        document.querySelectorAll('#transactionsTable tbody tr').forEach(function (row) {
            var debit = parseFloat(row.querySelector('.debit').value) || 0;
            var credit = parseFloat(row.querySelector('.credit').value) || 0;

            var balance = debit - credit;
            var foreign_balance = balance * rate;

            row.querySelector('.balance').value = balance.toFixed(2);
            row.querySelector('.foreign').value = foreign_balance.toFixed(2);

            totalBalance += balance;
        });
        foreignBalance = totalBalance * rate;

        document.getElementById('transactions_total').innerText = totalBalance.toFixed(2);
        document.getElementById('transactions_foreign').innerText = foreignBalance.toFixed(2);

        submitBtn.disabled = (totalBalance != 0 || foreignBalance != 0);

        const accountIds = Array.from(tableBody.querySelectorAll('.transaction-row select[name^="transactions[account_id]"]')).map(select => select.value.trim());
        if (accountIds.includes('')) {
            submitBtn.disabled = true;
        }
    }

    function updateGrandTotal() {
        var transactionsTotal = parseFloat(document.getElementById('transactions_total').innerText) || 0;
        document.getElementById('transactions_total').innerText = transactionsTotal.toFixed(2);
    }

    function removeRow(button) {
        var row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
        updateTransactionsTotal();
        updateGrandTotal();
    }

    function updateRateField() {
        var rate = document.querySelector('select[name^="foreign_currency_id"] option:checked').getAttribute('data-rate');
            
        const rateInput = document.querySelector('#rate');
        rateInput.value = rate;
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('#transactionsTable tbody tr').forEach(function (row) {
            row.querySelectorAll('input, select').forEach(function (element) {
                element.addEventListener('input', function () {
                    updateTransactionsTotal();
                });
            });

            // Add event listeners for debit and credit fields
            const debitField = row.querySelector('.debit');
            const creditField = row.querySelector('.credit');

            debitField.addEventListener('input', function () {
                if (debitField.value) {
                    creditField.value = '';
                }
                updateTransactionsTotal();
                updateGrandTotal();
            });

            creditField.addEventListener('input', function () {
                if (creditField.value) {
                    debitField.value = '';
                }
                updateTransactionsTotal();
                updateGrandTotal();
            });
        });

        var foreignCurrencySelect = document.getElementById('foreign_currency_id');
        if (foreignCurrencySelect) {
            foreignCurrencySelect.addEventListener('change', function () {
                updateRateField();
            });
        }

        // Fill Currency Field
        document.getElementById('currency_id').value = {{ auth()->user()->currency_id }};
        document.getElementById('currency_id').dispatchEvent(new Event('input'));

        // Fill Foreign Currency Field
        document.getElementById('foreign_currency_id').value = {{ Helper::get_foreign_currency()->id }};
        document.getElementById('foreign_currency_id').dispatchEvent(new Event('input'));

        // Fill Rate Field
        document.getElementById('rate').value = {{ Helper::get_foreign_currency()->rate }};
        document.getElementById('rate').dispatchEvent(new Event('input'));
    });
</script>
@endsection
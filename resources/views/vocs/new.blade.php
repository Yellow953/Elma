@extends('layouts.app')

@section('title', 'voc')

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
        <a href="{{ route('suppliers.new') }}" class="btn btn-info px-3 py-2 mx-1">
            <i class="fa-solid fa-plus"></i> Supplier</a>
    </div>

    <div class="inner-container w-100 m-0 px-4 px-md-5 pt-3">
        <div class="card">
            <div class="card-header bg-info border-b">
                <h4 class="font-weight-bolder">New VOC Transaction</h4>
            </div>
            <div class="card-body">
                <div class="container px-0 px-md-5">
                    <div class="stepwizard col-12 my-4">
                        <div class="stepwizard-row setup-panel">
                            <div class="stepwizard-step">
                                <a href="#step-1" type="button"
                                    class="btn btn-circle btn-info ignore-confirm disabled">1</a>
                                <p>VOC Transaction</p>
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

                    <form role="form" action="{{ route('voc.create') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row setup-content" id="step-1">
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
                                                'selected':'' }} data-tax_id="{{ $supplier->tax_id }}">{{
                                                $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="input-group input-group-outline row mb-3">
                                    <label for="supplier_invoice"
                                        class="col-md-4 col-form-label text-md-end">{{__('Supplier
                                        Invoice *')
                                        }}</label>

                                    <div class="col-md-8">
                                        <input id="supplier_invoice" type="text"
                                            class=" form-control @error('supplier_invoice') is-invalid @enderror"
                                            name="supplier_invoice" required autocomplete="supplier_invoice"
                                            value="{{ old('supplier_invoice') }}">

                                        @error('supplier_invoice')
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
                                    <label for="tax_id" class="col-md-4 col-form-label text-md-end">{{ __('Tax
                                        *') }}</label>

                                    <div class="col-md-8">
                                        <select name="tax_id" id="tax_id" required class="form-select select2">
                                            <option value=""></option>
                                            @foreach (Helper::get_taxes() as $tax)
                                            <option value="{{ $tax->id }}" {{ $tax->id == old('tax_id') ?
                                                'selected':'' }} data-rate="{{ $tax->rate }}">{{ $tax->name }}</option>
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
                                <table class="table table-bordered" id="vocItemsTable">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th class="text-sm">Account</th>
                                            <th class="text-sm">Amount</th>
                                            <th class="text-sm">Tax</th>
                                            <th class="text-sm">Total Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody class="dynamic">
                                        <tr class="voc-item-row">
                                            <td>
                                                <button type="button" class="btn btn-info py-2 px-3 ignore-confirm"
                                                    onclick="addVOCItemRow()"><i class="fa fa-plus"></i></button>
                                            </td>
                                            <td>
                                                <select name="account_id[]" required class="form-select select2">
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
                                            <td>
                                                <input type="number" name="vat[]" class="form-control border" required
                                                    min="0" value="0" step="any" disabled>
                                            </td>
                                            <td>
                                                <input type="number" name="total[]" class="form-control border" required
                                                    min="0" value="0" step="any" disabled>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="2">Total</th>
                                            <th colspan="2"></th>
                                            <th><span id="voc_items_total">0</span></th>
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
                                <p class="text-center">Are you sure you want to create this VOC Transaction?</p>
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
    let tax_rate = 0;
     
    function addVOCItemRow() {
        var table = document.getElementById("vocItemsTable").getElementsByTagName('tbody')[0];
        var newRow = table.insertRow(table.rows.length);
        var originalRow = document.querySelector('.voc-item-row');

        newRow.innerHTML = originalRow.innerHTML;

        newRow.firstElementChild.innerHTML = '<button type="button" class="btn btn-danger py-2 px-3" onclick="removeRow(this)"><i class="fa fa-minus"></i></button>';
        newRow.cells[1].innerHTML = "<select name='account_id[]' required class='form-select select2'><option value=''></option>@foreach ($accounts as $account)<option value='{{ $account->id }}'>{{$account->account_number}} | {{ $account->account_description }}</option>@endforeach</select>";

        newRow.querySelectorAll('input, select').forEach(function (element) {
            element.addEventListener('input', function () {
                updateVOCItemsTotal();
                updateGrandTotal();
            });
        });

        $(newRow).find('.select2').select2();
    }

    function updateVOCItemsTotal() {
        var totalAmount = 0;

        document.querySelectorAll('#vocItemsTable tbody tr').forEach(function (row) {
            var amount = parseFloat(row.querySelector('input[name^="amount"]').value) || 0;
            tax_rate = document.querySelector('select[name^="tax_id"] option:checked').getAttribute('data-rate') / 100;
            
            row.querySelector('input[name^="vat"]').value = amount * tax_rate;
            
            var total = amount + (amount * tax_rate);

            row.querySelector('input[name^="total"]').value = total.toFixed(2);
            
            totalAmount += total;
        });

        document.getElementById('voc_items_total').innerText = totalAmount.toFixed(2);
    }

    function updateGrandTotal() {
        var vocItemsTotal = parseFloat(document.getElementById('voc_items_total').innerText) || 0;
        document.getElementById('voc_items_total').innerText = vocItemsTotal.toFixed(2);
    }

    function removeRow(button) {
        var row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
        updateVOCItemsTotal();
        updateGrandTotal();
    }

    function updateRateField() {
        var rate = document.querySelector('select[name^="foreign_currency_id"] option:checked').getAttribute('data-rate');
            
        const rateInput = document.querySelector('#rate');
        rateInput.value = rate;
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('#vocItemsTable tbody tr').forEach(function (row) {
            row.querySelectorAll('input, select').forEach(function (element) {
                element.addEventListener('input', function () {
                    updateVOCItemsTotal();
                });
            });
        });

        var foreignCurrencySelect = document.getElementById('foreign_currency_id');
        if (foreignCurrencySelect) {
            foreignCurrencySelect.addEventListener('change', function () {
                updateRateField();
            });
        }

        $('#tax_id').on('select2:select', function (event) {
            var rate = document.querySelector('select[name^="tax_id"] option:checked').getAttribute('data-rate');
            tax_rate = rate / 100;

            updateVOCItemsTotal();
            updateGrandTotal();
        });

        const supplier_select = document.getElementById('supplier_id');
        $('#supplier_id').on('select2:select', function (event) {
            const supplier_id = supplier_select.value;
            const supplier_tax_id = supplier_select.querySelector('option:checked').getAttribute('data-tax_id');

            const taxSelect = $('#tax_id');
            taxSelect.val(supplier_tax_id).trigger('change');
            
            var rate = document.querySelector('select[name^="tax_id"] option:checked').getAttribute('data-rate');
            tax_rate = rate / 100;

            updateVOCItemsTotal();
            updateGrandTotal();
        });
    });

    // Fill Currency Field
    document.getElementById('currency_id').value = {{ auth()->user()->currency_id }};
    document.getElementById('currency_id').dispatchEvent(new Event('input'));

    // Fill Foreign Currency Field
    document.getElementById('foreign_currency_id').value = {{ Helper::get_foreign_currency()->id }};
    document.getElementById('foreign_currency_id').dispatchEvent(new Event('input'));

    // Fill Rate Field
    document.getElementById('rate').value = {{ Helper::get_foreign_currency()->rate }};
    document.getElementById('rate').dispatchEvent(new Event('input'));
</script>

@endsection
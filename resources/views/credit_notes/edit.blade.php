@extends('layouts.app')

@section('title', 'credit_notes')

@section('sub-title', 'edit')

@section('content')

@php
$currencies = Helper::get_currencies();
$taxes = Helper::get_taxes();
@endphp

<div class="inner-container w-100 m-0 p-5">
    <div class="d-flex justify-content-around">
        <a href="{{ route('accounts.new') }}" class="btn btn-info px-3 py-2 mx-1">
            <i class="fa-solid fa-plus"></i> Account</a>
        <a href="{{ route('clients.new') }}" class="btn btn-info px-3 py-2 mx-1">
            <i class="fa-solid fa-plus"></i> Client</a>
    </div>

    <div class="card">
        <div class="card-header bg-info border-b">
            <h4 class="font-weight-bolder">Edit Credit Note</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('credit_notes.update', $cdnote->id) }}" enctype="multipart/form-data">
                @csrf

                <div class="input-group input-group-outline row my-3">
                    <label for="currency_id" class="col-md-5 col-form-label text-md-end">{{ __('Currency
                        *') }}</label>

                    <div class="col-md-6">
                        <select name="currency_id" id="currency_id" required class="form-select select2">
                            <option value=""></option>
                            @foreach ($currencies as $currency)
                            <option value="{{ $currency->id }}" {{ $currency->id == $cdnote->currency_id ?
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
                            <option value="{{ $currency->id }}" {{ $currency->id == $cdnote->foreign_currency_id ?
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
                            value="{{ $cdnote->rate }}">

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
                            autocomplete="description" value="{{ $cdnote->description }}">

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
                            name="date" required autocomplete="date" value="{{ $cdnote->date }}">

                        @error('date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="tax_id" class="col-md-5 col-form-label text-md-end">{{ __('Tax')
                        }}</label>

                    <div class="col-md-6">
                        <select name="tax_id" id="tax_id" required class="form-select select2">
                            <option value=""></option>
                            @foreach ($taxes as $tax)
                            <option value="{{ $tax->id }}" {{ $tax->id == $cdnote->tax_id ?
                                'selected':'' }} data-rate="{{ $tax->rate }}">{{ $tax->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <h5 class="mt-5 text-center">Credit Note Items</h5>
                <div class="w-100 my-4 overflow-x-auto">
                    <table class="table table-bordered" id="cdnoteItemsTable">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-sm">Account</th>
                                <th class="text-sm">Amount</th>
                            </tr>

                            @foreach ($cdnote->cdnote_items as $item)
                            <tr>
                                <td></td>
                                <td>{{ $item->account->account_number }}</td>
                                <td>{{ number_format($item->amount, 2) }}</td>
                            </tr>
                            @endforeach
                        </thead>
                        <tbody class="dynamic">
                            <tr class="cdnote-item-row">
                                <td>
                                    <button type="button" class="btn btn-info py-2 px-3 ignore-confirm"
                                        onclick="addCDNoteItemRow()"><i class="fa fa-plus"></i></button>
                                </td>
                                <td>
                                    <select name="account_id[]" class="form-control select2">
                                        <option value=""></option>
                                        @foreach ($accounts as $account)
                                        <option value="{{ $account->id }}">{{
                                            $account->account_number }} | {{ $account->account_description }}
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
                            <tr>
                                <th colspan="2">Tax</th>
                                <th><span id="grand_tax">{{ number_format($total_tax, 2) }}</span></th>
                            </tr>
                            <tr>
                                <th colspan="2">Total After Tax</th>
                                <th><span id="total_after_tax">{{ number_format($total_after_tax, 2) }}</span></th>
                            </tr>
                        </tfoot>
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
    let cdnote_total = parseFloat({{ $total }});
    let cdnote_tax = parseFloat({{ $total_tax }});
    let cdnote_total_after_tax = parseFloat({{ $total_after_tax }});
    let tax_rate = {{ $cdnote->tax->rate ?? 0 }};

    function addCDNoteItemRow() {
        var table = document.getElementById("cdnoteItemsTable").getElementsByTagName('tbody')[0];
        var newRow = table.insertRow(table.rows.length);
        var originalRow = document.querySelector('.cdnote-item-row');

        newRow.innerHTML = originalRow.innerHTML;

        newRow.firstElementChild.innerHTML = '<button type="button" class="btn btn-danger py-2 px-3" onclick="removeRow(this)"><i class="fa fa-minus"></i></button>';
        newRow.cells[1].innerHTML = "<select name='account_id[]' required class='form-select select2'><option value=''></option>@foreach ($accounts as $account)<option value='{{ $account->id }}'>{{$account->account_number}} | {{ $account->account_description }}</option>@endforeach</select>";

        newRow.querySelectorAll('input, select').forEach(function (element) {
            element.addEventListener('input', function () {
                updateCDNoteItemsTotal();
                updateGrandTotal();
            });
        });

        $(newRow).find('.select2').select2();
    }

    function updateCDNoteItemsTotal() {
        var totalAmount = cdnote_total;

        document.querySelectorAll('#cdnoteItemsTable tbody tr').forEach(function (row) {
            var amount = parseFloat(row.querySelector('input[name^="amount"]').value) || 0;

            totalAmount += amount;
        });

        document.getElementById('grand_total').innerText = totalAmount.toFixed(2);
    }

    function updateGrandTotal() {
        var cdnoteItemsTotal = parseFloat(document.getElementById('grand_total').innerText) || 0;

        document.getElementById('grand_total').innerText = cdnoteItemsTotal.toFixed(2);
        document.getElementById('grand_tax').innerText = (cdnoteItemsTotal * tax_rate).toFixed(2);
        document.getElementById('total_after_tax').innerText = (cdnoteItemsTotal + cdnoteItemsTotal * tax_rate).toFixed(2);
    }

    function removeRow(button) {
        var row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
        updateCDNoteItemsTotal();
        updateGrandTotal();
    }

    function updateRateField() {
        var rate = document.querySelector('select[name^="foreign_currency_id"] option:checked').getAttribute('data-rate');

        const rateInput = document.querySelector('#rate');
        rateInput.value = rate;
    }

    document.addEventListener('DOMContentLoaded', function () {
        $('#tax_id').on('select2:select', function (event) {
            var rate = document.querySelector('select[name^="tax_id"] option:checked').getAttribute('data-rate');
            tax_rate = rate / 100;
            updateGrandTotal();
        });

        document.querySelectorAll('#cdnoteItemsTable tbody tr:first-child input, #cdnoteItemsTable tbody tr:first-child select').forEach(function (element) {
            element.addEventListener('input', function () {
                updateCDNoteItemsTotal();
                updateGrandTotal();
            });
        });
    });
</script>
@endsection

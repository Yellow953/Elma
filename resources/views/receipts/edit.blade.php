@extends('layouts.app')

@section('title', 'receipts')

@section('sub-title', 'edit')

@section('content')

@php
$currencies = Helper::get_currencies();
@endphp

<div class="inner-container w-100 m-0 p-5">
    <div class="d-flex justify-content-around">
        <a href="{{ route('suppliers.new') }}" class="btn btn-info px-3 py-2 mx-1">
            <i class="fa-solid fa-plus"></i> Supplier</a>
        <a href="{{ route('items.new') }}" class="btn btn-info px-3 py-2 mx-1">
            <i class="fa-solid fa-plus"></i> Item</a>
    </div>

    <div class="card">
        <div class="card-header bg-info border-b">
            <h4 class="font-weight-bolder">Edit Receipt</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('receipts.update', $receipt->id) }}" enctype="multipart/form-data">
                @csrf

                <div class="input-group input-group-outline row my-3">
                    <label for="supplier_invoice" class="col-md-5 col-form-label text-md-end">{{__('Supplier Invoice *')
                        }}</label>

                    <div class="col-md-6">
                        <input id="supplier_invoice" type="text"
                            class=" form-control @error('supplier_invoice') is-invalid @enderror"
                            name="supplier_invoice" required autocomplete="supplier_invoice"
                            value="{{ $receipt->supplier_invoice }}">

                        @error('supplier_invoice')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="tax_id" class="col-md-5 col-form-label text-md-end">{{ __('Tax
                        *') }}</label>

                    <div class="col-md-6">
                        <select name="tax_id" id="tax_id" required class="form-select select2">
                            <option value=""></option>
                            @foreach ($taxes as $tax)
                            <option value="{{ $tax->id }}" {{ $tax->id == $receipt->tax_id ?
                                'selected':'' }} data-rate="{{ $tax->rate }}">{{ $tax->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="currency_id" class="col-md-5 col-form-label text-md-end">{{ __('Currency
                        *') }}</label>

                    <div class="col-md-6">
                        <select name="currency_id" id="currency_id" required class="form-select select2">
                            <option value=""></option>
                            @foreach ($currencies as $currency)
                            <option value="{{ $currency->id }}" {{ $currency->id == $receipt->currency_id ?
                                'selected':'' }} data-rate="{{ $currency->rate }}">{{ $currency->code }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="foreign_currency_id" class="col-md-5 col-form-label text-md-end">{{ __('Foreign
                        Currency
                        *') }}</label>

                    <div class="col-md-6">
                        <select name="foreign_currency_id" id="foreign_currency_id" required
                            class="form-select select2">
                            <option value=""></option>
                            @foreach ($currencies as $currency)
                            <option value="{{ $currency->id }}" {{ $currency->id == $receipt->foreign_currency_id ?
                                'selected':'' }} data-rate="{{ $currency->rate }}">{{ $currency->code }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="rate" class="col-md-5 col-form-label text-md-end">{{ __('Rate') }}</label>

                    <div class="col-md-6">
                        <input id="rate" type="number" class="rate form-control @error('rate') is-invalid @enderror"
                            step="any" min="0" name="rate" value="{{ $receipt->rate ?? 0 }}">

                        @error('rate')
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
                        <input id="date" type="date" class="form-control date-input @error('date') is-invalid @enderror"
                            name="date" required autocomplete="date" value="{{ $receipt->date }}">

                        @error('date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <h5 class="mt-5 text-center">Receipt Items</h5>
                <div class="w-100 my-4 overflow-x-auto">
                    <table class="table table-bordered" id="receiptItemsTable">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-sm">Item</th>
                                <th class="text-sm">Quantity</th>
                                <th class="text-sm">Unit Cost</th>
                                <th class="text-sm">Total Cost</th>
                            </tr>

                            @foreach ($receipt->receipt_items as $item)
                            <tr>
                                <td></td>
                                <td>{{ $item->item->itemcode }}</td>
                                <td>{{ number_format($item->quantity, 2) }}</td>
                                <td>{{ number_format($item->unit_cost, 2) }}</td>
                                <td>{{ number_format($item->total_cost, 2) }}</td>
                            </tr>
                            @endforeach
                        </thead>
                        <tbody class="dynamic">
                            <tr class="receipt-item-row">
                                <td>
                                    <button type="button" class="btn btn-info py-2 px-3 ignore-confirm"
                                        onclick="addReceiptItemRow()"><i class="fa fa-plus"></i></button>
                                </td>
                                <td>
                                    <select name="item_id[]" class="form-control select2">
                                        <option value=""></option>
                                        @foreach ($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->itemcode }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="quantity[]" class="form-control border" min="0" value="0"
                                        step="any">
                                </td>
                                <td>
                                    <input type="number" name="unit_cost[]" class="form-control border" min="0"
                                        value="0" step="any">
                                </td>
                                <td>
                                    <input type="number" name="total_cost[]" class="form-control border" min="0"
                                        value="0" step="any" disabled>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-center">
                    <div class="row">
                        <div class="col-6">Total</div>
                        <div class="col-6"><span id="receipt_items_total">{{ number_format($total, 2)
                                }}</span></div>
                    </div>
                    <div class="row">
                        <div class="col-6">Tax</div>
                        <div class="col-6"><span id="receipt_items_total_tax">{{ number_format($total_tax, 2)
                                }}</span></div>
                    </div>
                    <div class="row">
                        <div class="col-6">Total After Tax</div>
                        <div class="col-6"><span id="receipt_items_total_after_tax">{{ number_format($total_after_tax,
                                2)
                                }}</span></div>
                    </div>
                    <div class="row">
                        <div class="col-6">Total Foreign</div>
                        <div class="col-6"><span id="receipt_items_total_foreign">{{
                                number_format($total_foreign, 2) }}</span></div>
                    </div>
                </div>

                <h5 class="mt-5 text-center">Landed Costs</h5>
                <div class="w-100 my-4 overflow-x-auto">
                    <table class="table table-bordered" id="landedCostsTable">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-sm">Date</th>
                                <th class="text-sm">Name</th>
                                <th class="text-sm">Supplier</th>
                                <th class="text-sm">Currency</th>
                                <th class="text-sm">Amount</th>
                            </tr>

                            @foreach ($receipt->landed_costs as $landed_cost)
                            <tr>
                                <td></td>
                                <td>{{ $landed_cost->date }}</td>
                                <td>{{ ucwords($landed_cost->name) }}</td>
                                <td>{{ ucwords($landed_cost->supplier->name) }}</td>
                                <td>{{ $landed_cost->currency->code }}</td>
                                <td>{{ number_format($landed_cost->amount, 2) }}</td>
                            </tr>
                            @endforeach
                        </thead>
                        <tbody>
                            <tr class="landed-cost-row">
                                <td>
                                    <button type="button" class="btn btn-info py-2 px-3 ignore-confirm"
                                        onclick="addLandedCostRow()"><i class="fa fa-plus"></i></button>
                                </td>
                                <td>
                                    <input type="date" name="landed_cost_date[]" class="form-control border date-input"
                                        value="{{ date('Y-m-d') }}">
                                </td>
                                <td>
                                    <input type="text" name="name[]" class="form-control border">
                                </td>
                                <td>
                                    <select name="landed_cost_supplier_id[]" class="form-control select2">
                                        <option value=""></option>
                                        @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="landed_cost_currency_id[]" class="form-control">
                                        <option value=""></option>
                                        @foreach ($currencies as $currency)
                                        <option value="{{ $currency->id }}">{{ $currency->code }}</option>
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
                                <th colspan="3"></th>
                                <th><span id="landed_cost_total">{{ number_format($total_landed_cost, 2) }}</span></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <h5 class="mt-5 text-center">Barcodes</h5>
                <div class="w-100 my-4 overflow-x-auto">
                    <table class="table table-bordered" id="receiptBarcodeItemsTable">
                        <thead>
                            <tr>
                                <th class="text-sm">Item</th>
                                <th class="text-sm">Barcodes</th>
                            </tr>

                            @foreach ($receipt->barcodes as $barcode)
                            <tr>
                                <td>{{ $barcode->item->name }}</td>
                                <td>{{ $barcode->barcode }}</td>
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

<script>
    let tax_rate = {{ $receipt->tax->rate / 100 }};
    let receipt_items_total = parseFloat({{ $total }});
    let receipt_items_total_tax = parseFloat({{ $total_tax }});
    let receipt_items_total_after_tax = parseFloat({{ $total_after_tax }});
    let receipt_items_total_foreign = parseFloat({{ $total_foreign }});
    let landed_cost_total = parseFloat({{ $total_landed_cost }});

    function addReceiptItemRow() {
        var table = document.getElementById("receiptItemsTable").getElementsByTagName('tbody')[0];
        var newRow = table.insertRow(table.rows.length);
        var originalRow = document.querySelector('.receipt-item-row');

        newRow.innerHTML = originalRow.innerHTML;

        newRow.firstElementChild.innerHTML = '<button type="button" class="btn btn-danger py-2 px-3" onclick="removeRow(this)"><i class="fa fa-minus"></i></button>';
        newRow.cells[1].innerHTML = "<select name='item_id[]' class='form-control select2' required><option value=''></option>@foreach ($items as $item)<option value='{{ $item->id }}'>{{ $item->itemcode }}</option>@endforeach</select>";

        newRow.querySelectorAll('input').forEach(function(input) {
            input.addEventListener('input', function() {
                updateReceiptItemsTotal();
                updateTotalCostForRow(newRow);
            });
        });

        $(newRow).find('.select2').select2();
    }

    function addLandedCostRow() {
        var table = document.getElementById("landedCostsTable").getElementsByTagName('tbody')[0];
        var newRow = table.insertRow(table.rows.length);
        var originalRow = document.querySelector('.landed-cost-row');

        newRow.innerHTML = originalRow.innerHTML;

        newRow.firstElementChild.innerHTML = '<button type="button" class="btn btn-danger py-2 px-3" onclick="removeRow(this)"><i class="fa fa-minus"></i></button>';
        newRow.cells[3].innerHTML = "<select name='landed_cost_supplier_id[]' class='form-control select2' required><option value=''></option>@foreach ($suppliers as $supplier)<option value='{{ $supplier->id }}'>{{ $supplier->name }}</option>@endforeach</select>";

        newRow.querySelectorAll('input').forEach(function(input) {
            input.addEventListener('input', updateLandedCostTotal);
        });

        $(newRow).find('.select2').select2();
    }

    function removeRow(button) {
        var row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
        updateReceiptItemsTotal();
        updateLandedCostTotal();
    }

    function updateTotalCostForRow(row) {
        var quantity = parseFloat(row.querySelector('input[name^="quantity"]').value) || 0;
        var unitCost = parseFloat(row.querySelector('input[name^="unit_cost"]').value) || 0;

        var totalCost = quantity * unitCost;
        row.querySelector('input[name^="total_cost"]').value = totalCost.toFixed(2);
    }

    function updateReceiptItemsTotal() {
        var total = receipt_items_total;
        var total_tax = receipt_items_total_tax;
        var total_after_tax = receipt_items_total_after_tax;
        var total_foreign = receipt_items_total_foreign;
        var rate = parseFloat(document.querySelector('#rate').value) || 0;

        document.querySelectorAll('#receiptItemsTable tbody tr').forEach(function(row) {
            var quantity = parseFloat(row.querySelector('input[name^="quantity"]').value) || 0;
            var unitCost = parseFloat(row.querySelector('input[name^="unit_cost"]').value) || 0;
            var totalCost = quantity * unitCost;
            var totalCostAfterVat = totalCost + (totalCost * tax_rate);

            total += totalCost;
            total_tax += totalCost * tax_rate;
            total_after_tax += totalCostAfterVat;
            total_foreign += totalCostAfterVat * rate;
        });

        document.getElementById('receipt_items_total').innerText = total.toFixed(2);
        document.getElementById('receipt_items_total_tax').innerText = total_tax.toFixed(2);
        document.getElementById('receipt_items_total_after_tax').innerText = total_after_tax.toFixed(2);
        document.getElementById('receipt_items_total_foreign').innerText = total_foreign.toFixed(2);
    }

    function updateLandedCostTotal() {
        var total = landed_cost_total;
        document.querySelectorAll('#landedCostsTable tbody tr').forEach(function(row) {
            var amount = parseFloat(row.querySelector('input[name^="amount"]').value) || 0;
            total += amount;
        });
        document.getElementById('landed_cost_total').innerText = total.toFixed(2);
    }

    function fillRowWithData(row, data) {
        row.querySelector('select[name^="item_id"]').value = data.item_id;
        row.querySelector('input[name^="quantity"]').value = data.quantity;
        row.querySelector('input[name^="unit_cost"]').value = data.unit_cost;
    }

    document.addEventListener('DOMContentLoaded', function () {
        $('#foreign_currency_id').on('select2:select', function (event) {
            var rate = document.querySelector('select[name^="foreign_currency_id"] option:checked').getAttribute('data-rate');

            const rateInput = document.querySelector('#rate');
            rateInput.value = rate;

            updateReceiptItemsTotal();
            updateLandedCostTotal();
        });

        $('#tax_id').on('select2:select', function (event) {
            var rate = document.querySelector('select[name^="tax_id"] option:checked').getAttribute('data-rate');
            tax_rate = rate / 100;
            updateReceiptItemsTotal();
        });

        document.querySelectorAll('#receiptItemsTable tbody tr').forEach(function(row) {
            row.querySelectorAll('input').forEach(function(input) {
                input.addEventListener('input', function() {
                    updateReceiptItemsTotal();
                    updateTotalCostForRow(row);
                });
            });
        });

        document.querySelectorAll('#landedCostsTable tbody tr').forEach(function(row) {
            row.querySelectorAll('input').forEach(function(input) {
                input.addEventListener('input', updateLandedCostTotal);
            });
        });
    });
</script>
@endsection
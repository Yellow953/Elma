@extends('layouts.app')

@section('title', 'invoices')

@section('sub-title', 'edit')

@section('content')

@php
$currencies = Helper::get_currencies();
@endphp

<div class="inner-container w-100 m-0 p-5">
    <div class="d-flex justify-content-around">
        <a href="{{ route('items.new') }}" class="btn btn-info px-3 py-2 mx-1">
            <i class="fa-solid fa-plus"></i> Item</a>
        <a href="{{ route('clients.new') }}" class="btn btn-info px-3 py-2 mx-1">
            <i class="fa-solid fa-plus"></i> Client</a>
    </div>

    <div class="card">
        <div class="card-header bg-info border-b">
            <h4 class="font-weight-bolder">Edit Invoice</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('invoices.update', $invoice->id) }}" enctype="multipart/form-data">
                @csrf

                <div class="input-group input-group-outline row my-3">
                    <label for="currency_id" class="col-md-5 col-form-label text-md-end">{{ __('Currency
                        *') }}</label>

                    <div class="col-md-6">
                        <select name="currency_id" id="currency_id" required class="form-select select2">
                            <option value=""></option>
                            @foreach ($currencies as $currency)
                            <option value="{{ $currency->id }}" {{ $currency->id == $invoice->currency_id ?
                                'selected':'' }} data-rate="{{ $currency->rate }}">{{ $currency->code }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="tax_id" class="col-md-5 col-form-label text-md-end">{{ __('Tax
                        *') }}</label>

                    <div class="col-md-6">
                        <select name="tax_id" id="tax_id" required class="form-select select2">
                            <option value=""></option>
                            @foreach ($taxes as $tax)
                            <option value="{{ $tax->id }}" {{ $tax->id == $invoice->tax_id ?
                                'selected':'' }} data-rate="{{ $tax->rate }}">{{ $tax->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

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
                                <th class="text-sm">Unit Cost</th>
                                <th class="text-sm">Unit Price</th>
                                <th class="text-sm">Total Cost</th>
                                <th class="text-sm">Total Price</th>
                            </tr>

                            @foreach ($invoice->invoice_items as $item)
                            <tr>
                                <td></td>
                                <td>{{ $item->item->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->unit_cost, 2) }}</td>
                                <td>{{ number_format($item->unit_price, 2) }}</td>
                                <td>{{ number_format($item->total_cost, 2) }}</td>
                                <td>{{ number_format($item->total_price, 2) }}</td>
                            </tr>
                            @endforeach
                        </thead>
                        <tbody class="dynamic">
                            <tr class="invoice-item-row">
                                <td>
                                    <button type="button" class="btn btn-info py-2 px-3 ignore-confirm"
                                        onclick="addInvoiceItemRow()"><i class="fa fa-plus"></i></button>
                                </td>
                                <td>
                                    <select name="item_id[]" class="form-control select2">
                                        <option value=""></option>
                                        @foreach ($items as $item)
                                        <option value="{{ $item->id }}" data-type="{{ $item->type }}"
                                            data-unit-cost='{{ $item->unit_cost }}'
                                            data-unit-price='{{ $item->unit_price }}'>
                                            {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="quantity[]" class="form-control border" min="0" value="0"
                                        step="any">
                                </td>
                                <td>
                                    <input type="number" name="unit_cost[]" class="form-control border" min="0"
                                        value="0" step="any" disabled>
                                </td>
                                <td>
                                    <input type="number" name="unit_price[]" class="form-control border" min="0"
                                        value="0" step="any">
                                </td>
                                <td>
                                    <input type="number" name="total_cost[]" class="form-control border" min="0"
                                        value="0" step="any" disabled>
                                </td>
                                <td>
                                    <input type="number" name="total_price[]" class="form-control border" min="0"
                                        value="0" step="any" disabled>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-center">
                    <div class="row">
                        <div class="col-6">Total</div>
                        <div class="col-6"><span id="invoice_items_total">{{
                                number_format($total, 2) }}</span></div>
                    </div>
                    <div class="row">
                        <div class="col-6">Tax</div>
                        <div class="col-6"><span id="invoice_items_total_tax">{{
                                number_format($total_tax, 2) }}</span></div>
                    </div>
                    <div class="row">
                        <div class="col-6">Total After Tax</div>
                        <div class="col-6"><span id="invoice_items_total_after_tax">{{
                                number_format($total_after_tax, 2) }}</span></div>
                    </div>
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
    let tax_rate = {{ $invoice->tax->rate / 100 }};
    let invoice_items_total = parseFloat({{ $total }});
    let invoice_items_total_tax = parseFloat({{ $total_tax }});
    let invoice_items_total_after_tax = parseFloat({{ $total_after_tax }});
    var items = @json($items);

    function updateFields(selectElement) {
        const newRow = selectElement.closest('tr');
        const itemId = selectElement.value;
        const selectedItem = items.find(item => item.id == itemId);

        if (selectedItem) {
            newRow.querySelector('input[name^="unit_cost"]').value = selectedItem.unit_cost;
            newRow.querySelector('input[name^="unit_price"]').value = selectedItem.unit_price;
        }

        updateInvoiceItemRow(newRow);
    }

    function attachSelect2Event() {
        document.querySelectorAll('select[name="item_id[]"]').forEach(function (selectElement) {
            $(selectElement).select2().on('change', function (event) {
                updateFields(event.target);
            });
        });
    }

    function addInvoiceItemRow() {
        var table = document.getElementById("invoiceItemsTable").getElementsByTagName('tbody')[0];
        var newRow = table.insertRow(table.rows.length);
        var originalRow = document.querySelector('.invoice-item-row');

        newRow.innerHTML = originalRow.innerHTML;

        newRow.firstElementChild.innerHTML = '<button type="button" class="btn btn-danger py-2 px-3" onclick="removeRow(this)"><i class="fa fa-minus"></i></button>';
        newRow.cells[1].innerHTML = "<select name='item_id[]' class='form-control select2' required><option value=''></option>@foreach ($items as $item)<option value='{{ $item->id }}' data-unit-cost='{{ $item->unit_cost }}' data-unit-price='{{ $item->unit_price }}' data-type='{{ $item->type }}'>{{ $item->name }}</option>@endforeach</select>";

        newRow.querySelectorAll('input').forEach(function(input) {
            input.addEventListener('input', function() {
                updateInvoiceItemRow(newRow);
                setupItemSelectionListener(newRow);
            });
        });

        $(newRow).find('.select2').select2().on('change', function (event) {
            updateFields(event.target);
        });
    }

    function removeRow(button) {
        var row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
        updateInvoiceTotal();
    }

    function updateInvoiceItemRow(row) {
        var quantity = parseFloat(row.querySelector('input[name^="quantity"]').value) || 0;
        var unitCost = parseFloat(row.querySelector('input[name^="unit_cost"]').value) || 0;
        var unitPrice = parseFloat(row.querySelector('input[name^="unit_price"]').value) || 0;

        var totalCost = quantity * unitCost;
        var totalPrice = quantity * unitPrice;

        row.querySelector('input[name^="total_cost"]').value = totalCost.toFixed(2);
        row.querySelector('input[name^="total_price"]').value = totalPrice.toFixed(2);

        updateInvoiceTotal();
    }

    function updateInvoiceTotal() {
        var total = invoice_items_total;
        var total_tax = invoice_items_total_tax;
        var total_after_tax = invoice_items_total_after_tax;

        document.querySelectorAll('#invoiceItemsTable tbody tr').forEach(function(row) {
            var total_price = parseFloat(row.querySelector('input[name^="total_price"]').value) || 0;
            var rate = parseFloat(document.querySelector('#rate').value) || 0;

            total += total_price;
            total_tax += total_price * tax_rate;
            total_after_tax += total_price + (total_price * tax_rate);
        });

        document.getElementById('invoice_items_total').innerText = total.toFixed(2);
        document.getElementById('invoice_items_total_tax').innerText = total_tax.toFixed(2);
        document.getElementById('invoice_items_total_after_tax').innerText = total_after_tax.toFixed(2);
    }

    function fillRowWithData(row, data) {
        row.querySelector('select[name^="item_id"]').value = data.item_id;
        row.querySelector('input[name^="quantity"]').value = data.quantity;
        row.querySelector('input[name^="unit_cost"]').value = data.unit_cost;
        row.querySelector('input[name^="unit_price"]').value = data.unit_price;
    }

    function updateItemFields(row) {
        var itemId = row.querySelector('select[name^="item_id"]').value;

        var selectedItem = items.find(item => item.id == itemId);

        if (selectedItem) {
            row.querySelector('input[name^="unit_cost"]').value = selectedItem.unit_cost;
            row.querySelector('input[name^="unit_price"]').value = selectedItem.unit_price;
        }
    }

    function updateItemFields(row, selectedItem) {
        if (selectedItem) {
            row.querySelector('input[name^="unit_cost"]').value = selectedItem.unit_cost;
            row.querySelector('input[name^="unit_price"]').value = selectedItem.unit_price;
        }
    }

    function setupItemSelectionListener(row) {
        row.querySelector('select[name^="item_id"]').addEventListener('change', function() {
            var itemId = this.value;
            var selectedItem = items.find(item => item.id == itemId);
            updateItemFields(row, selectedItem);
            updateInvoiceItemRow(row);
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        attachSelect2Event();

        $('#tax_id').on('select2:select', function (event) {
            var rate = document.querySelector('select[name^="tax_id"] option:checked').getAttribute('data-rate');
            tax_rate = rate / 100;

            updateInvoiceTotal();
        });

        document.querySelectorAll('#invoiceItemsTable tbody tr').forEach(function(row) {
            row.querySelectorAll('input').forEach(function(input) {
                input.addEventListener('input', function() {
                    updateInvoiceItemRow(row);
                });
            });
        });

        document.getElementById('invoiceItemsTable').addEventListener('change', function(event) {
            if (event.target && event.target.matches('select[name^="item_id"]')) {
                var row = event.target.closest('tr');
                var itemId = event.target.value;
                var selectedItem = items.find(item => item.id == itemId);
                updateItemFields(row, selectedItem);
                updateInvoiceItemRow(row);
            }
        });
    });
</script>

@endsection
@extends('layouts.app')

@section('title', 'receipts')

@section('sub-title', 'new')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/stepper.css') }}">

<div class="inner-container w-100 m-0">
    <div class="inner-container w-100 m-0 px-4 px-md-5 pt-3">
        <div class="card">
            <div class="card-header bg-info border-b">
                <h4 class="font-weight-bolder">New Receipt</h4>
            </div>
            <div class="card-body">
                <div class="container px-0 px-md-5">
                    <div class="stepwizard col-12 my-4">
                        <div class="stepwizard-row setup-panel">
                            <div class="stepwizard-step">
                                <a href="#step-1" type="button"
                                    class="btn btn-circle btn-info ignore-confirm disabled">1</a>
                                <p>Receipt</p>
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

                    <form role="form" action="{{ route('receipts.create') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        @if (isset($purchase_order))
                        <input type="hidden" name="purchase_order_id" value="{{ $purchase_order->id }}">
                        @endif

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
                                    <label for="tax_id" class="col-md-4 col-form-label text-md-end">{{ __('Tax
                                        *') }}</label>

                                    <div class="col-md-8">
                                        <select name="tax_id" id="tax_id" required class="form-select select2">
                                            <option value=""></option>
                                            @foreach ($taxes as $tax)
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

                            <div class="d-flex justify-content-end mt-4">
                                <button class="btn btn-info nextBtn ignore-confirm" type="button">Next</button>
                            </div>
                        </div>
                        <div class="row setup-content" id="step-2">
                            <div class="w-100 my-4 overflow-x-auto">
                                <table class="table table-bordered" id="receiptItemsTable">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th class="text-sm">Item</th>
                                            <th class="text-sm">Receipt Number</th>
                                            <th class="text-sm">Description</th>
                                            <th class="text-sm">Quantity</th>
                                            <th class="text-sm">Unit Cost</th>
                                            <th class="text-sm">Total Cost</th>
                                        </tr>
                                    </thead>
                                    <tbody class="dynamic">
                                        <tr class="receipt-item-row">
                                            <td>
                                                <button type="button" class="btn btn-info py-2 px-3 ignore-confirm"
                                                    onclick="addReceiptItemRow()"><i class="fa fa-plus"></i></button>
                                            </td>
                                            <td>
                                                <select name="item_id[]" required class="form-control select2">
                                                    <option value=""></option>
                                                    @foreach ($items as $item)
                                                    <option value="{{ $item->id }}" data-type="{{ $item->type }}">{{
                                                        $item->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="receipt_number[]" class="form-control border"
                                                    required>
                                            </td>
                                            <td>
                                                <input type="text" name="description[]" class="form-control border"
                                                    required>
                                            </td>
                                            <td>
                                                <input type="number" name="quantity[]" class="form-control border"
                                                    required min="0" value="0" step="any">
                                            </td>
                                            <td>
                                                <input type="number" name="unit_cost[]" class="form-control border"
                                                    required min="0" value="0" step="any">
                                            </td>
                                            <td>
                                                <input type="number" name="total_cost[]" class="form-control border"
                                                    min="0" value="0" step="any" disabled>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="text-center">
                                    <div class="row">
                                        <div class="col-6">Total</div>
                                        <div class="col-6"><span id="receipt_items_total">0</span></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">Tax</div>
                                        <div class="col-6"><span id="receipt_items_total_tax">0</span></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">Total After Tax</div>
                                        <div class="col-6"><span id="receipt_items_total_after_tax">0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button class="btn btn-secondary prevBtn ignore-confirm" type="button">Previous</button>
                                <button class="btn btn-info nextBtn ignore-confirm" type="button">Next</button>
                            </div>
                        </div>
                        <div class="row setup-content" id="step-5">
                            <h3>Confirm</h3>

                            <div class="col-md-12">
                                <p class="text-center">Are you sure you want to create this Receipt?</p>
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
    @if (isset($purchase_order))
        let tax_rate = {{ $purchase_order->supplier->tax->rate/100 ?? 0 }};
    @else
        let tax_rate = 0;
    @endif


    function addReceiptItemRow() {
        var table = document.getElementById("receiptItemsTable").getElementsByTagName('tbody')[0];
        var newRow = table.insertRow(table.rows.length);
        var originalRow = document.querySelector('.receipt-item-row');

        newRow.innerHTML = originalRow.innerHTML;

        newRow.firstElementChild.innerHTML = '<button type="button" class="btn btn-danger py-2 px-3" onclick="removeRow(this)"><i class="fa fa-minus"></i></button>';
        newRow.cells[1].innerHTML = "<select name='item_id[]' class='form-control select2' required><option value=''></option>@foreach ($items as $item)<option value='{{ $item->id }}' data-type='{{ $item->type }}'>{{ $item->name }}</option>@endforeach</select>";

        newRow.querySelectorAll('input').forEach(function(input) {
            input.addEventListener('input', function() {
                updateReceiptItemsTotal();
                updateTotalCostForRow(newRow);
            });
        });

        $(newRow).find('.select2').select2();
    }

    function removeRow(button) {
        var row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
        updateReceiptItemsTotal();
    }

    function updateTotalCostForRow(row) {
        var quantity = parseFloat(row.querySelector('input[name^="quantity"]').value) || 0;
        var unitCost = parseFloat(row.querySelector('input[name^="unit_cost"]').value) || 0;

        var totalCost = quantity * unitCost;
        row.querySelector('input[name^="total_cost"]').value = totalCost.toFixed(2);
    }

    function updateReceiptItemsTotal() {
        var total = 0;
        var total_tax = 0;
        var total_after_tax = 0;

        document.querySelectorAll('#receiptItemsTable tbody tr').forEach(function(row) {
            var quantity = parseFloat(row.querySelector('input[name^="quantity"]').value) || 0;
            var unitCost = parseFloat(row.querySelector('input[name^="unit_cost"]').value) || 0;
            var totalCost = quantity * unitCost;
            var totalCostAfterVat = totalCost + (totalCost * tax_rate);

            total += totalCost;
            total_tax += totalCost * tax_rate;
            total_after_tax += totalCostAfterVat;
        });

        document.getElementById('receipt_items_total').innerText = total.toFixed(2);
        document.getElementById('receipt_items_total_tax').innerText = total_tax.toFixed(2);
        document.getElementById('receipt_items_total_after_tax').innerText = total_after_tax.toFixed(2);
    }

    function fillRowWithData(row, data) {
        var itemId = data.item_id;
        var selectElement = $(row).find('select[name^="item_id"]');
        selectElement.val(itemId).trigger('change');

        row.querySelector('input[name^="quantity"]').value = data.quantity;
        row.querySelector('input[name^="unit_cost"]').value = data.unit_cost;
    }

    document.addEventListener('DOMContentLoaded', function () {
        const supplier_select = document.getElementById('supplier_id');
        $('#supplier_id').on('select2:select', function (event) {
            const supplier_id = supplier_select.value;
            const supplier_tax_id = supplier_select.querySelector('option:checked').getAttribute('data-tax_id');

            const taxSelect = $('#tax_id');
            taxSelect.val(supplier_tax_id).trigger('change');

            var rate = document.querySelector('select[name^="tax_id"] option:checked').getAttribute('data-rate');
            tax_rate = rate / 100;
            updateReceiptItemsTotal();
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
    });

    // Fill Currency Field
    document.getElementById('currency_id').value = {{ auth()->user()->currency_id }};
    document.getElementById('currency_id').dispatchEvent(new Event('input'));
</script>

@if(isset($purchase_order))
<script>
    function addPOItems(data) {
        var table = document.getElementById("receiptItemsTable").getElementsByTagName('tbody')[0];
        var rows = table.getElementsByTagName('tr');

        if (rows.length === 1 && rows[0].querySelector('select[name^="item_id"]').value === '') {
            fillRowWithData(rows[0], data);
        } else {
            var newRow = table.insertRow(table.rows.length);
            var originalRow = document.querySelector('.receipt-item-row');

            newRow.innerHTML = originalRow.innerHTML;

            newRow.firstElementChild.innerHTML = '<button type="button" class="btn btn-danger py-2 px-3" onclick="removeRow(this)"><i class="fa fa-minus"></i></button>';
            newRow.cells[1].innerHTML = "<select name='item_id[]' class='form-control select2' required><option value=''></option>@foreach ($items as $item)<option value='{{ $item->id }}' data-type='{{ $item->type }}'>{{ $item->name }}</option>@endforeach</select>";

            fillRowWithData(newRow, data);

            newRow.querySelectorAll('input').forEach(function(input) {
                input.addEventListener('input', function() {
                    updateReceiptItemsTotal();
                    updateTotalCostForRow(newRow);
                });
            });

            $(newRow).find('.select2').select2();
        }
    }

    // Fill Supplier Field
    document.getElementById('supplier_id').value = {{ $purchase_order->supplier_id }};
    document.getElementById('supplier_id').dispatchEvent(new Event('input'));

    // Fill Receipt Items from PO Items
    @foreach($purchase_order->items as $purchase_order_item)
        addPOItems({
            item_id: {{ $purchase_order_item->item_id }},
            quantity: {{ $purchase_order_item->quantity }},
            unit_cost: 0,
        });
    @endforeach

    // Fill Tax Field
    document.getElementById('tax_id').value = {{ $purchase_order->supplier->tax_id }};
    document.getElementById('tax_id').dispatchEvent(new Event('input'));
</script>
@endif

@endsection

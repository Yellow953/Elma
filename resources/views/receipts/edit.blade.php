@extends('layouts.app')

@section('title', 'receipts')

@section('sub-title', 'edit')

@section('content')
<div class="inner-container w-100 m-0 p-5">
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

                            @foreach ($receipt->items as $item)
                            <tr>
                                <td></td>
                                <td>{{ $item->item->name }}</td>
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
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
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
                        <div class="col-6"><span id="receipt_items_total">{{
                                number_format($receipt->items->sum('total_cost'), 2)
                                }}</span></div>
                    </div>
                    <div class="row">
                        <div class="col-6">Tax</div>
                        <div class="col-6"><span id="receipt_items_total_tax">{{
                                number_format($receipt->items->sum('vat'), 2)
                                }}</span></div>
                    </div>
                    <div class="row">
                        <div class="col-6">Total After Tax</div>
                        <div class="col-6"><span id="receipt_items_total_after_tax">{{
                                number_format($receipt->items->sum('total_cost_after_vat'),
                                2)
                                }}</span></div>
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
    let tax_rate = {{ $receipt->tax->rate / 100 }};
    let receipt_items_total = parseFloat({{ $receipt->items->sum('total_cost') }});
    let receipt_items_total_tax = parseFloat({{ $receipt->items->sum('vat') }});
    let receipt_items_total_after_tax = parseFloat({{ $receipt->items->sum('total_cost_after_vat') }});

    function addReceiptItemRow() {
        var table = document.getElementById("receiptItemsTable").getElementsByTagName('tbody')[0];
        var newRow = table.insertRow(table.rows.length);
        var originalRow = document.querySelector('.receipt-item-row');

        newRow.innerHTML = originalRow.innerHTML;

        newRow.firstElementChild.innerHTML = '<button type="button" class="btn btn-danger py-2 px-3" onclick="removeRow(this)"><i class="fa fa-minus"></i></button>';
        newRow.cells[1].innerHTML = "<select name='item_id[]' class='form-control select2' required><option value=''></option>@foreach ($items as $item)<option value='{{ $item->id }}'>{{ $item->name }}</option>@endforeach</select>";

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
        var total = receipt_items_total;
        var total_tax = receipt_items_total_tax;
        var total_after_tax = receipt_items_total_after_tax;

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
        row.querySelector('select[name^="item_id"]').value = data.item_id;
        row.querySelector('input[name^="quantity"]').value = data.quantity;
        row.querySelector('input[name^="unit_cost"]').value = data.unit_cost;
    }

    document.addEventListener('DOMContentLoaded', function () {
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
</script>
@endsection
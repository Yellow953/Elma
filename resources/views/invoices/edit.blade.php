@extends('layouts.app')

@section('title', 'invoices')

@section('sub-title', 'edit')

@section('content')
<div class="inner-container w-100 m-0 p-5">
    <div class="card">
        <div class="card-header bg-info border-b">
            <h4 class="font-weight-bolder">Edit Invoice</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('invoices.update', $invoice->id) }}" enctype="multipart/form-data">
                @csrf

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
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-sm" colspan="3">Item</th>
                                <th class="text-sm">Quantity</th>
                                <th class="text-sm">Unit Price</th>
                                <th class="text-sm">Total Price</th>
                            </tr>

                            @foreach ($invoice_items as $item)
                            <tr>
                                <td>
                                    <a href="{{ route('invoices.items.destroy', $item->id) }}"
                                        class="btn btn-danger btn-sm my-auto show_confirm">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                                <td colspan="3">{{ $item->description }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->unit_price, 2) }}</td>
                                <td>{{ number_format($item->total_price, 2) }}</td>
                            </tr>
                            @endforeach
                        </thead>
                    </table>


                    <h4>New Items</h4>
                    <table class="table table-bordered" id="invoiceItemsTable">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-sm">Item</th>
                                <th class="text-sm">Supplier</th>
                                <th class="text-sm">Description</th>
                                <th class="text-sm">Quantity</th>
                                <th class="text-sm">Unit Price</th>
                                <th class="text-sm">Total Price</th>
                                <th class="text-sm">Tax</th>
                            </tr>
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
                                            data-unit-price='{{ $item->unit_price }}'>
                                            {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select name="supplier_id[]" class="form-control select2 supplier-select"
                                        style="display: none;">
                                        <option value=""></option>
                                        @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="description[]" class="form-control border">
                                </td>
                                <td>
                                    <input type="number" name="quantity[]" class="form-control border" min="1" value="1"
                                        step="any">
                                </td>
                                <td>
                                    <input type="number" name="unit_price[]" class="form-control border" min="0"
                                        value="0" step="any">
                                </td>
                                <td>
                                    <input type="number" name="total_price[]" class="form-control border" min="0"
                                        value="0" step="any" disabled>
                                </td>
                                <td>
                                    <input type="checkbox" name="tax[]" checked>
                                </td>
                            </tr>
                        </tbody>
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
    let tax_rate = {{ $invoice->tax->rate ?? 0 }};
    var items = @json($items);

    function updateFields(selectElement) {
        const newRow = selectElement.closest('tr');
        const itemId = selectElement.value;
        const selectedItem = items.find(item => item.id == itemId);
        const supplierSelect = newRow.querySelector('select[name^="supplier_id"]');
        const supplierSelect2Container = $(supplierSelect).next('.select2-container');

        if (selectedItem) {
            newRow.querySelector('input[name^="unit_price"]').value = selectedItem.unit_price;

            if (selectedItem.type === 'expense') {
                $(supplierSelect).show();
                supplierSelect2Container.show();
                supplierSelect.required = true;
            } else {
                $(supplierSelect).hide();
                supplierSelect2Container.hide();
                supplierSelect.required = false;
                $(supplierSelect).val(null).trigger('change');
            }
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

        newRow.cells[1].innerHTML = "<select name='item_id[]' class='form-control select2'><option value=''></option>@foreach ($items as $item)<option value='{{ $item->id }}' data-unit-price='{{ $item->unit_price }}' data-type='{{ $item->type }}'>{{ $item->name }}</option>@endforeach</select>";

        newRow.cells[2].innerHTML = "<select name='supplier_id[]' class='form-control select2 supplier-select' style='display: none;'><option value=''></option>@foreach ($suppliers as $supplier)<option value='{{ $supplier->id }}'>{{ $supplier->name }}</option>@endforeach</select>";

        newRow.querySelectorAll('input').forEach(function(input) {
            input.addEventListener('input', function() {
                updateInvoiceItemRow(newRow);
                setupItemSelectionListener(newRow);
            });
        });

        $(newRow).find('.select2').each(function() {
            $(this).select2();
            if ($(this).attr('name') === 'supplier_id[]') {
                $(this).next('.select2-container').hide();
            }
        });

        $(newRow).find('select[name="item_id[]"]').on('change', function(event) {
            updateFields(event.target);
        });
    }

    function removeRow(button) {
        var row = button.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }

    function updateInvoiceItemRow(row) {
        var quantity = parseFloat(row.querySelector('input[name^="quantity"]').value) || 0;
        var unitPrice = parseFloat(row.querySelector('input[name^="unit_price"]').value) || 0;

        var totalPrice = quantity * unitPrice;

        row.querySelector('input[name^="total_price"]').value = totalPrice.toFixed(2);
    }

    function updateItemFields(row) {
        var itemId = row.querySelector('select[name^="item_id"]').value;

        var selectedItem = items.find(item => item.id == itemId);

        if (selectedItem) {
            row.querySelector('input[name^="unit_price"]').value = selectedItem.unit_price;
        }
    }

    function updateItemFields(row, selectedItem) {
        if (selectedItem) {
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
@extends('layouts.app')

@section('title', 'invoices')

@section('sub-title', 'new')

@section('content')

@php
$currencies = Helper::get_currencies();
@endphp

<link rel="stylesheet" href="{{ asset('assets/css/stepper.css') }}">

<div class="inner-container w-100 m-0">
    <div class="d-flex justify-content-around">
        <a href="{{ route('items.new') }}" class="btn btn-info px-3 py-2 mx-1">
            <i class="fa-solid fa-plus"></i> Item</a>
        <a href="{{ route('clients.new') }}" class="btn btn-info px-3 py-2 mx-1">
            <i class="fa-solid fa-plus"></i> Client</a>
    </div>

    <div class="inner-container w-100 m-0 px-4 px-md-5 pt-3">
        <div class="card">
            <div class="card-header bg-info border-b">
                <h4 class="font-weight-bolder">New Invoice</h4>
            </div>
            <div class="card-body">
                <div class="container px-0 px-md-5">
                    <div class="stepwizard col-12 my-4">
                        <div class="stepwizard-row setup-panel">
                            <div class="stepwizard-step">
                                <a href="#step-1" type="button"
                                    class="btn btn-circle btn-info ignore-confirm disabled">1</a>
                                <p>Invoice</p>
                            </div>
                            <div class="stepwizard-step">
                                <a href="#step-2" type="button"
                                    class="btn btn-circle btn-default ignore-confirm disabled">2</a>
                                <p>Items</p>
                            </div>
                            <div class="stepwizard-step">
                                <a href="#step-3" type="button"
                                    class="btn btn-circle btn-default ignore-confirm disabled">3</a>
                                <p>Barcodes</p>
                            </div>
                            <div class="stepwizard-step">
                                <a href="#step-4" type="button"
                                    class="btn btn-circle btn-default ignore-confirm disabled">4</a>
                                <p>Confirm</p>
                            </div>
                        </div>
                    </div>

                    <form role="form" action="{{ route('invoices.create') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="so_id" value="{{ $so->id ?? '' }}">

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
                                                'selected':'' }} data-tax_id="{{ $client->tax_id }}">{{ $client->name }}
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

                            <div class="col-md-6">
                                <div class="input-group input-group-outline row mb-3">
                                    <label for="currency_id" class="col-md-4 col-form-label text-md-end">{{
                                        __('Currency
                                        *') }}</label>

                                    <div class="col-md-8">
                                        <select name="currency_id" id="currency_id" required
                                            class="form-select select2">
                                            <option value=""></option>
                                            @foreach ($currencies as $currency)
                                            <option value="{{ $currency->id }}" {{ $currency->id ==
                                                old('currency_id') ?
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
                                            class="form-select select2">
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
                                            class="form-control @error('rate') is-invalid @enderror" name="rate"
                                            value="{{ old('rate') ?? 0 }}" step="any" min="0">

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

                            <div class="d-flex justify-content-end mt-4">
                                <button class="btn btn-info nextBtn ignore-confirm" type="button">Next</button>
                            </div>
                        </div>
                        <div class="row setup-content" id="step-2">
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
                                    </thead>
                                    <tbody class="dynamic">
                                        <tr class="invoice-item-row">
                                            <td>
                                                <button type="button" class="btn btn-info py-2 px-3 ignore-confirm"
                                                    onclick="addInvoiceItemRow()"><i class="fa fa-plus"></i></button>
                                            </td>
                                            <td>
                                                <select name="item_id[]" required class="form-control select2">
                                                    <option value=""></option>
                                                    @foreach ($items as $item)
                                                    <option value="{{ $item->id }}" data-type="{{ $item->type }}"
                                                        data-unit-cost='{{ $item->unit_cost }}'
                                                        data-unit-price='{{ $item->unit_price }}'>
                                                        {{ $item->itemcode }} ({{$item->warehouse->name}})</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="number" name="quantity[]" class="form-control border"
                                                    required min="0" value="0" step="any">
                                            </td>
                                            <td>
                                                <input type="number" name="unit_cost[]" class="form-control border"
                                                    required min="0" value="0" step="any" disabled>
                                            </td>
                                            <td>
                                                <input type="number" name="unit_price[]" class="form-control border"
                                                    required min="0" value="0" step="any">
                                            </td>
                                            <td>
                                                <input type="number" name="total_cost[]" class="form-control border"
                                                    required min="0" value="0" step="any" disabled>
                                            </td>
                                            <td>
                                                <input type="number" name="total_price[]" class="form-control border"
                                                    required min="0" value="0" step="any" disabled>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-center">
                                <div class="row">
                                    <div class="col-6">Total</div>
                                    <div class="col-6"><span id="invoice_items_total">0</span></div>
                                </div>
                                <div class="row">
                                    <div class="col-6">Tax</div>
                                    <div class="col-6"><span id="invoice_items_total_tax">0</span></div>
                                </div>
                                <div class="row">
                                    <div class="col-6">Total After Tax</div>
                                    <div class="col-6"><span id="invoice_items_total_after_tax">0</span></div>
                                </div>
                                <div class="row">
                                    <div class="col-6">Total Foreign</div>
                                    <div class="col-6"><span id="invoice_items_total_foreign">0</span></div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button class="btn btn-secondary prevBtn ignore-confirm" type="button">Previous</button>
                                <button class="btn btn-info nextBtn ignore-confirm" type="button">Next</button>
                            </div>
                        </div>
                        <div class="row setup-content" id="step-3">
                            <p class="text-danger">
                                If the item is of type serialized, please fill the item barcodes or upload an excell
                                file
                                in the following format for each
                                row (Item Name, Barcode)
                            </p>
                            <div class="form-group">
                                <label for="invoice_barcode_excel" class="form-label text-dark">Barcodes
                                    Excel</label>
                                <input type="file" class="form-control" id="invoice_barcode_excel"
                                    name="invoice_barcode_excel">
                            </div>

                            <div class="w-100 my-4 overflow-x-auto">
                                <table class="table table-bordered border" id="invoiceBarcodeItemsTable">
                                    <thead>
                                        <tr>
                                            <th class="text-sm">Item</th>
                                            <th class="text-sm">Quantity</th>
                                            <th class="text-sm">Barcodes</th>
                                        </tr>
                                    </thead>
                                    <tbody id="barcodeFields">
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <button class="btn btn-secondary prevBtn ignore-confirm" type="button">Previous</button>
                                <button class="btn btn-info nextBtn ignore-confirm" type="button">Next</button>
                            </div>
                        </div>
                        <div class="row setup-content" id="step-4">
                            <h3>Confirm</h3>

                            <div class="col-md-12">
                                <p class="text-center">Are you sure you want to create this Invoice?</p>
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
    let tax_rate = {{ $so->project->client->tax->rate }};
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
        newRow.cells[1].innerHTML = "<select name='item_id[]' class='form-control select2' required><option value=''></option>@foreach ($items as $item)<option value='{{ $item->id }}' data-unit-cost='{{ $item->unit_cost }}' data-unit-price='{{ $item->unit_price }}' data-type='{{ $item->type }}'>{{ $item->itemcode }}({{$item->warehouse->name}})</option>@endforeach</select>";

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
        var total = 0;
        var total_tax = 0;
        var total_after_tax = 0;
        var total_foreign = 0;
        var tax_rate = document.querySelector('select[name^="tax_id"] option:checked').getAttribute('data-rate') / 100;

        document.querySelectorAll('#invoiceItemsTable tbody tr').forEach(function(row) {
            var total_price = parseFloat(row.querySelector('input[name^="total_price"]').value) || 0;
            var rate = parseFloat(document.querySelector('#rate').value) || 0;
            
            total += total_price;
            total_tax += total_price * tax_rate;
            total_after_tax += total_price + (total_price * tax_rate);
            total_foreign += (total_price + (total_price * tax_rate)) * rate;
        });

        document.getElementById('invoice_items_total').innerText = total.toFixed(2);
        document.getElementById('invoice_items_total_tax').innerText = total_tax.toFixed(2);
        document.getElementById('invoice_items_total_after_tax').innerText = total_after_tax.toFixed(2);
        document.getElementById('invoice_items_total_foreign').innerText = total_foreign.toFixed(2);
    }

    function fillRowWithData(row, data) {
        var itemId = data.item_id;
        var selectElement = $(row).find('select[name^="item_id"]');
        selectElement.val(itemId).trigger('change');
        
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

    function generateBarcodeFields() {
        var items = {!! json_encode($items) !!};
        var rows = document.querySelectorAll('#invoiceItemsTable tbody tr');
        var barcodeFieldsHTML = '';

        rows.forEach(function(row) {
            var itemId = row.querySelector('select[name^="item_id"]').value;
            var quantity = parseInt(row.querySelector('input[name^="quantity"]').value);
            var itemType = row.querySelector('select[name^="item_id"] option:checked').getAttribute('data-type');

            if (quantity > 0 && itemType == 'Serialized') {
                var item = items.find(item => item.id == itemId);

                // Make an Ajax request to fetch barcodes for the current item
                $.ajax({
                    url: '{{ route("items.barcodes", ["item" => ":itemId"]) }}'.replace(':itemId', itemId),
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        barcodeFieldsHTML += `<tr><td>${item.itemcode}</td><td>${quantity}</td><td>`;

                        for (let i = 0; i < quantity; i++) {
                            barcodeFieldsHTML += `<select name="barcodes[${itemId}][]" class="form-control my-1 select2" required> <option value=""></option>`;

                            response.barcodes.forEach(function(barcode) {
                                barcodeFieldsHTML += `<option value="${barcode.barcode}">${barcode.barcode}</option>`;
                            });

                            barcodeFieldsHTML += `</select> <br>`;
                        }

                        barcodeFieldsHTML += `</td></tr>`;

                        document.getElementById('barcodeFields').innerHTML = barcodeFieldsHTML;

                        $('.select2').select2();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching barcodes:', error);
                    }
                });
            }
        });
    }
    
    document.addEventListener('DOMContentLoaded', function () {
        attachSelect2Event();

        $('#foreign_currency_id').on('select2:select', function (event) {
            var rate = document.querySelector('select[name^="foreign_currency_id"] option:checked').getAttribute('data-rate');
            
            const rateInput = document.querySelector('#rate');
            rateInput.value = rate;

            updateInvoiceTotal();
        });

        const client_select = document.getElementById('client_id');
        $('#client_id').on('select2:select', function (event) {
            const client_id = client_select.value;
            const client_tax_id = client_select.querySelector('option:checked').getAttribute('data-tax_id');

            const taxSelect = $('#tax_id');
            taxSelect.val(client_tax_id).trigger('change');

            updateInvoiceTotal();
        });

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
        
        document.querySelector('#step-2 .nextBtn').addEventListener('click', function() {
            generateBarcodeFields();
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

@if(isset($so))
<script>
    function addSOItems(data) {
        var table = document.getElementById("invoiceItemsTable").getElementsByTagName('tbody')[0];
        var rows = table.getElementsByTagName('tr');

        if (rows.length === 1 && rows[0].querySelector('select[name^="item_id"]').value === '') {
            fillRowWithData(rows[0], data);
        } else {
            var newRow = table.insertRow(table.rows.length);
            var originalRow = document.querySelector('.invoice-item-row');

            newRow.innerHTML = originalRow.innerHTML;

            newRow.firstElementChild.innerHTML = '<button type="button" class="btn btn-danger py-2 px-3" onclick="removeRow(this)"><i class="fa fa-minus"></i></button>';
            newRow.cells[1].innerHTML = "<select name='item_id[]' class='form-control select2' required><option value=''></option>@foreach ($items as $item)<option value='{{ $item->id }}' data-unit-cost='{{ $item->unit_cost }}' data-unit-price='{{ $item->unit_price }}' data-type='{{ $item->type }}'>{{ $item->itemcode }}({{$item->warehouse->name}})</option>@endforeach</select>";

            fillRowWithData(newRow, data);

            newRow.querySelectorAll('input').forEach(function(input) {
                input.addEventListener('input', function() {
                    updateInvoiceTotal();
                    updateInvoiceItemRow(newRow);
                });
            });

            $(newRow).find('.select2').select2();
        }
    }

    // Fill Client Field
    @if($so->project->client_id)
        document.getElementById('client_id').value = {{ $so->project->client_id }};
        document.getElementById('client_id').dispatchEvent(new Event('input'));

        // Fill Tax Field
        document.getElementById('tax_id').value = {{ $so->project->client->tax_id }};
        document.getElementById('tax_id').dispatchEvent(new Event('input'));
    @endif

    // Fill Receipt Items from SO Items
    @foreach($so->so_items as $soItem)
        addSOItems({
            item_id: {{ $soItem->item_id }},
            quantity: {{ $soItem->quantity }},
            unit_cost: {{ $soItem->item->unit_cost }},
            unit_price: {{ $soItem->item->unit_price }},
        });
    @endforeach
</script>
@endif

@endsection
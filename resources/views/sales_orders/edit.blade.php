@extends('layouts.app')

@section('title', 'sales_orders')

@section('sub-title', 'edit')

@php
$statuses = Helper::get_order_statuses();
@endphp

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm rounded">
                <img src="{{ asset('assets/images/sales_order.png') }}" alt="sales_order" class="img-fluid">
            </div>

            <div class="card p-4 mb-4 shadow-sm items-container custom-scroller">
                <h3 class="text-center text-info">Items</h3>

                <div id="items">
                    @foreach ($items as $item)
                    <div class="row">
                        <div class="col-9">
                            {{ $item->name }}
                        </div>
                        <div class="col-3">
                            <button class="btn btn-sm btn-success ignore-confirm"
                                onclick="addSOItem({{ $item->id }}, '{{ $item->name }}', '{{ $item->type }}', {{ $item->unit_price }})"><i
                                    class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <form action="{{ route('sales_orders.update', $sales_order->id) }}" method="post"
                enctype="multipart/form-data">
                @csrf

                <div class="card p-4 mb-4 shadow-sm">
                    <h2 class="text-center text-info">Edit Sales Order</h2>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mt-3">
                                <label for="status" class="col-form-label">Status *</label>

                                <select name="status" id="status" required class="form-select select2">
                                    @foreach ($statuses as $status)
                                    <option value="{{ $status }}" {{ $status==$sales_order->status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mt-3">
                                <label for="order_date" class="col-form-label">Order Date
                                    *</label>

                                <input id="order_date" type="date" placeholder="Enter order_date" required
                                    class="form-control @error('order_date') is-invalid @enderror" name="order_date"
                                    value="{{ $sales_order->order_date }}">

                                @error('order_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mt-3">
                                <label for="due_date" class="col-form-label">Due Date</label>

                                <input id="due_date" type="date"
                                    class="form-control @error('due_date') is-invalid @enderror" name="due_date"
                                    value="{{ $sales_order->due_date }}">

                                @error('due_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label for="notes" class="col-form-label">Notes</label>

                        <textarea id="notes" placeholder="Enter any Notes" rows="3"
                            class="form-textarea @error('notes') is-invalid @enderror"
                            name="notes">{{ $sales_order->notes }}</textarea>

                        @error('notes')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="card p-4 mb-4 shadow-sm">
                    <h3 class="text-center text-info">Items</h3>

                    <div id="existing-items">
                        <table class="table table-fluid table-striped">
                            @forelse ($sales_order->items as $item)
                            <tr>
                                <td class="col-4">
                                    {{ $item->item->name }} <br>
                                    {{ $item->supplier->name ?? '' }}
                                </td>
                                <td class="col-2">{{ number_format($item->quantity, 2) }}</td>
                                <td class="col-2">{{ number_format($item->unit_price, 2) }}</td>
                                <td class="col-2">{{ number_format($item->total_price, 2) }}</td>
                                <td class="col-2"><a href="{{ route('sales_orders.items.destroy', $item->id) }}"
                                        class="btn btn-sm btn-danger show_confirm"><i class="fa fa-trash"></i></a></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">No Sales Order Items Yet...</td>
                            </tr>
                            @endforelse
                        </table>
                    </div>
                    <div id="so-items"></div>
                </div>

                <div class="card mb-4 shadow-sm">
                    <div class="d-flex align-items-center justify-content-around mt-3">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
                        <button type="submit" class="btn btn-info">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const soItems = [];

    function addSOItem(id, name, type, price) {
        if (soItems.find(item => item.id === id)) {
            alert("Item already added...");
            return;
        }
        soItems.push({ id, name, type, price });

        updatesoItemsUI();
    }

    function removeSOItem(id) {
        const index = soItems.findIndex(item => item.id === id);

        if (index !== -1) {
            soItems.splice(index, 1);

            updatesoItemsUI();
        }
    }

    function updatesoItemsUI() {
        const soItemsContainer = document.getElementById('so-items');
        soItemsContainer.innerHTML = '';

        if (soItems.length === 0) {
            soItemsContainer.innerHTML = '<p class="text-center text-muted">No items yet...</p>';
            return;
        }

        soItems.forEach(item => {
            const itemRow = document.createElement('div');
            itemRow.className = 'row mb-2';

            let additionalFields = '';

            if (item.type == 'item') {
                additionalFields = `
                    <div class="col-3">
                        <input type="number" name="items[${item.id}][quantity]" value="1" min="0" step="any" class="form-control" placeholder="Quantity" required>
                    </div>`;
            } else if (item.type == 'expense') {
                additionalFields = `
                    <div class="col-3">
                        <select name="items[${item.id}][supplier_id]" class="form-select select2" required>
                            <option value="">Select Supplier</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>`;
            }

            itemRow.innerHTML = `
                <input type="hidden" name="items[${item.id}][item_id]" value="${item.id}">
                <div class="col-3">
                    ${item.name}
                </div>
                ${additionalFields}
                <div class="col-3">
                    <input type="number" min="0" step="any" name="items[${item.id}][price]" value="${item.price}" class="form-control" required>
                </div>
                <div class="col-3 text-end">
                    <button class="btn btn-sm btn-danger ignore-confirm" onclick="removeSOItem(${item.id})">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            `;

            soItemsContainer.appendChild(itemRow);
        });

        $('.select2').select2();
    }
</script>
@endsection

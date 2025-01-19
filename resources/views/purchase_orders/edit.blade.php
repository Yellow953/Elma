@extends('layouts.app')

@section('title', 'purchase_orders')

@section('sub-title', 'edit')

@php
$statuses = Helper::get_order_statuses();
@endphp

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm rounded">
                <img src="{{ asset('assets/images/purchase_order.png') }}" alt="purchase_order" class="img-fluid">
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
                                onclick="addPOItem({{ $item->id }}, '{{ $item->name }}', {{ $item->unit_price }})"><i
                                    class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <form action="{{ route('purchase_orders.update', $purchase_order->id) }}" method="post"
                enctype="multipart/form-data">
                @csrf

                <div class="card p-4 mb-4 shadow-sm">
                    <h2 class="text-center text-info">Edit Purchase Order</h2>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mt-3">
                                <label for="status" class="col-form-label">Status *</label>

                                <select name="status" id="status" required class="form-select select2">
                                    @foreach ($statuses as $status)
                                    <option value="{{ $status }}" {{ $status==$purchase_order->status ? 'selected' : ''
                                        }}>
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
                                    value="{{ $purchase_order->order_date }}">

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
                                    value="{{ $purchase_order->due_date }}">

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
                            name="notes">{{ $purchase_order->notes }}</textarea>

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
                            @forelse ($purchase_order->items as $item)
                            <tr>
                                <td class="col-4">
                                    {{ $item->item->name }}
                                </td>
                                <td class="col-2">{{ number_format($item->quantity, 2) }}</td>
                                <td class="col-2">{{ number_format($item->unit_price, 2) }}</td>
                                <td class="col-2">{{ number_format($item->total_price, 2) }}</td>
                                <td class="col-2"><a href="{{ route('purchase_orders.items.destroy', $item->id) }}"
                                        class="btn btn-sm btn-danger show_confirm"><i class="fa fa-trash"></i></a></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">No Purchase Order Items Yet...</td>
                            </tr>
                            @endforelse
                        </table>
                    </div>
                    <div id="po-items"></div>
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
    const poItems = [];

    function addPOItem(id, name, price) {
        if (poItems.find(item => item.id === id)) {
            alert("Item already added.");
            return;
        }
        poItems.push({ id, name, price });

        updatepoItemsUI();
    }

    function removePOItem(id) {
        const index = poItems.findIndex(item => item.id === id);

        if (index !== -1) {
            poItems.splice(index, 1);

            updatepoItemsUI();
        }
    }

    function updatepoItemsUI() {
        const poItemsContainer = document.getElementById('po-items');
        poItemsContainer.innerHTML = '';

        if (poItems.length === 0) {
            poItemsContainer.innerHTML = '<p class="text-center text-muted">No items yet...</p>';
            return;
        }

        poItems.forEach(item => {
            const itemRow = document.createElement('div');
            itemRow.className = 'row mb-2';

            let additionalFields = '';

            additionalFields = `
                <div class="col-3">
                    <input type="number" name="items[${item.id}][quantity]" value="1" min="0" step="any" class="form-control" placeholder="Quantity" required>
                </div>`;

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
                    <button class="btn btn-sm btn-danger ignore-confirm" onclick="removePOItem(${item.id})">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            `;

            poItemsContainer.appendChild(itemRow);
        });

        $('.select2').select2();
    }
</script>
@endsection

@extends('layouts.app')

@section('title', 'shipments')

@section('sub-title', 'edit')

@php
$modes = Helper::get_shipping_modes();
$ports = Helper::get_shipping_ports();
$statuses = Helper::get_shipping_statuses();
@endphp

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm rounded">
                <img src="{{ asset('assets/images/shipping.png') }}" alt="Shipping" class="img-fluid">
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
                                onclick="addShippingItem({{ $item->id }}, '{{ $item->name }}', '{{ $item->type }}', {{ $item->unit_price }})"><i
                                    class="fa fa-plus"></i></button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <form action="{{ route('shipments.update', $shipment->id) }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="card p-4 mb-4 shadow-sm">
                    <h2 class="text-center text-info">Edit Shipment</h2>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label for="shipment_number" class="col-form-label">Shipment Number
                                    *</label>

                                <input id="shipment_number" type="text" placeholder="Enter Shipment Number" required
                                    class="form-control @error('shipment_number') is-invalid @enderror"
                                    name="shipment_number" value="{{ $shipment->shipment_number }}">

                                @error('shipment_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label for="client_id" class="col-form-label">Client *</label>

                                <select name="client_id" id="client_id" required class="form-select select2">
                                    <option value="">Select Client</option>
                                    @foreach ($clients as $client)
                                    <option value="{{ $client->id }}" {{ $client->id==$shipment->client_id ? 'selected'
                                        : ''
                                        }}>
                                        {{ $client->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mt-3">
                                <label for="mode" class="col-form-label">Mode *</label>

                                <select name="mode" id="mode" required class="form-select select2">
                                    @foreach ($modes as $mode)
                                    <option value="{{ $mode }}" {{ $mode==$shipment->mode ? 'selected' : '' }}>
                                        {{ $mode }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mt-3">
                                <label for="commodity" class="col-form-label">Commodity
                                    *</label>

                                <input id="commodity" type="text" placeholder="Enter Commodity" required
                                    class="form-control @error('commodity') is-invalid @enderror" name="commodity"
                                    value="{{ $shipment->commodity }}">

                                @error('commodity')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mt-3">
                                <label for="status" class="col-form-label">Status *</label>

                                <select name="status" id="status" required class="form-select select2">
                                    @foreach ($statuses as $status)
                                    <option value="{{ $status }}" {{ $status==$shipment->status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label for="departure" class="col-form-label">Departure *</label>

                                <select name="departure" id="departure" required class="form-select select2">
                                    <option value="">Select Departure Point</option>
                                    @foreach ($ports as $port)
                                    <option value="{{ $port }}" {{ $port==$shipment->departure ? 'selected' : '' }}>
                                        {{ $port }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label for="arrival" class="col-form-label">Arrival *</label>

                                <select name="arrival" id="arrival" required class="form-select select2">
                                    <option value="">Select Arrival Point</option>
                                    @foreach ($ports as $port)
                                    <option value="{{ $port }}" {{ $port==$shipment->arrival ? 'selected' : '' }}>
                                        {{ $port }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label for="shipping_date" class="col-form-label">Shipping Date
                                    *</label>

                                <input id="shipping_date" type="date" placeholder="Enter shipping_date" required
                                    class="form-control @error('shipping_date') is-invalid @enderror"
                                    name="shipping_date" value="{{ $shipment->shipping_date }}">

                                @error('shipping_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label for="delivery_date" class="col-form-label">Delivery Date</label>

                                <input id="delivery_date" type="date"
                                    class="form-control @error('delivery_date') is-invalid @enderror"
                                    name="delivery_date" value="{{ $shipment->delivery_date }}">

                                @error('delivery_date')
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
                            name="notes">{{ $shipment->notes }}</textarea>

                        @error('notes')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="card p-4 mb-4 shadow-sm">
                    <h3 class="text-center text-info">Shipping Items</h3>

                    <div id="existing-items">
                        <table class="table table-fluid table-striped">
                            @forelse ($shipment->items as $item)
                            <tr>
                                <td class="col-4">
                                    {{ $item->item->name }} <br>
                                    {{ $item->supplier_id ? $item->supplier->name : '' }}
                                </td>
                                <td class="col-2">{{ number_format($item->quantity, 2) }}</td>
                                <td class="col-2">{{ number_format($item->unit_price, 2) }}</td>
                                <td class="col-2">{{ number_format($item->total_price, 2) }}</td>
                                <td class="col-2"><a href="{{ route('shipments.items.destroy', $item->id) }}"
                                        class="btn btn-sm btn-danger show_confirm"><i class="fa fa-trash"></i></a></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">No Shipment Items Yet</td>
                            </tr>
                            @endforelse
                        </table>
                    </div>
                    <div id="shipping-items"></div>
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
    const shippingItems = [];

    function addShippingItem(id, name, type, price) {
        if (shippingItems.find(item => item.id === id)) {
            alert("Item already added to the shipment.");
            return;
        }
        shippingItems.push({ id, name, type, price });

        updateShippingItemsUI();
    }

    function removeShippingItem(id) {
        const index = shippingItems.findIndex(item => item.id === id);

        if (index !== -1) {
            shippingItems.splice(index, 1);

            updateShippingItemsUI();
        }
    }

    function updateShippingItemsUI() {
        const shippingItemsContainer = document.getElementById('shipping-items');
        shippingItemsContainer.innerHTML = '';

        if (shippingItems.length === 0) {
            shippingItemsContainer.innerHTML = '<p class="text-center text-muted">No items added to the shipment.</p>';
            return;
        }

        shippingItems.forEach(item => {
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
                    <button class="btn btn-sm btn-danger ignore-confirm" onclick="removeShippingItem(${item.id})">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            `;

            shippingItemsContainer.appendChild(itemRow);
        });

        $('.select2').select2();
    }
</script>
@endsection

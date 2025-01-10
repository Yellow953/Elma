@extends('layouts.app')

@section('title', 'shipments')

@section('sub-title', 'new')

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
            <form action="{{ route('shipments.create') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="card p-4 mb-4 shadow-sm">
                    <h2 class="text-center text-info">New Shipment</h2>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label for="shipment_number" class="col-form-label">Shipment Number
                                    *</label>

                                <input id="shipment_number" type="text" placeholder="Enter Shipment Number" required
                                    class="form-control @error('shipment_number') is-invalid @enderror"
                                    name="shipment_number" value="{{ old('shipment_number') }}">

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
                                    <option value="{{ $client->id }}" {{ $client->id==old('client_id') ? 'selected' : ''
                                        }}>
                                        {{ $client->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label for="mode" class="col-form-label">Mode *</label>

                                <select name="mode" id="mode" required class="form-select select2">
                                    @foreach ($modes as $mode)
                                    <option value="{{ $mode }}" {{ $mode==old('mode') ? 'selected' : '' }}>
                                        {{ $mode }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label for="commodity" class="col-form-label">Commodity
                                    *</label>

                                <input id="commodity" type="text" placeholder="Enter Commodity" required
                                    class="form-control @error('commodity') is-invalid @enderror" name="commodity"
                                    value="{{ old('commodity') }}">

                                @error('commodity')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
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
                                    <option value="{{ $port }}" {{ $port==old('departure') ? 'selected' : '' }}>
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
                                    <option value="{{ $port }}" {{ $port==old('arrival') ? 'selected' : '' }}>
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
                                    name="shipping_date" value="{{ old('shipping_date') }}">

                                @error('shipping_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label for="loading_date" class="col-form-label">Loading Date</label>

                                <input id="loading_date" type="date"
                                    class="form-control @error('loading_date') is-invalid @enderror" name="loading_date"
                                    value="{{ old('loading_date') }}">

                                @error('loading_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label for="vessel_name" class="col-form-label">Vessel Name
                                    *</label>

                                <input id="vessel_name" type="text" placeholder="Enter Vessel Name" required
                                    class="form-control @error('vessel_name') is-invalid @enderror" name="vessel_name"
                                    value="{{ old('vessel_name') }}">

                                @error('vessel_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label for="vessel_date" class="col-form-label">Vessel Date</label>

                                <input id="vessel_date" type="date"
                                    class="form-control @error('vessel_date') is-invalid @enderror" name="vessel_date"
                                    value="{{ old('vessel_date') }}">

                                @error('vessel_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label for="booking_number" class="col-form-label">Booking Number
                                    *</label>

                                <input id="booking_number" type="text" placeholder="Enter Booking Number" required
                                    class="form-control @error('booking_number') is-invalid @enderror"
                                    name="booking_number" value="{{ old('booking_number') }}">

                                @error('booking_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label for="carrier_name" class="col-form-label">Carrier Name
                                    *</label>

                                <input id="carrier_name" type="text" placeholder="Enter Carrier Name" required
                                    class="form-control @error('carrier_name') is-invalid @enderror" name="carrier_name"
                                    value="{{ old('carrier_name') }}">

                                @error('carrier_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label for="consignee_name" class="col-form-label">Consignee Name
                                    *</label>

                                <input id="consignee_name" type="text" placeholder="Enter Consignee Name" required
                                    class="form-control @error('consignee_name') is-invalid @enderror"
                                    name="consignee_name" value="{{ old('consignee_name') }}">

                                @error('consignee_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mt-3">
                                <label for="consignee_country" class="col-form-label">Consignee Country
                                    *</label>

                                <select name="consignee_country" id="consignee_country" required
                                    class="form-select select2">
                                    <option value="">Select Consignee Country</option>
                                    @foreach ($countries as $country)
                                    <option value="{{ $country }}" {{ $country==old('consignee_country') ? 'selected'
                                        : '' }}>
                                        {{ $country }}
                                    </option>
                                    @endforeach
                                </select>

                                @error('consignee_country')
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
                            name="notes">{{ old('notes') }}</textarea>

                        @error('notes')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="card p-4 mb-4 shadow-sm">
                    <h3 class="text-center text-info">Shipping Items</h3>

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
@extends('layouts.app')

@section('title', 'items')

@section('sub-title', 'new')

@section('content')
<div class="inner-container">
    <div class="card">
        <div class="card-header bg-info border-b">
            <h4 class="font-weight-bolder">New Item</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('items.create') }}" enctype="multipart/form-data">
                @csrf

                <div class="input-group input-group-outline row my-3">
                    <label for="name" class="col-md-5 col-form-label text-md-end">{{ __('Name *') }}</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class=" form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="itemcode" class="col-md-5 col-form-label text-md-end">{{ __('Item code *')
                        }}</label>

                    <div class="col-md-6">
                        <input id="itemcode" type="text" class=" form-control @error('itemcode') is-invalid @enderror"
                            name="itemcode" value="{{ old('itemcode') }}" required autocomplete="itemcode">

                        @error('itemcode')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="leveling" class="col-md-5 col-form-label text-md-end">{{ __('Leveling *')
                        }} <br><small>(0 inactive)</small></label>

                    <div class="col-md-6">
                        <input id="leveling" type="number" min="0" step="any"
                            class="form-control @error('leveling') is-invalid @enderror" name="leveling" min="0"
                            step="any" value="{{ old('leveling') ?? 1 }}" required autocomplete="leveling">

                        @error('leveling')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="type" class="col-md-5 col-form-label text-md-end">{{ __('Type *')
                        }}</label>

                    <div class="col-md-6">
                        <select name="type" id="type" class="form-select select2" required>
                            <option value=""></option>
                            @foreach (Helper::get_item_types() as $type)
                            <option value="{{ $type }}" {{ old('type')==$type ? 'selected' : '' }}>{{
                                ucwords($type) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="inventory_account_id" class="col-md-5 col-form-label text-md-end">{{ __('Inventory
                        Account *')
                        }}</label>

                    <div class="col-md-6">
                        <select name="inventory_account_id" id="inventory_account_id" class="form-select select2"
                            required>
                            <option value=""></option>
                            @foreach ($accounts as $account)
                            <option value="{{ $account->id }}" {{ $account->id == old('inventory_account_id') ?
                                'selected' : '' }}>{{
                                $account->account_number }} | {{ $account->account_description }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="cost_of_sales_account_id" class="col-md-5 col-form-label text-md-end">{{ __('Cost Of
                        Sales Account *')
                        }}</label>

                    <div class="col-md-6">
                        <select name="cost_of_sales_account_id" id="cost_of_sales_account_id"
                            class="form-select select2" required>
                            <option value=""></option>
                            @foreach ($accounts as $account)
                            <option value="{{ $account->id }}" {{ $account->id == old('cost_of_sales_account_id') ?
                                'selected' : '' }}>{{
                                $account->account_number }} | {{ $account->account_description }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="sales_account_id" class="col-md-5 col-form-label text-md-end">{{ __('Sales Account *')
                        }}</label>

                    <div class="col-md-6">
                        <select name="sales_account_id" id="sales_account_id" class="form-select select2" required>
                            <option value=""></option>
                            @foreach ($accounts as $account)
                            <option value="{{ $account->id }}" {{ $account->id == old('sales_account_id') ?
                                'selected' : '' }}>{{
                                $account->account_number }} | {{ $account->account_description }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="description" class="col-md-5 col-form-label text-md-end">{{ __('Description')
                        }}</label>

                    <div class="col-md-6">
                        <textarea id="description" rows="5" cols="20"
                            class="form-textarea @error('description') is-invalid @enderror" name="description"
                            value="{{ old('description') }}"></textarea>
                        @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="image" class="col-md-5 col-form-label text-md-end">{{ __('Image') }}</label>

                    <div class="col-md-6">
                        <input id="image" type="file" class=" w-100 @error('image') is-invalid @enderror" name="image">

                        @error('image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="warehouses[]" class="col-md-5 col-form-label text-md-end">{{ __('Warehouses *')
                        }}</label>

                    <div class="col-md-6">
                        <div class="d-flex">
                            @foreach (Helper::get_warehouses() as $warehouse)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="warehouses[]"
                                    id="warehouse_{{ $warehouse->id }}" value="{{ $warehouse->id }}" checked>
                                <label class="form-check-label" for="warehouse_{{ $warehouse->id }}">
                                    {{ ucwords($warehouse->name) }}
                                </label>
                            </div>
                            @endforeach
                        </div>

                        @error('warehouses')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="offset-md-8 col-md-4">
                        <button type="submit" class="btn btn-info w-100">
                            {{ __('Create') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
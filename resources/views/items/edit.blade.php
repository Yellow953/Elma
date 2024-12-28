@extends('layouts.app')

@section('title', 'items')

@section('sub-title', 'edit')

@section('content')
<div class="inner-container">
    <div class="card">
        <div class="card-header bg-info border-b">
            <h4 class="font-weight-bolder">Edit Item</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('items.update', $item->id) }}" enctype="multipart/form-data">
                @csrf

                <div class="input-group input-group-outline row my-3">
                    <label for="name" class="col-md-5 col-form-label text-md-end">{{ __('Name *') }}</label>

                    <div class="col-md-6">
                        <input id="name" type="text" value="{{$item->name}}"
                            class=" form-control @error('name') is-invalid @enderror" name="name" required
                            autocomplete="name">

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
                        <input id="itemcode" type="text" value="{{$item->itemcode}}"
                            class=" form-control @error('itemcode') is-invalid @enderror" name="itemcode" required
                            autocomplete="itemcode">

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
                        <input id="leveling" type="number" value="{{ $item->leveling }}" min="0" step="any"
                            class=" form-control @error('leveling') is-invalid @enderror" name="leveling" required
                            autocomplete="leveling">

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
                        <select name="type" id="type" class=" form-select select2" required>
                            <option value=""></option>
                            @foreach (Helper::get_item_types() as $type)
                            <option value="{{ $type }}" {{ $item->type==$type ? 'selected' : '' }}>{{
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
                            <option value="{{ $account->id }}" {{ $account->id == $item->inventory_account_id ?
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
                            <option value="{{ $account->id }}" {{ $account->id == $item->cost_of_sales_account_id ?
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
                            <option value="{{ $account->id }}" {{ $account->id == $item->sales_account_id ?
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
                            class="form-textarea @error('description') is-invalid @enderror"
                            name="description">{{$item->description}}</textarea>

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
                        <input id="image" type="file" class="w-100 @error('image') is-invalid @enderror" name="image">

                        @error('image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
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
@endsection

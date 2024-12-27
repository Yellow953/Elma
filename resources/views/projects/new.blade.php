@extends('layouts.app')

@section('title', 'projects')

@section('sub-title', 'new')

@section('content')
<div class="inner-container">
    <div class="d-flex justify-content-around">
        <a href="{{ route('clients.new') }}" class="btn btn-info px-3 py-2">New Client</a>
    </div>

    <div class="card">
        <div class="card-header bg-info border-b">
            <h4 class="font-weight-bolder">New Project</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('projects.create') }}" enctype="multipart/form-data">
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
                    <label for="number" class="col-md-5 col-form-label text-md-end">{{ __('Number *') }}</label>

                    <div class="col-md-6">
                        <input id="number" type="number" class=" form-control @error('number') is-invalid @enderror"
                            min="0" name="number" value="{{ old('number') }}" required autocomplete="number">

                        @error('number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="client_id" class="col-md-5 col-form-label text-md-end">{{ __('Client') }}</label>

                    <div class="col-md-6">
                        <select name="client_id" id="client_id" class="form-select select2">
                            <option value=""></option>
                            @foreach ($clients as $client)
                            <option value="{{ $client->id }}" {{ $client->id == old('client_id') ?
                                'selected':'' }}>{{ $client->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="image" class="col-md-5 col-form-label text-md-end">{{ __('Main Image')
                        }}</label>

                    <div class="col-md-6">
                        <input id="image" type="file" class="w-100 @error('image') is-invalid @enderror" name="image">

                        @error('image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="status" class="col-md-5 col-form-label text-md-end">{{ __('Status')
                        }}</label>

                    <div class="col-md-6">
                        <select name="status" id="status" class="form-select select2">
                            <option value="new" selected>new</option>
                            <option value="pending">pending</option>
                            <option value="delivered">delivered</option>
                        </select>
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="warehouse_id" class="col-md-5 col-form-label text-md-end">{{ __('Warehouse
                        *')
                        }}</label>

                    <div class="col-md-6">
                        <select name="warehouse_id" id="warehouse_id" class="form-select select2" required>
                            @foreach (Helper::get_warehouses() as $warehouse)
                            <option value="{{$warehouse->id}}" {{ auth()->user()->location_id ==
                                $warehouse->id ? 'selected' : ''}}>{{$warehouse->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="delivery_date" class="col-md-5 col-form-label text-md-end">{{ __('Delivery
                        date *') }}</label>

                    <div class="col-md-6">
                        <input id="delivery_date" type="date"
                            class="form-control date-input @error('delivery_date') is-invalid @enderror"
                            name="delivery_date" required value="{{ old('delivery_date') }}">

                        @error('delivery_date')
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
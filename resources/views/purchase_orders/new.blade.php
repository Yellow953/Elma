@extends('layouts.app')

@section('title', 'po')

@section('sub-title', 'new')

@section('content')
<div class="inner-container">
    <div class="d-flex justify-content-around">
        <a href="{{ route('suppliers.new') }}" class="btn btn-info">New Supplier</a>
    </div>

    <div class="card">
        <div class="card-header bg-info border-b">
            <h4 class="font-weight-bolder">New PO</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('po.create') }}" enctype="multipart/form-data">
                @csrf
                <div class="input-group input-group-outline row my-3">
                    <label for="supplier_id" class="col-md-5 col-form-label text-md-end">{{ __('Supplier
                        *') }}</label>

                    <div class="col-md-6">
                        <select name="supplier_id" id="supplier_id" required class="form-select select2">
                            <option value=""></option>
                            @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ $supplier->id == old('supplier_id') ?
                                'selected':'' }}>{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="description" class="col-md-5 col-form-label text-md-end">{{ __('Description')
                        }}</label>

                    <div class="col-md-6">
                        <input id="description" type="text"
                            class=" form-control @error('description') is-invalid @enderror" name="description"
                            value="{{ old('description') }}">

                        @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="date" class="col-md-5 col-form-label text-md-end">{{ __('Date') }}</label>

                    <div class="col-md-6">
                        <input id="date" type="date" class="form-control date-input @error('date') is-invalid @enderror"
                            name="date" value="{{ old('date') ?? date('Y-m-d') }}">

                        @error('date')
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

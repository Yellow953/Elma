@extends('layouts.app')

@section('title', 'items')

@section('sub-title', 'edit')

@section('content')
<div class="inner-container">
    <div class="card">
        <div class="card-header bg-info">
            <h4 class="font-weight-bold">Edit Item</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('items.update', $item->id) }}" enctype="multipart/form-data">
                @csrf

                <!-- Item Name -->
                <div class="form-group row my-3">
                    <label for="name" class="col-md-4 col-form-label">Name *</label>
                    <div class="col-md-8">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ $item->name }}" required>
                        @error('name')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="form-group row my-3">
                    <label for="description" class="col-md-4 col-form-label">Description</label>
                    <div class="col-md-8">
                        <textarea id="description" class="form-textarea @error('description') is-invalid @enderror"
                            name="description" rows="3">{{ $item->description }}</textarea>
                        @error('description')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <!-- Unit Price -->
                <div class="form-group row my-3">
                    <label for="unit_price" class="col-md-4 col-form-label">Unit Price *</label>
                    <div class="col-md-8">
                        <input id="unit_price" type="number" step="0.01"
                            class="form-control @error('unit_price') is-invalid @enderror" name="unit_price"
                            value="{{ $item->unit_price }}" required>
                        @error('unit_price')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <!-- Unit -->
                <div class="form-group row my-3">
                    <label for="unit" class="col-md-4 col-form-label">Unit *</label>
                    <div class="col-md-8">
                        <input id="unit" type="text" class="form-control @error('unit') is-invalid @enderror"
                            name="unit" value="{{ $item->unit }}" required>
                        @error('unit')
                        <span class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <!-- Type -->
                <div class="form-group row my-3">
                    <label for="type" class="col-md-4 col-form-label">Type *</label>
                    <div class="col-md-8">
                        <select id="type" class="form-select @error('type') is-invalid @enderror" name="type" required>
                            <option value="item" {{ $item->type=='item' ? 'selected' : '' }}>Item</option>
                            <option value="expense" {{ $item->type=='expense' ? 'selected' : '' }}>Expense</option>
                        </select>
                        @error('type')
                        <span class="invalid-feedback">
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

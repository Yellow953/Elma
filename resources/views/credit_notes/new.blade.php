@extends('layouts.app')

@section('title', 'credit_notes')

@section('sub-title', 'new')

@section('content')
<div class="inner-container">
    <div class="card">
        <div class="card-header bg-info border-b">
            <h4 class="font-weight-bolder">New Credit Note</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('credit_notes.create') }}" enctype="multipart/form-data">
                @csrf

                <div class="input-group input-group-outline row my-3">
                    <label for="client_id" class="col-md-5 col-form-label text-md-end">{{ __('Client *')
                        }}</label>

                    <div class="col-md-6">
                        <select name="client_id" id="client_id" required class="form-select select2">
                            <option value=""></option>
                            @foreach ($clients as $client)
                            <option value="{{ $client->id }}" {{ $client->id==old('client_id') ?
                                'selected' : '' }}>{{ $client->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="tax_id" class="col-md-5 col-form-label text-md-end">{{ __('Tax *')
                        }}</label>

                    <div class="col-md-6">
                        <select name="tax_id" id="tax_id" required class="form-select select2">
                            <option value=""></option>
                            @foreach ($taxes as $tax)
                            <option value="{{ $tax->id }}" {{ $tax->id==old('tax_id') ?
                                'selected' : '' }}>{{ $tax->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="date" class="col-md-5 col-form-label text-md-end">{{ __('Date *')
                        }}</label>

                    <div class="col-md-6">
                        <input id="date" type="date" class="form-control @error('date') is-invalid @enderror"
                            name="date" required value="{{ old('date') ?? date('Y-m-d') }}">

                        @error('date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="currency_id" class="col-md-5 col-form-label text-md-end">{{ __('Currency *')
                        }}</label>

                    <div class="col-md-6">
                        <select name="currency_id" id="currency_id" required class="form-select select2">
                            <option value=""></option>
                            @foreach ($currencies as $currency)
                            <option value="{{ $currency->id }}" {{ $currency->id==old('currency_id') ?
                                'selected' : '' }}>{{ $currency->code }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="amount" class="col-md-5 col-form-label text-md-end">{{ __('Amount *')
                        }}</label>

                    <div class="col-md-6">
                        <input id="amount" type="number" min="0" step="any" class="form-control @error('amount') is-invalid @enderror"
                            name="amount" required value="{{ old('amount') }}">

                        @error('amount')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="description" class="col-md-5 col-form-label text-md-end">{{ __('Description *')
                        }}</label>

                    <div class="col-md-6">
                        <input id="description" type="text" class="form-control @error('description') is-invalid @enderror"
                            name="description" required value="{{ old('description') }}">

                        @error('description')
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

<script>
    // Fill Currency Field
    document.getElementById('currency_id').value = {{ auth()->user()->currency_id }};
    document.getElementById('currency_id').dispatchEvent(new Event('input'));
</script>
@endsection
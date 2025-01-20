@extends('layouts.app')

@section('title', 'expenses')

@section('sub-title', 'new')

@section('content')
<div class="inner-container">
    <div class="card">
        <div class="card-header bg-info border-b">
            <h4 class="font-weight-bolder">New Expense</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('expenses.create') }}" enctype="multipart/form-data">
                @csrf

                <div class="input-group input-group-outline row my-3">
                    <label for="type" class="col-md-5 col-form-label text-md-end">{{ __('Type *')
                        }}</label>

                    <div class="col-md-6">
                        <select name="type" id="type" required class="form-select select2">
                            <option value=""></option>
                            @foreach ($types as $type)
                            <option value="{{ $type }}" {{ $type==old('type') ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="title" class="col-md-5 col-form-label text-md-end">{{ __('Title *') }}</label>

                    <div class="col-md-6">
                        <input id="title" type="text" class=" form-control @error('title') is-invalid @enderror"
                            placeholder="Title" name="title" required autocomplete="title" autofocus
                            value="{{ old('title') }}">

                        @error('title')
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
                            @foreach (Helper::get_currencies() as $currency)
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
                        <input id="amount" type="number" placeholder="Amount"
                            class="form-control @error('amount') is-invalid @enderror" name="amount" required min="0"
                            step="any" autocomplete="amount" value="{{ old('amount') }}">

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
                        <input id="description" type="text" placeholder="Description"
                            class="form-control @error('description') is-invalid @enderror" name="description" required
                            autocomplete="description" value="{{ old('description') }}">

                        @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
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
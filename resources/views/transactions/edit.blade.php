@extends('layouts.app')

@section('title', 'transactions')

@section('sub-title', 'edit')

@section('content')
<div class="inner-container">
    <div class="card">
        <div class="card-header bg-info border-b">
            <h4 class="font-weight-bolder">Edit Transaction</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('transactions.update', $transaction->id) }}"
                enctype="multipart/form-data">
                @csrf

                <div class="input-group input-group-outline row my-3">
                    <label for="title" class="col-md-5 col-form-label text-md-end">{{ __('Title *') }}</label>

                    <div class="col-md-6">
                        <input id="title" type="text" class=" form-control @error('title') is-invalid @enderror"
                            name="title" required value="{{ $transaction->title }}">

                        @error('title')
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
                        <textarea id="description" type="text"
                            class="form-control h-auto @error('description') is-invalid @enderror" name="description"
                            rows="5" required>{{ $transaction->description }}</textarea>

                        @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="input-group input-group-outline row my-3">
                    <label for="credit" class="col-md-5 col-form-label text-md-end">{{ __('Credit *') }}</label>

                    <div class="col-md-6">
                        <input id="credit" type="number" min="0" step="any"
                            class="form-control @error('credit') is-invalid @enderror" name="credit" required
                            value="{{ $transaction->credit }}">

                        @error('credit')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="input-group input-group-outline row my-3">
                    <label for="debit" class="col-md-5 col-form-label text-md-end">{{ __('Debit *') }}</label>

                    <div class="col-md-6">
                        <input id="debit" type="number" min="0" step="any"
                            class="form-control @error('debit') is-invalid @enderror" name="debit" required
                            value="{{ $transaction->debit }}">

                        @error('debit')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="input-group input-group-outline row my-3">
                    <label for="balance" class="col-md-5 col-form-label text-md-end">{{ __('Balance *') }}</label>

                    <div class="col-md-6">
                        <input id="balance" type="number" min="0" step="any"
                            class="form-control @error('balance') is-invalid @enderror" name="balance" required
                            value="{{ $transaction->balance }}">

                        @error('balance')
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
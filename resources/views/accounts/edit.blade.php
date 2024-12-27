@extends('layouts.app')

@section('title', 'accounts')

@section('sub-title', 'edit')

@section('content')
<div class="inner-container">
    <div class="card">
        <div class="card-header bg-info border-b">
            <h4 class="font-weight-bolder">Edit Account</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('accounts.update', $account->id) }}" enctype="multipart/form-data">
                @csrf

                <div class="input-group input-group-outline row my-3">
                    <label for="account_description" class="col-md-5 col-form-label text-md-end">{{ __('Account
                        Description *') }}</label>

                    <div class="col-md-6">
                        <input id="account_description" type="text"
                            class=" form-control @error('account_description') is-invalid @enderror"
                            name="account_description" required value="{{ $account->account_description }}">

                        @error('account_description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="currency_id" class="col-md-5 col-form-label text-md-end">{{ __('Currency *') }}</label>

                    <div class="col-md-6">
                        <select name="currency_id" id="currency_id" class="form-select select2">
                            <option value=""></option>
                            @foreach (Helper::get_currencies() as $currency)
                            <option value="{{ $currency->id }}" {{ $account->currency_id==$currency->id
                                ? 'selected' : '' }}>{{ ucwords($currency->code) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="offset-md-8 col-md-4">
                        <button type="submit" class="btn btn-info w-100">
                            {{ __('Update') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
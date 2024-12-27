@extends('layouts.app')

@section('title', 'suppliers')

@section('sub-title', 'new')

@section('content')
<div class="inner-container">
    <div class="d-flex justify-content-around">
        <a href="{{ route('accounts.new') }}" class="btn btn-info px-3 py-2">
            <i class="fa-solid fa-plus"></i> Account</a>
    </div>

    <div class="card">
        <div class="card-header bg-info border-b">
            <h4 class="font-weight-bolder">New Supplier</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('suppliers.create') }}" enctype="multipart/form-data">
                @csrf

                <div class="input-group input-group-outline row my-3">
                    <label for="name" class="col-md-5 col-form-label text-md-end">{{ __('Name *') }}</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class=" form-control @error('name') is-invalid @enderror"
                            name="name" required autocomplete="name" autofocus value="{{ old('name') }}">

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="address" class="col-md-5 col-form-label text-md-end">{{ __('Address *')
                        }}</label>

                    <div class="col-md-6">
                        <input id="address" type="text" class=" form-control @error('address') is-invalid @enderror"
                            name="address" required autocomplete="address" value="{{ old('address') }}">

                        @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="contact_person" class="col-md-5 col-form-label text-md-end">{{ __('Contact
                        Person *') }}</label>

                    <div class="col-md-6">
                        <input id="contact_person" type="text"
                            class=" form-control @error('contact_person') is-invalid @enderror" name="contact_person"
                            required autocomplete="contact_person" value="{{ old('contact_person') }}">

                        @error('contact_person')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="email" class="col-md-5 col-form-label text-md-end">{{ __('Email *') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class=" form-control @error('email') is-invalid @enderror"
                            name="email" required autocomplete="email" value="{{ old('email') }}">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="country" class="col-md-5 col-form-label text-md-end">{{ __('Country *')
                        }}</label>

                    <div class="col-md-6">
                        <select name="country" id="country" required class="form-select select2">
                            <option value=""></option>
                            @foreach (Helper::get_countries() as $country)
                            <option value="{{ $country }}" {{ $country==old('country') ? 'selected' : '' }}>{{
                                $country }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="phone" class="col-md-5 col-form-label text-md-end">{{ __('Phone Number
                        *')
                        }}</label>

                    <div class="col-md-6">
                        <input id="phone" type="tel" class=" form-control @error('phone') is-invalid @enderror"
                            name="phone" required autocomplete="phone" value="{{ old('phone') }}">

                        @error('phone')
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
                    <label for="tax_id" class="col-md-5 col-form-label text-md-end">{{ __('Tax *')
                        }}</label>

                    <div class="col-md-6">
                        <select name="tax_id" id="tax_id" required class="form-select select2">
                            <option value=""></option>
                            @foreach (Helper::get_taxes() as $tax)
                            <option value="{{ $tax->id }}" {{ $tax->id==old('tax_id') ?
                                'selected' : '' }}>{{ $tax->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="vat_number" class="col-md-5 col-form-label text-md-end">{{ __('Vat Number
                        *')
                        }}</label>

                    <div class="col-md-6">
                        <input id="vat_number" type="number" min="0"
                            class=" form-control @error('vat_number') is-invalid @enderror" name="vat_number" required
                            autocomplete="vat_number" value="{{ old('vat_number') }}">

                        @error('vat_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="payable_account_id" class="col-md-5 col-form-label text-md-end">{{ __('Payable Account
                        *')
                        }}</label>

                    <div class="col-md-6">
                        <select name="payable_account_id" id="payable_account_id" required class="form-select select2">
                            <option value=""></option>
                            @foreach ($accounts as $account)
                            <option value="{{ $account->id }}" {{ $account->id == old('payable_account_id') ?
                                'selected' : '' }}>{{
                                $account->account_number }} | {{ $account->account_description }}
                            </option>
                            @endforeach
                        </select>
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

<script>
    // Fill Currency Field
    document.getElementById('currency_id').value = {{ auth()->user()->currency_id }};
    document.getElementById('currency_id').dispatchEvent(new Event('input'));
</script>
@endsection
@extends('layouts.app')

@section('title', 'users')

@section('sub-title', 'new')

@section('content')
<div class="inner-container">
    <div class="card">
        <div class="card-header bg-info border-b">
            <h4 class="font-weight-bolder">New user</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('users.create') }}">
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
                    <label for="email" class="col-md-5 col-form-label text-md-end">{{ __('Email *') }}</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class=" form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="input-group input-group-outline row my-3">
                    <label for="phone" class="col-md-5 col-form-label text-md-end">{{ __('Phone
                        Number') }}</label>

                    <div class="col-md-6">
                        <input id="phone" type="number" min="0"
                            class="form-control @error('phone') is-invalid @enderror" name="phone"
                            value="{{ old('phone') }}" autocomplete="phone">

                        @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="currency_id" class="col-md-5 col-form-label text-md-end">{{ __('Currency
                        *') }}</label>

                    <div class="col-md-6">
                        <select name="currency_id" id="currency_id" class="form-select select2" required>
                            <option></option>
                            @foreach (Helper::get_currencies() as $currency)
                            <option value="{{$currency->id}}">{{$currency->code}}</option>
                            @endforeach
                        </select>

                        @error('currency_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="role" class="col-md-5 col-form-label text-md-end">{{ __('Role
                        *') }}</label>

                    <div class="col-md-6">
                        <select name="role" id="role" class="form-select select2" required>
                            <option></option>
                            <option value="user">User</option>
                            <option value="accountant">Accountant</option>
                            <option value="admin">Admin</option>
                        </select>

                        @error('role')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="password" class="col-md-5 col-form-label text-md-end">{{ __('Password
                        *') }}</label>

                    <div class="col-md-6">
                        <input id="password" type="password"
                            class=" form-control @error('password') is-invalid @enderror" name="password" required
                            autocomplete="new-password">

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="password-confirm" class="col-md-5 col-form-label text-md-end">{{
                        __('Confirm Password *') }}</label>

                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class=" form-control" name="password_confirmation"
                            required autocomplete="new-password">
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
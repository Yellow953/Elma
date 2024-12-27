@extends('auth.app')

@section('title', 'Reset Password')

@section('content')
<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <div class="text-right mb-2">
        <a class="text-secondary" href="{{ url()->previous() }}">
            < back </a>
    </div>

    <div class="row mb-3">
        <label for="email" class="col-md-12 col-form-label">{{ __('Email Address')
            }}</label>

        <div class="col-md-12">
            <input id="email" type="email" class="my-3 form-control @error('email') is-invalid @enderror" name="email"
                value="{{ old('email') }}" required autocomplete="email" autofocus>

            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="row mb-0">
        <div class="col-md-12">
            <button type="submit" class="btn btn-info w-100">
                {{ __('Send Password Reset Link') }}
            </button>
        </div>
    </div>
</form>
@endsection
@extends('auth.app')

@section('title', 'Confirm Password')

@section('content')
{{ __('Please confirm your password before continuing.') }}

<form method="POST" action="{{ route('password.confirm') }}">
    @csrf

    <div class="row mb-3">
        <label for="password" class="col-md-12 col-form-label">{{ __('Password')
            }}</label>

        <div class="col-md-12">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                name="password" required autocomplete="current-password">

            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="row mb-0">
        <div class="col-md-12">
            <button type="submit" class="btn btn-info w-100">
                {{ __('Confirm Password') }}
            </button>

            @if (Route::has('password.request'))
            <a class="btn btn-link" href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
            </a>
            @endif
        </div>
    </div>
</form>
@endsection
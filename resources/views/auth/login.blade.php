@extends('auth.app')

@section('title', 'Login')

@section('content')
<form method="POST" action="{{ route('login') }}">
  @csrf

  <label for="email">Email</label>
  <div class="input-group input-group-outline my-2">
    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
      value="{{ old('email') }}" required autocomplete="email" autofocus>
    @error('email')
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
    @enderror
  </div>

  <label for="password">Password</label>
  <div class="input-group input-group-outline my-2">
    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"
      required autocomplete="current-password">
    @error('password')
    <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
    </span>
    @enderror
  </div>

  <div class="row mb-3">
    <div class="col-md-12">
      <div class="d-flex">
        <input class="form-check-input border" type="checkbox" name="remember" id="remember" {{ old('remember')
          ? 'checked' : '' }}>

        <label class="form-check-label" for="remember">
          {{ __('Remember Me') }}
        </label>
      </div>
    </div>
    <div class="text-right mt-1">
      <a class="text-secondary" href="{{ route('password.request') }}">Forgot Password...</a>
    </div>
  </div>

  <button type="submit" class="btn btn-info w-100 mt-1">
    {{ __('Login') }}
  </button>
</form>
@endsection
@extends('layouts.app')

@section('title', 'currencies')

@section('sub-title', 'edit')

@section('content')
<div class="inner-container">
    <div class="card">
        <div class="card-header bg-info border-b bg-info border-b">
            <h4 class="font-weight-bolder">Edit Currency</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('currencies.update', $currency->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="input-group input-group-outline row my-3">
                    <label for="name" class="col-md-5 col-form-label text-md-end">{{ __('Name *') }}</label>

                    <div class="col-md-6">
                        <input id="name" type="text" value="{{$currency->name}}"
                            class=" form-control @error('name') is-invalid @enderror" name="name" required
                            autocomplete="name">

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="code" class="col-md-5 col-form-label text-md-end">{{ __('Code *') }}</label>

                    <div class="col-md-6">
                        <input id="code" type="text" value="{{$currency->code}}"
                            class=" form-control @error('code') is-invalid @enderror" name="code" required
                            autocomplete="code" step="any">

                        @error('code')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="symbol" class="col-md-5 col-form-label text-md-end">{{ __('Symbol *') }}</label>

                    <div class="col-md-6">
                        <input id="symbol" type="text" value="{{$currency->symbol}}"
                            class=" form-control @error('symbol') is-invalid @enderror" name="symbol" required
                            autocomplete="symbol">

                        @error('symbol')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="rate" class="col-md-5 col-form-label text-md-end">{{ __('Rate *') }}</label>

                    <div class="col-md-6">
                        <input id="rate" type="text" value="{{$currency->rate}}"
                            class=" form-control @error('rate') is-invalid @enderror" name="rate" required
                            autocomplete="rate">

                        @error('rate')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
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
@extends('layouts.app')

@section('title', 'taxes')

@section('sub-title', 'edit')

@section('content')
<div class="inner-container">
    <div class="d-flex justify-content-between">
        <a href="{{ route('accounts.new') }}" class="btn btn-info px-3 py-2">
            <i class="fa-solid fa-plus"></i> Account</a>
    </div>

    <div class="card">
        <div class="card-header bg-info border-b bg-info border-b">
            <h4 class="font-weight-bolder">Edit Tax</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('taxes.update', $tax->id) }}" enctype="multipart/form-data">
                @csrf

                <div class="input-group input-group-outline row my-3">
                    <label for="name" class="col-md-5 col-form-label text-md-end">{{ __('Name *') }}</label>

                    <div class="col-md-6">
                        <input id="name" type="text" value="{{ $tax->name }}"
                            class=" form-control @error('name') is-invalid @enderror" name="name" required
                            autocomplete="name" autofocus>

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="account_id" class="col-md-5 col-form-label text-md-end">{{ __('Account *')
                        }}</label>

                    <div class="col-md-6">
                        <select name="account_id" id="account_id" required class="form-select select2">
                            <option value=""></option>
                            @foreach ($accounts as $account)
                            <option value="{{ $account->id }}" {{ $account->id == $tax->account_id ?
                                'selected' : '' }}>{{
                                $account->account_number }} | {{ $account->account_description }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="input-group input-group-outline row my-3">
                    <label for="rate" class="col-md-5 col-form-label text-md-end">{{ __('Rate *') }}</label>

                    <div class="col-md-6">
                        <input id="rate" type="number" value="{{ $tax->rate }}"
                            class=" form-control @error('rate') is-invalid @enderror" name="rate" required
                            autocomplete="rate" step="any" min="0">

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
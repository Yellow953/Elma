@extends('layouts.app')

@section('title', 'users')

@section('sub-title', 'edit')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-header bg-info border-b">
                    <h4 class="font-weight-bolder">Edit User</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="input-group input-group-outline row my-3">
                            <label for="name" class="col-md-5 col-form-label text-md-end">{{ __('Name *') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class=" form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>

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
                                <input id="email" type="email"
                                    class=" form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ $user->email }}" required autocomplete="email">

                                @error('email')
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
                                    <option value="{{$currency->id}}" {{ $user->currency_id==$currency->id ? 'selected'
                                        : '' }}>{{$currency->code}}</option>
                                    @endforeach
                                </select>

                                @error('currency_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group mt-5">
                                <h5>Permissions</h5>

                                @php
                                $groupedPermissions = $permissions->groupBy(function($permission) {
                                return explode('.', $permission->name)[0];
                                });
                                @endphp

                                <div class="row">
                                    @foreach($groupedPermissions as $category => $categoryPermissions)
                                    <div class="col-md-6 my-1">
                                        <h6 class="my-1">{{ ucfirst($category) }}</h6>
                                        <div class="d-flex gap-2">
                                            @foreach($categoryPermissions as $permission)
                                            <label class="mx-1">
                                                <input type="checkbox" name="permissions[]"
                                                    value="{{ $permission->name }}" {{ in_array($permission->name,
                                                $userPermissions) ? 'checked' : '' }}>
                                                {{ ucfirst(explode('.', $permission->name)[1]) }}
                                            </label>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
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
    </div>
</div>
@endsection

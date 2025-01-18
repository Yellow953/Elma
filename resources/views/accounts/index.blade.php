@extends('layouts.app')

@section('title', 'accounts')

@section('content')

@include('accounts._trial_balance_modal')
@include('accounts._statement_modal')
<div class="container">
    <div class="row">
        <div class="col-6 col-md-10 d-flex justify-content-end">
            <button class="btn btn-info py-2 px-3 text-dark ignore-confirm" type="button" id="actionsDropdown"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Actions
            </button>
            <div class="dropdown-menu dropdown-menu-right mt-2" aria-labelledby="actionsDropdown">
                @can('accounts.create')
                <a class="dropdown-item text-dark" href="{{ route('accounts.new') }}">New Account</a>
                @endcan

                @can('accounts.read')
                <a class="dropdown-item text-dark" href="#" onclick="openModal('statement_modal')">Statement Of
                    Account</a>
                <a class="dropdown-item text-dark" href="#" onclick="openModal('trial_balance_modal')">Trial
                    Balance</a>
                @endcan

                @can('accounts.export')
                <a class="dropdown-item text-dark" href="{{ route('accounts.export') }}">Export Accounts</a>
                @endcan
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="d-flex justify-content-end">
                <button class="btn btn-secondary py-2 px-3 mx-2 text-dark ignore-confirm" type="button"
                    id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Filter
                </button>
                <div class="dropdown-menu dropdown-menu-right mt-2 p-4" aria-labelledby="filterDropdown"
                    style="width: 300px">
                    <h4 class="mb-2">Filter Accounts</h4>
                    <form action="{{ route('accounts') }}" method="get" enctype="multipart/form-data">
                        @csrf

                        <div class="input-group input-group-outline my-2">
                            <div class="w-100">
                                <label for="account_number">Account Number</label>
                                <div>
                                    <input type="text" class="form-control border" name="account_number"
                                        placeholder="Account Number" value="{{request()->query('account_number')}}">
                                </div>
                            </div>
                        </div>
                        <div class="input-group input-group-outline my-2">
                            <div class="w-100">
                                <label for="account_description">Account Description</label>
                                <div>
                                    <input type="text" class="form-control border" name="account_description"
                                        placeholder="Account Description"
                                        value="{{request()->query('account_description')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-2">
                                    <div class="w-100">
                                        <label for="type">Account Type</label>
                                        <div>
                                            <select name="type" id="type" class="form-select select2">
                                                <option value=""></option>
                                                @foreach (Helper::get_account_types() as $type)
                                                <option value="{{ $type }}" {{ request()->query('type') == $type ?
                                                    'selected'
                                                    : '' }}>{{ ucwords($type) }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-2">
                                    <div class="w-100">
                                        <label for="currency_id">Currency</label>
                                        <div>
                                            <select name="currency_id" id="currency_id" class="form-select select2">
                                                <option value=""></option>
                                                @foreach (Helper::get_currencies() as $currency)
                                                <option value="{{ $currency->id }}" {{ request()->query('currency_id')
                                                    == $currency->id ?
                                                    'selected'
                                                    : '' }}>{{ $currency->code }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-around mt-3">
                            <button type="reset"
                                class="btn btn-secondary py-2 px-3 mx-2 text-dark ignore-confirm reset-button">reset</button>
                            <button type="submit" class="btn btn-info py-2 px-3 mx-2 text-dark">apply</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid py-2">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3">
                    <div class="bg-gradient-info shadow-info border-radius-lg pt-4 pb-3">
                        <h5 class="text-capitalize ps-3">Accounts Table</h5>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 text-sm text-dark">
                            <thead>
                                <tr>
                                    <th>Account Number</th>
                                    <th>Description</th>
                                    <th>Type</th>
                                    <th>Currency</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($accounts as $account)
                                <tr class="rounded">
                                    <td>
                                        <p>{{ ucwords($account->account_number) }}</p>
                                    </td>
                                    <td>
                                        <p>{{ Str::limit($account->account_description, 50) }}</p>
                                    </td>
                                    <td>
                                        <p>{{ ucwords($account->type) }}</p>
                                    </td>
                                    <td>
                                        <p>{{ ucwords($account->currency->code) }}</p>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-row justify-content-center align-items-center">
                                            @can('accounts.read')
                                            <a href="{{ route('accounts.statement', $account->id) }}"
                                                class="btn btn-info btn-custom" title="Statement Of Account">
                                                <i class="fa-solid fa-receipt"></i>
                                            </a>
                                            @endcan

                                            @can('accounts.update')
                                            <a href="{{ route('accounts.edit', $account->id) }}"
                                                class="btn btn-warning btn-custom" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            @endcan

                                            @can('accounts.delete')
                                            @if ($account->can_delete())
                                            <form method="GET" action="{{ route('accounts.destroy', $account->id) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-danger show_confirm btn-custom"
                                                    data-toggle="tooltip" title='Delete'>
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                            @endif
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5">
                                        No Accounts Found ...
                                    </td>
                                </tr>
                                @endforelse
                                <tr>
                                    <td colspan="5">{{ $accounts->appends(request()->all())->links() }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
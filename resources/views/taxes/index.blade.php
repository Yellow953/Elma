@extends('layouts.app')

@section('title', 'taxes')

@section('actions')
@can('taxes.create')
<a class="btn btn-sm btn-info mx-2" href="{{ route('taxes.new') }}">New Tax</a>
@endcan
@can('taxes.export')
<a class="btn btn-sm btn-info mx-2" href="{{ route('taxes.export') }}">Export Taxes</a>
@endcan
@endsection

@section('filter')
<button class="btn btn-secondary py-2 px-3 mx-2 text-dark ignore-confirm" type="button" id="filterDropdown"
    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Filter
</button>
<div class="dropdown-menu dropdown-menu-right mt-2 p-4" aria-labelledby="filterDropdown">
    <h4 class="mb-2">Filter Taxes</h4>
    <form action="{{ route('taxes') }}" method="get" enctype="multipart/form-data">
        @csrf

        <div class="input-group input-group-outline my-2">
            <div>
                <label for="name">Name</label>
                <div>
                    <input type="text" class="form-control border" name="name" placeholder="Name"
                        value="{{request()->query('name')}}">
                </div>
            </div>
        </div>
        <div class="input-group input-group-outline my-2">
            <div class="w-100">
                <label for="account_id">Account</label>
                <div>
                    <select name="account_id" class="form-select select2">
                        <option value=""></option>
                        @foreach ($accounts as $account)
                        <option value="{{ $account->id }}" {{request()->query('account_id') ==
                            $account->id ? 'selected' : ''}}> {{ $account->account_number }}</option>
                        @endforeach
                    </select>
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
@endsection

@section('content')
<div class="container-fluid py-2">
    <div class="d-flex align-items-center justify-content-end">
        @yield('actions')

        @yield('filter')
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3">
                    <div class="bg-gradient-info shadow-info border-radius-lg pt-4 pb-3">
                        <h5 class="text-capitalize ps-3">Taxes table</h5>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 text-sm text-dark">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Rate</th>
                                    <th>Account</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($taxes as $tax)
                                <tr class="rounded">
                                    <td>
                                        <h6 class="my-auto">{{ ucwords($tax->name) }}</h6>
                                    </td>
                                    <td>
                                        <p>{{ number_format($tax->rate, 2) }} %</p>
                                    </td>
                                    <td>
                                        <p>
                                            {{ $tax->account->account_number }} <br>
                                            {{ $tax->account->account_description }}
                                        </p>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            @can('taxes.update')
                                            <a href="{{ route('taxes.edit', $tax->id) }}"
                                                class="btn btn-warning btn-custom" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            @endcan

                                            @can('taxes.delete')
                                            @if ($tax->can_delete())
                                            <form method="GET" action="{{ route('taxes.destroy', $tax->id) }}">
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
                                    <td colspan="4">
                                        No Taxes Found ...
                                    </td>
                                </tr>
                                @endforelse
                                <tr>
                                    <td colspan="4">{{ $taxes->appends(request()->all())->links() }}</td>
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
@extends('layouts.app')

@section('title', 'expenses')

@section('actions')
@can('expenses.create')
<a class="btn btn-sm btn-info mx-1" href="{{ route('expenses.new') }}">New Expense</a>
@endcan
@can('expenses.export')
<a class="btn btn-sm btn-info mx-1" href="{{ route('expenses.export') }}">Export Expenses</a>
@endcan
@endsection

@section('filter')
<button class="btn btn-secondary py-2 px-3 mx-2 text-dark ignore-confirm" type="button" id="filterDropdown"
    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Filter
</button>
<div class="dropdown-menu dropdown-menu-right mt-2 p-4" aria-labelledby="filterDropdown" style="width: 300px">
    <h4 class="mb-2">Filter Expenses</h4>
    <form action="{{ route('expenses') }}" method="get" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="input-group input-group-outline my-2">
                    <div class="w-100">
                        <label for="title">Title</label>
                        <div>
                            <input type="text" class="form-control border" name="title" placeholder="Title"
                                value="{{request()->query('title')}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group input-group-outline my-2">
                    <div class="w-100">
                        <label for="type">Type</label>
                        <div>
                            <select name="type" id="type" class="form-select select2">
                                <option value=""></option>
                                @foreach ($types as $type)
                                <option value="{{ $type }}" {{ $type==request()->query('type') ?
                                    'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="input-group input-group-outline my-2">
                    <div class="w-100">
                        <label for="user_id">User</label>
                        <div>
                            <select name="user_id" id="user_id" class="form-select select2">
                                <option value=""></option>
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ $user->id ==
                                    request()->query('user_id') ?
                                    'selected' : '' }}>{{ $user->name }}</option>
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
                                @foreach ($currencies as $currency)
                                <option value="{{ $currency->id }}" {{ $currency->id ==
                                    request()->query('currency_id') ?
                                    'selected' : '' }}>{{ $currency->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="input-group input-group-outline my-2">
                    <div class="w-100">
                        <label for="description">Description</label>
                        <div>
                            <input type="text" class="form-control border" name="description" placeholder="Description"
                                value="{{request()->query('description')}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group input-group-outline my-2">
                    <div class="w-100">
                        <label for="date">Date</label>
                        <div>
                            <input type="date" class="form-control border" name="date"
                                value="{{request()->query('date')}}">
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
@endsection

@section('content')
@include('accounts._statement_modal')
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
                        <h5 class="text-capitalize ps-3">Expenses table</h5>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 text-sm text-dark">
                            <thead>
                                <tr>
                                    <th>Expense</th>
                                    <th>User</th>
                                    <th>Currency</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($expenses as $expense)
                                <tr class="rounded">
                                    <td>
                                        <p>{{ ucwords($expense->title) }} <br>
                                            {{ $expense->type }}
                                        </p>
                                    </td>
                                    <td>
                                        <p>
                                            {{ ucwords($expense->user->name) }}
                                        </p>
                                    </td>
                                    <td>
                                        <p>{{ ucwords($expense->currency->name) }}</p>
                                    </td>
                                    <td>
                                        <p>{{ number_format($expense->amount, 2) }}</p>
                                    </td>
                                    <td>
                                        <p>{{ $expense->date }}</p>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-row justify-content-center">
                                            @can('expenses.update')
                                            <a href="{{ route('expenses.edit', $expense->id) }}"
                                                class="btn btn-warning btn-custom" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            @endcan

                                            @can('expenses.delete')
                                            @if ($expense->can_delete())
                                            <form method="GET" action="{{ route('expenses.destroy', $expense->id) }}">
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
                                    <td colspan="6">
                                        No Expenses Found ...
                                    </td>
                                </tr>
                                @endforelse
                                <tr>
                                    <td colspan="6">{{ $expenses->appends(request()->all())->links() }}</td>
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
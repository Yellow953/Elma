@extends('layouts.app')

@section('title', 'transactions')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-end">
                <button class="btn btn-secondary py-2 px-3 mx-2 text-dark ignore-confirm" type="button"
                    id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Filter
                </button>
                <div class="dropdown-menu dropdown-menu-right mt-2 p-4" aria-labelledby="filterDropdown"
                    style="width: 300px">
                    <h4 class="mb-2">Filter Transactions</h4>
                    <form action="{{ route('transactions') }}" method="get" enctype="multipart/form-data">
                        @csrf

                        <div class="input-group input-group-outline my-2">
                            <div class="w-100">
                                <label for="title">Title</label>
                                <div>
                                    <input type="text" class="form-control border" name="title" placeholder="Title"
                                        value="{{request()->query('title')}}">
                                </div>
                            </div>
                        </div>
                        <div class="input-group input-group-outline my-2">
                            <div class="w-100">
                                <label for="description">Description</label>
                                <div>
                                    <input type="text" class="form-control border" name="description"
                                        placeholder="Description" value="{{request()->query('description')}}">
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
                        <h5 class="text-capitalize ps-3">Transactions Table</h5>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 text-sm text-dark">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Currency</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transactions as $transaction)
                                <tr class="rounded">
                                    <td>
                                        <p>{{ ucwords($transaction->title) }}</p>
                                    </td>
                                    <td>
                                        <p>{{ Str::limit($transaction->description, 50) }}</p>
                                    </td>
                                    <td>
                                        <p>
                                            Debit: {{ number_format($transaction->debit,2) }} <br>
                                            Credit: {{ number_format($transaction->credit,2) }} <br>
                                            Balance: {{ number_format($transaction->balance,2) }}
                                        </p>
                                    </td>
                                    <td>
                                        <p>{{ ucwords($transaction->currency->code) }}</p>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-row justify-content-center align-items-center">
                                            @can('transactions.update')
                                            <a href="{{ route('transactions.edit', $transaction->id) }}"
                                                class="btn btn-warning btn-custom" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            @endcan

                                            @can('transactions.delete')
                                            @if ($transaction->can_delete())
                                            <form method="GET"
                                                action="{{ route('transactions.destroy', $transaction->id) }}">
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
                                        No Transactions Found ...
                                    </td>
                                </tr>
                                @endforelse
                                <tr>
                                    <td colspan="5">{{ $transactions->appends(request()->all())->links() }}</td>
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
@extends('layouts.app')

@section('title', 'journal_vouchers')

@section('actions')
@can('journal_vouchers.create')
<a class="btn btn-sm btn-info mx-1" href="{{ route('journal_vouchers.new') }}">New Journal Voucher</a>
@endcan
@can('journal_vouchers.update')
<a class="btn btn-sm btn-info mx-1" href="#" onclick="openModal('batch')">Post Batch</a>
@endcan
@can('journal_vouchers.export')
<a class="btn btn-sm btn-info mx-1" href="{{ route('journal_vouchers.export') }}">Export Journal Voucher</a>
@endcan
@endsection

@section('filter')
<button class="btn btn-secondary py-2 px-3 mx-2 text-dark ignore-confirm" type="button" id="filterDropdown"
    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Filter
</button>
<div class="dropdown-menu dropdown-menu-right mt-2 p-4" aria-labelledby="filterDropdown" style="width: 300px">
    <h4 class="mb-2">Filter Journal Voucher</h4>
    <form action="{{ route('journal_vouchers') }}" method="get" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="input-group input-group-outline my-2">
                    <div class="w-100">
                        <label for="id">JV Number</label>
                        <div>
                            <input type="text" class="form-control border" name="id" placeholder="JV Number"
                                value="{{request()->query('id')}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group input-group-outline my-2">
                    <div class="w-100">
                        <label for="status">Status</label>
                        <div>
                            <select name="status" id="status" class="form-select select2">
                                <option value=""></option>
                                <option value="posted" {{ old('status'=='posted' ? 'selected' : '' ) }}>
                                    Posted</option>
                                <option value="unposted" {{ old('status'=='unposted' ? 'selected' : '' ) }}>Unposted
                                </option>
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
                                    'selected' : '' }}>{{ ucwords($user->name) }}</option>
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
                                <option value="{{ $currency->id }}" {{ $currency->id ==
                                    request()->query('currency_id') ?
                                    'selected' : '' }}>{{ $currency->code }}</option>
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
                        <label for="date">Date</label>
                        <div>
                            <input type="date" class="form-control border" name="date"
                                value="{{request()->query('date')}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group input-group-outline my-2">
                    <div class="w-100">
                        <label for="description">Description</label>
                        <div>
                            <input type="text" class="form-control border" name="description"
                                value="{{request()->query('description')}}">
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
@include('journal_vouchers._batch_modal')
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
                        <h5 class="text-capitalize ps-3">Journal Vouchers Table</h5>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 text-sm text-dark">
                            <thead>
                                <tr>
                                    <th>Journal Voucher</th>
                                    <th>Date</th>
                                    <th>User</th>
                                    <th>Currency</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($journal_vouchers as $journal_voucher)
                                <tr class="rounded">
                                    <td>
                                        <p>{{ $journal_voucher->id }}</p>
                                        {{ Str::limit($journal_voucher->description, 25) }}
                                    </td>
                                    <td>
                                        <p>{{ $journal_voucher->date }}</p>
                                    </td>
                                    <td>
                                        <p>{{ ucwords($journal_voucher->user->name) }}</p>
                                    </td>
                                    <td>
                                        <p>{{ $journal_voucher->currency->code }}</p>
                                    </td>
                                    <td>
                                        <p>{{ $journal_voucher->status }}</p>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-row justify-content-center">
                                            @can('journal_vouchers.read')
                                            <a href="{{ route('journal_vouchers.show', $journal_voucher->id) }}"
                                                class="btn btn-info btn-custom" title="View">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            @endcan

                                            @can('journal_vouchers.update')
                                            @if ($journal_voucher->status == 'unposted')
                                            <a href="{{ route('journal_vouchers.post', $journal_voucher->id) }}"
                                                class="btn btn-info btn-custom" title="Post">
                                                <i class="fa-solid fa-floppy-disk"></i>
                                            </a>
                                            <a href="{{ route('journal_vouchers.edit', $journal_voucher->id) }}"
                                                class="btn btn-warning btn-custom" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            @else
                                            <a href="{{ route('journal_vouchers.copy', $journal_voucher->id) }}"
                                                class="btn btn-info btn-custom" title="Copy">
                                                <i class="fa-solid fa-copy"></i>
                                            </a>
                                            <a href="{{ route('journal_vouchers.backout', $journal_voucher->id) }}"
                                                class="btn btn-warning btn-custom" title="Correct/Backout">
                                                <i class="fa-solid fa-gear"></i>
                                            </a>
                                            <a href="{{ route('journal_vouchers.void', $journal_voucher->id) }}"
                                                class="btn btn-danger btn-custom" title="Void">
                                                <i class="fa-solid fa-ban"></i>
                                            </a>
                                            @endif
                                            @endcan
                                            @can('journal_vouchers.delete')
                                            <form method="GET"
                                                action="{{ route('journal_vouchers.destroy', $journal_voucher->id) }}">
                                                @csrf
                                                <button type="submit" class="btn btn-danger show_confirm btn-custom"
                                                    data-toggle="tooltip" title='Delete'>
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6">
                                        No Journal Vouchers Found ...
                                    </td>
                                </tr>
                                @endforelse
                                <tr>
                                    <td colspan="6">{{ $journal_vouchers->appends(request()->all())->links() }}</td>
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

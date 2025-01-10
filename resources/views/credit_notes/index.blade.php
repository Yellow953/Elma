@extends('layouts.app')

@section('title', 'credit_notes')

@section('actions')
@can('credit_notes.create')
<a class="btn btn-sm btn-info mx-1" href="{{ route('credit_notes.new') }}">New Credit Note</a>
@endcan
@can('credit_notes.export')
<a class="btn btn-sm btn-info mx-1" href="{{ route('credit_notes.export') }}">Export Credit Notes</a>
@endcan
@endsection

@section('filter')
<button class="btn btn-secondary py-2 px-3 mx-2 text-dark ignore-confirm" type="button" id="filterDropdown"
    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Filter
</button>
<div class="dropdown-menu dropdown-menu-right mt-2 p-4" aria-labelledby="filterDropdown" style="width: 300px">
    <h4 class="mb-2">Filter Credit Notes</h4>
    <form action="{{ route('credit_notes') }}" method="get" enctype="multipart/form-data">
        @csrf

        <div class="input-group input-group-outline my-2">
            <div class="w-100">
                <label for="cdnote_number">Number</label>
                <div>
                    <input type="text" class="form-control border" name="cdnote_number" placeholder="C/D Note Number"
                        value="{{request()->query('cdnote_number')}}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="input-group input-group-outline my-2">
                    <div class="w-100">
                        <label for="client_id">Client</label>
                        <div>
                            <select name="client_id" id="client_id" class="form-select select2">
                                <option value=""></option>
                                @foreach ($clients as $client)
                                <option value="{{ $client->id }}" {{ $client->id ==
                                    request()->query('client_id') ?
                                    'selected' : '' }}>{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
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
            <div class="col-6">
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
                        <h5 class="text-capitalize ps-3">Credit Note Table</h5>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 text-sm text-dark">
                            <thead>
                                <tr>
                                    <th>Credit Note Number</th>
                                    <th>Type</th>
                                    <th>Client</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($cdnotes as $cdnote)
                                <tr class="rounded">
                                    <td>
                                        <p>{{ $cdnote->cdnote_number }}</p>
                                    </td>
                                    <td>{{ ucwords($cdnote->type) }}</td>
                                    <td>
                                        {{ ucwords($cdnote->client->name ?? '') }}
                                    </td>
                                    <td>
                                        {{ $cdnote->date }}
                                    </td>
                                    <td>
                                        <div class="d-flex flex-row justify-content-center">
                                            @can('credit_notes.read')
                                            <a href="{{ route('credit_notes.show', $cdnote->id) }}"
                                                class="btn btn-info btn-custom" title="Show">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            @endcan

                                            @can('credit_notes.update')
                                            <a href="{{ route('credit_notes.edit', $cdnote->id) }}"
                                                class="btn btn-warning btn-custom" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            @endcan

                                            @can('credit_notes.delete')
                                            @if ($credit_note->can_delete())
                                            <form method="GET"
                                                action="{{ route('credit_notes.destroy', $cdnote->id) }}">
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
                                        No Credit Notes Found ...
                                    </td>
                                </tr>
                                @endforelse
                                <tr>
                                    <td colspan="6">{{ $cdnotes->appends(request()->all())->links() }}</td>
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
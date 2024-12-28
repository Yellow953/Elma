@extends('layouts.app')

@section('title', 'items')

@section('actions')
@can('items.create')
<a class="btn btn-sm btn-info mx-1" href="{{ route('items.new') }}">New Item</a>
@endcan
@can('items.read')
<a class="btn btn-sm btn-info mx-1" href="#" onclick="openModal('item_report_modal')">Item Report</a>
<a class="btn btn-sm btn-info mx-1" href="#" onclick="openModal('item_track_modal')">Track Serial Number</a>
@endcan
@can('items.export')
<a class="btn btn-sm btn-info mx-1" href="{{ route('items.export') }}">Export Items</a>
@endcan
@endsection

@section('filter')
<button class="btn btn-secondary py-2 px-3 mx-2 text-dark ignore-confirm" type="button" id="filterDropdown"
    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Filter
</button>
<div class="dropdown-menu dropdown-menu-right mt-2 p-4" aria-labelledby="filterDropdown" style="width: 300px">
    <h4 class="mb-2">Filter Items</h4>
    <form action="{{ route('items') }}" method="get" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="input-group input-group-outline my-2">
                    <div class="w-100">
                        <label for="name">Name</label>
                        <div>
                            <input type="text" class="form-control border" name="name" placeholder="Name"
                                value="{{request()->query('name')}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group input-group-outline my-2">
                    <div class="w-100">
                        <label for="itemcode">Itemcode</label>
                        <div>
                            <input type="text" class="form-control border" placeholder="Itemcode" name="itemcode"
                                value="{{request()->query('itemcode')}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
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
@include('items._report_modal')
@include('items._track_modal')
<div class="container-fluid py-2">
    <div class="d-flex align-items-center justify-content-end">
        <form action="{{ route('items') }}" method="get" enctype="multipart/form-data"
            class="d-flex flex-row justify-content-start my-3">
            @csrf

            <input type="text" name="search" id="search" class="form-control my-auto border input-field" required
                autofocus value="{{ request()->query('search') }}">
            <button type="submit" class="btn btn-info btn-custom my-auto">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </form>

        <div>
            @yield('actions')

            @yield('filter')
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3">
                    <div class="bg-gradient-info shadow-info border-radius-lg pt-4 pb-3">
                        <h5 class="text-capitalize ps-3">Items table</h5>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 text-sm text-dark">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $item)
                                <tr class="rounded {{$item->leveling != 0 ? 'bg-success' : 'bg-light'}}">
                                    <td>
                                        <div class="d-flex align-items-center px-2 py-1">
                                            <div>
                                                <a href="{{asset($item->image)}}"><img src="{{asset($item->image)}}"
                                                        class="avatar avatar-sm me-3 border-radius-lg" alt="user1"></a>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $item->itemcode }}</h6>
                                                <p>({{ucwords($item->name)}})</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p>{{number_format($item->quantity, 2)}}</p>
                                        <p class="text-danger">{{number_format($item->leveling, 2)}}</p>
                                    </td>
                                    <td>
                                        <p>{{ucwords($item->description)}}</p>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-row justify-content-center">
                                            @can('items.update')
                                            <a href="{{ route('items.In', $item->id) }}" class="btn btn-info btn-custom"
                                                title="In">
                                                <i class="fa-solid fa-plus"></i>
                                            </a>
                                            @endcan

                                            @if ($item->quantity > 0)
                                            @can('items.update')
                                            <a href="{{ route('items.Out', $item->id) }}"
                                                class="btn btn-info btn-custom" title="Out">
                                                <i class="fa-solid fa-minus"></i>
                                            </a>
                                            @endcan
                                            @endif

                                            @can('items.update')
                                            <a href="{{ route('items.edit', $item->id) }}"
                                                class="btn btn-warning btn-custom" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            @endcan

                                            @can('items.read')
                                            <a href="{{ route('items.activity', $item->id) }}"
                                                class="btn btn-secondary btn-custom" title="Activity">
                                                <i class="fa-solid fa-clock-rotate-left"></i>
                                            </a>
                                            @endcan

                                            @can('items.update')
                                            <a href="{{ route('items.images', $item->id) }}"
                                                class="btn btn-secondary btn-custom" title="Secondary Images">
                                                <i class="fa-solid fa-image"></i>
                                            </a>
                                            <a href="{{ route('items.item_report', $item->id) }}"
                                                class="btn btn-secondary btn-custom" title="Report">
                                                <i class="fa-solid fa-receipt"></i>
                                            </a>
                                            @endcan

                                            @can('items.delete')
                                            <form method="GET" action="{{ route('items.destroy', $item->id) }}">
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
                                    <td colspan="5">
                                        No Items Found
                                    </td>
                                </tr>
                                @endforelse
                                <tr>
                                    <td colspan="5">
                                        {{ $items->appends(request()->all())->links() }}
                                    </td>
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

@extends('layouts.app')

@section('title', 'sales_orders')

@section('actions')
@can('sales_orders.create')
<a class="btn btn-sm btn-info mx-1" href="{{ route('sales_orders.new') }}">New Sales Order</a>
@endcan
@can('sales_orders.export')
<a class="btn btn-sm btn-info mx-1" href="{{ route('sales_orders.export') }}">Export Sales Orders</a>
<a class="btn btn-sm btn-info mx-1" href="{{ route('sales_order_items.export') }}">Export Sales Order Items</a>
@endcan
@endsection

@section('filter')
<button class="btn btn-secondary py-2 px-3 mx-2 text-dark ignore-confirm" type="button" id="filterDropdown"
    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Filter
</button>
<div class="dropdown-menu dropdown-menu-right mt-2 p-4" aria-labelledby="filterDropdown" style="width: 300px">
    <h4 class="mb-2">Filter Sales Orders</h4>
    <form action="{{ route('sales_orders') }}" method="get" enctype="multipart/form-data">
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
                        <label for="description">Description</label>
                        <div>
                            <input type="text" class="form-control border" name="description" placeholder="Description"
                                value="{{request()->query('description')}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="input-group input-group-outline my-2">
            <div class="w-100">
                <label for="date">Date</label>
                <div>
                    <input type="date" class="form-control border" name="date" value="{{request()->query('date')}}">
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
    <div class="d-flex align-items-center justify-content-between">
        <form action="{{ route('sales_orders') }}" method="get" enctype="multipart/form-data"
            class="d-flex flex-row justify-content-start my-3">
            @csrf

            <input type="text" name="name" id="name" class="form-control input-field my-auto border mx-1" required
                autofocus value="{{ request()->query('name') }}">
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
                        <h5 class="text-capitalize ps-3">Sales Orders Table</h5>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 text-sm text-dark">
                            <thead>
                                <tr>
                                    <th class="col-5">SO Number</th>
                                    <th class="col-5">Date</th>
                                    <th class="col-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sales_orders as $sales_order)
                                <tr class="rounded">
                                    <td>
                                        <h6 class="my-auto">{{$sales_order->so_number}}</h6>
                                    </td>
                                    <td>
                                        <p>{{$sales_order->date}}</p>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-row justify-content-center">
                                            @can('sales_orders.create')
                                            <a href="{{ route('sales_orders.AddItems', $sales_order->id) }}"
                                                class="btn btn-info btn-custom" title="Add Items">
                                                <i class="fa-solid fa-plus"></i>
                                            </a>
                                            @endcan

                                            @can('sales_orders.read')
                                            <a href="{{ route('sales_orders.show', $sales_order->id) }}"
                                                class="btn btn-info btn-custom" title="Show">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('sales_orders.activity', $sales_order->id) }}"
                                                class="btn btn-secondary btn-custom" title="Activity">
                                                <i class="fa-solid fa-clock-rotate-left"></i>
                                            </a>
                                            @endcan

                                            @can('sales_orders.update')
                                            <a href="{{ route('sales_orders.edit', $sales_order->id) }}" title="Edit"
                                                class="btn btn-warning btn-custom">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            @endcan

                                            @can('invoices.create')
                                            <a href="{{ route('sales_orders.new_invoice', $sales_order->id) }}"
                                                class="btn btn-success btn-custom" title="New Invoice">
                                                <i class="fa-solid fa-receipt"></i>
                                            </a>
                                            @endcan

                                            @can('sales_orders.delete')
                                            <form method="GET"
                                                action="{{ route('sales_orders.destroy', $sales_order->id) }}">
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
                                    <td colspan="3">
                                        No Sales Orders Found
                                    </td>
                                </tr>
                                @endforelse
                                <tr>
                                    <td colspan="3">{{ $sales_orders->appends(request()->all())->links() }}</td>
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
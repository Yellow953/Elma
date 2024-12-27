@extends('layouts.app')

@section('title', 'po')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-12 col-md-8 my-1">
      <form action="{{ route('po') }}" method="get" enctype="multipart/form-data"
        class="d-flex flex-row justify-content-start">
        <input type="text" name="search" id="search" class="form-control input-field my-auto border mx-1" required
          autofocus value="{{ request()->query('search') }}">
        <button type="submit" class="btn btn-info btn-custom my-auto">
          <i class="fa-solid fa-magnifying-glass"></i>
        </button>
      </form>
    </div>
    <div class="col-6 col-md-2 d-flex justify-content-end">
      <button class="btn btn-info py-2 px-3 text-dark ignore-confirm" type="button" id="actionsDropdown"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Actions
      </button>
      <div class="dropdown-menu dropdown-menu-right mt-2" aria-labelledby="actionsDropdown">
        <a class="dropdown-item text-dark" href="{{ route('po.new') }}">New PO</a>
        @if (auth()->user()->role == 'admin')
        <a class="dropdown-item text-dark" href="{{ route('export.pos') }}">Export POs</a>
        <a class="dropdown-item text-dark" href="{{ route('export.po_items') }}">Export PO Items</a>
        @endif
      </div>
    </div>
    <div class="col-6 col-md-2">
      <div class="d-flex justify-content-end">
        <button class="btn btn-secondary py-2 px-3 mx-2 text-dark ignore-confirm" type="button" id="filterDropdown"
          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Filter
        </button>
        <div class="dropdown-menu dropdown-menu-right mt-2 p-4" aria-labelledby="filterDropdown" style="width: 300px">
          <h4 class="mb-2">Filter POs</h4>
          <form action="{{ route('po') }}" method="get" enctype="multipart/form-data">
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
                    <label for="supplier_id">Supplier</label>
                    <div>
                      <select name="supplier_id" class="form-select select2">
                        <option value=""></option>
                        @foreach ($suppliers as $supplier)
                        <option value="{{ $supplier->id }}" {{request()->query('supplier_id') == $supplier->id ?
                          'selected' : ''}}>{{ ucwords($supplier->name) }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="input-group input-group-outline my-2">
              <div class="w-100">
                <label for="description">Description</label>
                <div>
                  <input type="text" class="form-control border" name="description" placeholder="Description"
                    value="{{request()->query('description')}}">
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
            <h5 class="text-capitalize ps-3">PO table</h5>
          </div>
        </div>
        <div class="card-body px-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0 text-sm text-dark">
              <thead>
                <tr>
                  <th>PO</th>
                  <th>Supplier</th>
                  <th>Date</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($pos as $po)
                <tr class="rounded">
                  <td>
                    <h6 class="my-auto">{{$po->name}}</h6>
                  </td>
                  <td>
                    <p>{{ ucwords($po->supplier->name) }}</p>
                  </td>
                  <td>
                    <p>{{$po->date}}</p>
                  </td>
                  <td>
                    <div class="d-flex flex-row justify-content-center">
                      <a href="{{ route('po.AddItems', $po->id) }}" class="btn btn-info btn-custom" title="Add items">
                        <i class="fa-solid fa-plus"></i>
                      </a>
                      <a href="{{ route('po.show', $po->id) }}" class="btn btn-info btn-custom" title="Show">
                        <i class="fa-solid fa-eye"></i>
                      </a>
                      <a href="{{ route('po.activity', $po->id) }}" class="btn btn-secondary btn-custom"
                        title="Activity">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                      </a>
                      <a href="{{ route('po.quantities', $po->id) }}" class="btn btn-secondary btn-custom"
                        title="Quantities">
                        <i class="fa-solid fa-hashtag"></i>
                      </a>
                      <a href="{{ route('po.edit', $po->id) }}" class="btn btn-warning btn-custom" title="Edit">
                        <i class="fa-solid fa-pen-to-square"></i>
                      </a>
                      @if (auth()->user()->role != 'user' && $po->receipt == null)
                      <a href="{{ route('po.new_receipt', $po->id) }}" class="btn btn-success btn-custom"
                        title="New Receipt">
                        <i class="fa-solid fa-receipt"></i>
                      </a>
                      @endif
                      @if (auth()->user()->role == 'admin' && $po->can_delete())
                      <form method="GET" action="{{ route('po.destroy', $po->id) }}">
                        @csrf
                        <button type="submit" class="btn btn-danger show_confirm btn-custom" data-toggle="tooltip"
                          title='Delete'>
                          <i class="fa-solid fa-trash"></i>
                        </button>
                      </form>
                      @endif
                    </div>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="5">
                    No POs Found
                  </td>
                </tr>
                @endforelse
                <tr>
                  <td colspan="5">{{$pos->appends(['name' => request()->query('name'), 'supplier_id' =>
                    request()->query('supplier_id'), 'description' => request()->query('description'), 'date' =>
                    request()->query('date'), 'search' =>
                    request()->query('search')])->links()}}</td>
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
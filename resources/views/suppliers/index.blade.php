@extends('layouts.app')

@section('title', 'suppliers')

@section('content')

@include('accounts._statement_modal')

<div class="container">
  <div class="row">
    <div class="col-6 col-md-10 d-flex justify-content-end">
      <button class="btn btn-info py-2 px-3 text-dark ignore-confirm" type="button" id="actionsDropdown"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Actions
      </button>
      <div class="dropdown-menu dropdown-menu-right mt-2" aria-labelledby="actionsDropdown">
        <a class="dropdown-item text-dark" href="{{ route('suppliers.new') }}">New Supplier</a>
        <a class="dropdown-item text-dark" href="#" onclick="openModal('statement_modal')">Statement Of
          Account</a>
        @if (auth()->user()->role == 'admin')
        <a class="dropdown-item text-dark" href="{{ route('export.suppliers') }}">Export Suppliers</a>
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
          <h4 class="mb-2">Filter Suppliers</h4>
          <form action="{{ route('suppliers') }}" method="get" enctype="multipart/form-data">
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
                    <label for="contact_person">Contact</label>
                    <div>
                      <input type="text" class="form-control border" name="contact_person" placeholder="Contact Person"
                        value="{{request()->query('contact_person')}}">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="input-group input-group-outline my-2">
                  <div class="w-100">
                    <label for="email">Email</label>
                    <div>
                      <input type="email" class="form-control border" name="email" placeholder="Email"
                        value="{{request()->query('email')}}">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="input-group input-group-outline my-2">
                  <div class="w-100">
                    <label for="phone">Phone</label>
                    <div>
                      <input type="tel" class="form-control border" name="phone" placeholder="Phone Number"
                        value="{{request()->query('phone')}}">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="input-group input-group-outline my-2">
                  <div class="w-100">
                    <label for="tax_id">Tax</label>
                    <div>
                      <input type="text" class="form-control border" name="tax_id" placeholder="Tax"
                        value="{{request()->query('tax_id')}}">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="input-group input-group-outline my-2">
                  <div class="w-100">
                    <label for="vat_number">Vat Number</label>
                    <div>
                      <input type="text" class="form-control border" name="vat_number" placeholder="Vat Number"
                        value="{{request()->query('vat_number')}}">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="input-group input-group-outline my-2">
                  <div class="w-100">
                    <label for="account_id">Account</label>
                    <div>
                      <input type="text" class="form-control border" name="account_id" placeholder="Account"
                        value="{{request()->query('account_id')}}">
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
            <h5 class="text-capitalize ps-3">Suppliers table</h5>
          </div>
        </div>
        <div class="card-body px-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0 text-sm text-dark">
              <thead>
                <tr>
                  <th>Supplier</th>
                  <th>Contact</th>
                  <th>Currency</th>
                  <th>Tax</th>
                  <th>Account</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($suppliers as $supplier)
                <tr class="rounded">
                  <td>
                    <p>{{ ucwords($supplier->name) }}</p>
                    {{ $supplier->address }}
                  </td>
                  <td>
                    <p>
                      {{ ucwords($supplier->contact_person) }} <br>
                      {{ $supplier->email }} <br>
                      {{ $supplier->phone }}
                    </p>
                  </td>
                  <td>
                    <p>{{ ucwords($supplier->currency->name) }}</p>
                  </td>
                  <td>
                    <p>{{ ucwords($supplier->tax->name) }}</p>
                  </td>
                  <td>
                    <p>{{ $supplier->account->account_number }}</p>
                    <p>Payable: {{ $supplier->payable_account->account_number }}</p>
                  </td>
                  <td>
                    <div class="d-flex flex-row justify-content-center">
                      <a href="{{ route('suppliers.statement', $supplier->id) }}" class="btn btn-info btn-custom"
                        title="Statement Of Account">
                        <i class="fa-solid fa-receipt"></i>
                      </a>

                      <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-warning btn-custom"
                        title="Edit">
                        <i class="fa-solid fa-pen-to-square"></i>
                      </a>
                      @if (auth()->user()->role == 'admin' && $supplier->can_delete())
                      <form method="GET" action="{{ route('suppliers.destroy', $supplier->id) }}">
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
                  <td colspan="6">
                    No Suppliers Found ...
                  </td>
                </tr>
                @endforelse
                <tr>
                  <td colspan="6">{{$suppliers->appends(['name' => request()->query('name'), 'contact_person' =>
                    request()->query('contact_person'), 'email' =>
                    request()->query('email'), 'phone' => request()->query('phone'), 'tax_id' =>
                    request()->query('tax_id'), 'vat_number' =>
                    request()->query('vat_number'), 'account_id' =>
                    request()->query('account_id')])->links()}}</td>
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
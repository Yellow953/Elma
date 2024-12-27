@extends('layouts.app')

@section('title', 'users')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-6 col-md-10 d-flex justify-content-end">
      <button class="btn btn-info py-2 px-3 text-dark ignore-confirm" type="button" id="actionsDropdown"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Actions
      </button>
      <div class="dropdown-menu dropdown-menu-right mt-2" aria-labelledby="actionsDropdown">
        <a class="dropdown-item text-dark" href="{{ route('users.new') }}">New User</a>
        <a class="dropdown-item text-dark" href="{{ route('export.users') }}">Export Users</a>
      </div>
    </div>
    <div class="col-6 col-md-2">
      <div class="d-flex justify-content-end">
        <button class="btn btn-secondary py-2 px-3 mx-2 text-dark ignore-confirm" type="button" id="filterDropdown"
          data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Filter
        </button>
        <div class="dropdown-menu dropdown-menu-right mt-2 p-4" aria-labelledby="filterDropdown" style="width: 300px">
          <h4 class="mb-2">Filter Users</h4>
          <form action="{{ route('users') }}" method="get" enctype="multipart/form-data">
            <div class="input-group input-group-outline my-2">
              <div class="w-100">
                <label for="name">Name</label>
                <div>
                  <input type="text" class="form-control border" name="name" placeholder="Name"
                    value="{{request()->query('name')}}">
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
                      <input type="tel" class="form-control border" name="phone" placeholder="Phone"
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
                    <label for="role">Role</label>
                    <div>
                      <select name="role" class="form-select select2">
                        <option value="">Role</option>
                        <option value="user" {{request()->query('role') == 'user' ? 'selected' : ''}}>User</option>
                        <option value="admin" {{request()->query('role') == 'admin' ? 'selected' : ''}}>Admin</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="input-group input-group-outline my-2">
                  <div class="w-100">
                    <label for="location_id">Location</label>
                    <div>
                      <select name="location_id" class="form-select select2">
                        <option value="">Location</option>
                        @foreach (Helper::get_warehouses() as $warehouse)
                        <option value="{{ $warehouse->id }}" {{request()->query('location_id') == $warehouse->id ?
                          'selected' : ''}}>{{ $warehouse->name }}</option>
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
            <h5 class="text-capitalize ps-3">Users table</h5>
          </div>
        </div>
        <div class="card-body px-0 pb-2 mt-0 pt-0">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0 text-sm text-dark">
              <thead>
                <tr>
                  <th>User</th>
                  <th>Contact</th>
                  <th>Role</th>
                  <th>Location</th>
                  <th>Currency</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @forelse ($users as $user)
                <tr>
                  <td>
                    <div class="d-flex px-2 py-1">
                      <div>
                        <a href="{{asset($user->image)}}"><img src="{{asset($user->image)}}"
                            class="avatar avatar-sm me-3 border-radius-lg" alt="user1"></a>
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm">{{ucwords($user->name)}}</h6>
                      </div>
                    </div>
                  </td>
                  <td>
                    <p>{{$user->email}}</p>
                    <p class="text-xs text-secondary mb-0">{{$user->phone}}</p>
                  </td>
                  <td>
                    <p>{{($user->role == 'admin') ? "Admin" : "User"}}</p>
                  </td>
                  <td>
                    <p>{{ ucwords($user->location->name) }}</p>
                  </td>
                  <td>
                    <p>{{ucwords($user->currency->code)}}</p>
                  </td>
                  <td class="align-middle">
                    @if ($user->can_delete())
                    <form method="GET" action="{{ route('users.destroy', $user->id) }}">
                      @csrf
                      <button type="submit" class="btn btn-danger show_confirm btn-custom" data-toggle="tooltip"
                        title='Delete'>
                        <i class="fa-solid fa-trash"></i>
                      </button>
                    </form>
                    @endif
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="6">No Users Found</td>
                </tr>
                @endforelse
                <tr>
                  <td colspan="6">{{$users->appends(['name' => request()->query('name'), 'email' =>
                    request()->query('email'), 'phone' => request()->query('phone'), 'role' =>
                    request()->query('role'), 'location_id' => request()->query('location_id')])->links()}}</td>
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
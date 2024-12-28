@extends('layouts.app')

@section('title', 'users')

@section('actions')
@can('users.create')
<a class="btn btn-sm btn-info mx-2" href="{{ route('users.new') }}">New User</a>
@endcan
@can('users.export')
<a class="btn btn-sm btn-info mx-2" href="{{ route('users.export') }}">Export Users</a>
@endcan
@endsection

@section('filter')
<button class="btn btn-secondary py-2 px-3 mx-2 text-dark ignore-confirm" type="button" id="filterDropdown"
    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Filter
</button>
<div class="dropdown-menu dropdown-menu-right mt-2 p-4" aria-labelledby="filterDropdown" style="width: 300px">
    <h4 class="mb-2">Filter Users</h4>
    <form action="{{ route('users') }}" method="get" enctype="multipart/form-data">
        @csrf

        <div class="input-group input-group-outline my-2">
            <div class="w-100">
                <label for="name">Name</label>
                <div>
                    <input type="text" class="form-control border" name="name" placeholder="Name"
                        value="{{request()->query('name')}}">
                </div>
            </div>
        </div>
        <div class="input-group input-group-outline my-2">
            <div class="w-100">
                <label for="email">Email</label>
                <div>
                    <input type="email" class="form-control border" name="email" placeholder="Email"
                        value="{{request()->query('email')}}">
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
                        <h5 class="text-capitalize ps-3">Users table</h5>
                    </div>
                </div>
                <div class="card-body px-0 pb-2 mt-0 pt-0">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0 text-sm text-dark">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Email</th>
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
                                                <img src="{{ asset('assets/images/default_profile.png') }}"
                                                    class="avatar avatar-sm me-3 border-radius-lg">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ucwords($user->name)}}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p>{{$user->email}}</p>
                                    </td>
                                    <td>
                                        <p>{{ucwords($user->currency->code)}}</p>
                                    </td>
                                    <td class="d-flex justify-content-center">
                                        @can('users.update')
                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning
                                        btn-custom" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        @endcan

                                        @can('users.delete')
                                        <form method="GET" action="{{ route('users.destroy', $user->id) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-danger show_confirm btn-custom"
                                                data-toggle="tooltip" title='Delete'>
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4">No Users Found</td>
                                </tr>
                                @endforelse
                                <tr>
                                    <td colspan="4">{{ $users->appends(request()->all())->links() }}</td>
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

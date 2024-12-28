@extends('layouts.app')

@section('title', 'profile')

@section('sub-title', 'show')

@section('content')
<div class="container-fluid px-2 px-md-4">
    <div class="page-header min-height-300 border-radius-xl mt-4"
        style="background-image: url({{asset('/assets/images/warehouse.png')}});"></div>
    <div class="card card-body mx-3 mx-md-4 mt-n6">
        <div class="row">
            <div class="col-md-6 my-auto">
                <div class="row mb-2">
                    <div class="col-auto">
                        <div class="h-100">
                            <img src="{{ asset('assets/images/default_profile.png') }}" alt="profile_image"
                                class="w-100 border-radius-lg shadow-sm profile-pic">
                        </div>
                    </div>
                    <div class="col-auto my-auto">
                        <ul class="list-group">
                            <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">{{
                                    ucwords($user->name)
                                    }}</strong></li>
                            <li class="list-group-item border-0 ps-0 text-sm">
                                <a href="{{ route('profile.edit') }}" class="link-text text-info text-sm">Edit
                                    Profile</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 my-auto">
                <div class="card card-plain h-100">
                    <div class="card-header pb-0 p-3">
                        <h5 class="mb-0">Profile Information : </h5>
                    </div>
                    <div class="card-body p-3">
                        <ul class="list-group">
                            <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Full
                                    Name:</strong>
                                &nbsp; {{ ucwords($user->name) }}</li>
                            <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Email:</strong>
                                &nbsp;
                                {{$user->email}}</li>
                            <li class="list-group-item border-0 ps-0 text-sm"><strong
                                    class="text-dark">Currency:</strong>
                                &nbsp; {{
                                ucwords($user->currency->name) }}</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

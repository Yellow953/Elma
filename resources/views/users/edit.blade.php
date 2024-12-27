@extends('layouts.app')

@section('title', 'users')

@section('sub-title', 'edit')

@section('content')
<div class="container-fluid px-2 px-md-4">
  <div class="page-header min-height-300 border-radius-xl mt-4"
    style="background-image: url({{asset('/assets/images/warehouse.png')}});"></div>
  <div class="card card-body mx-3 mx-md-4 mt-n6">
    <div class="row">
      <div class="col-md-6">
        <div class="card card-plain h-100 align-items-center">
          <div class="card-header">
            <h5 class="mb-0"><u><i>Edit Profile</i></u></h5>
          </div>

          <div class="card-body">
            <form action="{{ route('profile.update', auth()->user()->id) }}" method="post"
              enctype="multipart/form-data">
              @csrf
              <div class="row input-group input-group-outline my-3">
                <div class="col-6">
                  <label for="name">Name *</label>
                </div>
                <div class="col-6">
                  <input type="text" class="form-control" name="name" value="{{$user->name}}" required>
                </div>
              </div>

              <div class="row input-group input-group-outline my-3">
                <div class="col-6">
                  <label for="phone">Phone Number *</label>
                </div>
                <div class="col-6">
                  <input type="number" class="form-control" name="phone" value="{{$user->phone}}" required min="0">
                </div>
              </div>

              <div class="row input-group input-group-outline my-3">
                <div class="col-6">
                  <label for="image">Image</label>
                </div>
                <div class="col-6">
                  <input type="file" class="w-100" name="image" value="{{$user->image}}">
                </div>
              </div>

              <div class="row input-group input-group-outline my-3">
                <div class="col-6">
                  <label for="currency_id">Currency *</label>
                </div>
                <div class="col-6">
                  <select name="currency_id" id="currency_id" class="form-select select2" required>
                    @foreach (Helper::get_currencies() as $currency)
                    <option value="{{ $currency->id }}" {{ $user->currency_id == $currency->id ? 'selected' : '' }}>{{
                      $currency->code }}</option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="row mt-4">
                <div class="offset-md-8 col-md-4">
                  <button type="submit" class="btn btn-info w-100">
                    {{ __('Update') }}
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card card-plain h-100 align-items-center">
          <div class="card-header">
            <h5 class="mb-0"><u><i>Change Password:</i></u></h5>
          </div>

          <div class="card-body">
            <form action="{{ route('profile.SavePassword', auth()->user()->id) }}" method="post"
              enctype="multipart/form-data">
              @csrf
              <div class="row input-group input-group-outline my-3">
                <div class="col-6">
                  <label for="newpassword">New Password *</label>
                </div>
                <div class="col-6">
                  <input type="password" class="form-control" name="newpassword" required>
                </div>
              </div>

              <div class="row input-group input-group-outline my-3">
                <div class="col-6">
                  <label for="confirmpassword">Confirm Password *</label>
                </div>
                <div class="col-6">
                  <input type="password" class="form-control" name="confirmpassword" required>
                </div>
              </div>

              <div class="row mt-4">
                <div class="offset-md-8 col-md-4">
                  <button type="submit" class="btn btn-info w-100">
                    {{ __('Update') }}
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
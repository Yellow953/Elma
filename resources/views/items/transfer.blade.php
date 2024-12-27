@extends('layouts.app')

@section('title', 'items')

@section('sub-title', 'transfer')

@section('content')
<div class="main-content position-relative max-height-vh-100 h-100">
  <div class="d-flex justify-content-around">
    <a href="{{ route('tro.new') }}" class="btn btn-info px-3 py-2">New TRO</a>
  </div>

  <div class="container-fluid px-2 px-md-4">
    <div class="page-header min-height-300 border-radius-xl"
      style="background-image: url({{asset('/assets/images/warehouse.png')}});"></div>
    <div class="card card-body mx-3 mx-md-4 mt-n6 pt-0">
      <div class="row">
        <div class="col-12">
          <div class="card card-plain h-100 align-items-center">
            <div class="card-header py-2 p-2 w-100">
              <h4 class="text-center"><u><i>Item Transfer</i></u></h4>
            </div>

            <div class="card-body w-100 p-1">
              <form action="{{ route('items.TransferSave', $item->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                  <div class="offset-md-3 col-md-3 d-flex justify-content-center">
                    <img src="{{asset($item->image)}}" alt="" class="profile-pic border-radius-lg shadow-sm">
                  </div>
                  <div class="col-md-6">
                    <div class="input-group input-group-outline my-2">
                      <label for="name">Name : </label>
                      <span class="mx-2 text small">{{ucwords($item->name)}}</span>
                    </div>

                    <div class="input-group input-group-outline my-2">
                      <label for="quantity">Quantity : </label>
                      <span class="mx-2 text small">{{number_format($item->quantity, 2)}}</span>
                    </div>

                    <div class="input-group input-group-outline my-2">
                      <label for="itemcode">Item Code : </label>
                      <span class="mx-2 text small">{{$item->itemcode}}</span>
                    </div>

                    <div class="input-group input-group-outline my-2">
                      <label for="description">Description : </label>
                      <span class="mx-2 text small">{{$item->description}}</span>
                    </div>

                    <div class="input-group input-group-outline my-2">
                      <label for="description">Warehouse : </label>
                      <span class="mx-2 text small">{{ucwords($item->warehouse->name)}}</span>
                    </div>
                  </div>
                </div>

                <div class="row input-group input-group-outline my-2">
                  <div class="offset-md-3 col-md-3">
                    <label for="tro_id">TRO *</label>
                  </div>
                  <div class="col-md-3">
                    <select name="tro_id" id="tro_id" class="form-select select2" required>
                      <option value=""></option>
                      @foreach ($tros as $tro)
                      <option value="{{ $tro->id }}" {{ $tro->id == old('tro_id') ?
                        'selected':'' }}>{{ $tro->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="row input-group input-group-outline my-2">
                  <div class="offset-md-3 col-md-3">
                    <label for="quantity">Quantity *</label>
                  </div>
                  <div class="col-md-3">
                    <input type="number" step="any" class="form-control" name="quantity" required min="0">
                  </div>
                </div>

                <div class="row mt-4">
                  <div class="offset-md-8 col-md-2">
                    <button type="submit" class="btn btn-info w-100">
                      {{ __('Save') }}
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
</div>

@endsection
@extends('layouts.app')

@section('title', 'items')

@section('sub-title', 'out')

@section('content')
<div class="main-content position-relative max-height-vh-100 h-100">
    <div class="d-flex justify-content-around">
        <a href="{{ route('so.new') }}" class="btn btn-info px-3 py-2">New SO</a>
    </div>

    <div class="container-fluid px-2 px-md-4">
        <div class="page-header min-height-300 border-radius-xl"
            style="background-image: url({{asset('/assets/images/warehouse.png')}});"></div>
        <div class="card card-body mx-3 mx-md-4 mt-n6 pt-0">
            <div class="row">
                <div class="col-12">
                    <div class="card card-plain h-100 align-items-center">
                        <div class="card-header py-2 p-2 w-100">
                            <h4 class="text-center"><u><i>Item OUT</i></u></h4>
                        </div>

                        <div class="card-body w-100 p-1">
                            <form action="{{ route('items.OutSave', $item->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="offset-md-3 col-md-3 d-flex justify-content-center">
                                        <img src="{{asset($item->image)}}" alt=""
                                            class="profile-pic border-radius-lg shadow-sm">
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
                                        <label for="so_id">SO *</label>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="so_id" id="so_id" class="form-select select2" required>
                                            <option value=""></option>
                                            @foreach ($sos as $so)
                                            <option value="{{ $so->id }}" {{ $so->id == old('so_id') ?
                                                'selected':'' }}>{{ $so->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row input-group input-group-outline my-2">
                                    <div class="offset-md-3 col-md-3">
                                        <label for="quantity">Quantity *</label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" step="any" class="form-control" name="quantity" required
                                            min="0">
                                    </div>
                                </div>

                                <div class="d-flex align-items-center justify-content-around mt-3">
                                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
                                    <button type="submit" class="btn btn-info">Submit</button>
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

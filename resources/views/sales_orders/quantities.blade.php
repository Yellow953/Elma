@extends('layouts.app')

@section('title', 'so')

@section('sub-title', 'quantities')

@section('content')
<div class="container-fluid">
    <h2 class="text-center mx-5 my-3">SO Quantities</h2>
    <div class="text-center card px-2 px-md-5 py-3">
        <div class="card-header">
            <h3>{{$so->name}}</h3>
        </div>
        <div class="alert alert-info m-1">
            <div class="row w-100">
                <div class="col-4">
                    <h5>Itemcode</h5>
                </div>
                <div class="col-4">
                    <h5 class="text-dark">SO Quantity</h5>
                </div>
                <div class="col-4">
                    <h5 class="text-dark">Stock Value</h5>
                </div>

            </div>
        </div>
        @forelse ($so_items as $so_item)
        <div class="alert alert-light m-1">
            <div class="row w-100">
                <div class="col-4">
                    <h5>{{ $so_item->item->itemcode }}</h5>
                </div>
                <div class="col-4">
                    <h5>{{ $so_item->quantity }}</h5>
                </div>
                <div class="col-4">
                    <h5 class="text-secondary">{{ $so_item->item->quantity }}</h5>
                </div>
            </div>
        </div>
        @empty
        No SO Items yet
        @endforelse
    </div>
</div>
@endsection
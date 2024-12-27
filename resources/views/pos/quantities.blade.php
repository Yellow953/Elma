@extends('layouts.app')

@section('title', 'po')

@section('sub-title', 'quantities')

@section('content')
<div class="container-fluid">
    <h2 class="text-center mx-5 my-3">PO Quantities</h2>
    <div class="text-center card px-2 px-md-5 py-3">
        <div class="card-header">
            <h3>{{$po->name}}</h3>
        </div>
        <div class="alert alert-info m-1">
            <div class="row w-100">
                <div class="col-4">
                    <h5>Itemcode</h5>
                </div>
                <div class="col-4">
                    <h5 class="text-dark">PO Quantity</h5>
                </div>
                <div class="col-4">
                    <h5 class="text-dark">Stock Value</h5>
                </div>
            </div>
        </div>
        @forelse ($po_items as $po_item)
        <div class="alert alert-light m-1">
            <div class="row w-100">
                <div class="col-4">
                    <h5>{{ $po_item->item->itemcode }}</h5>
                </div>
                <div class="col-4">
                    <h5>{{ $po_item->quantity }}</h5>
                </div>
                <div class="col-4">
                    <h5 class="text-secondary">{{ $po_item->item->quantity }}</h5>
                </div>
            </div>
        </div>
        @empty
        No PO Items yet
        @endforelse
    </div>
</div>
@endsection